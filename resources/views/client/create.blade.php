@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Nueva Reservación</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Cliente</a></li>
                        <li class="breadcrumb-item active">Reservaciones</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Crear Reservación</h4>
                </div>
                <div class="card-body">
                    <form class="row g-3 needs-validation" id="reservationForm" novalidate>
                        @csrf
                        <!-- users -->
                        <div class="col-md-3">
                            <label for="user" class="form-label">{{ __('Usuario') }}</label>
                            <input id="user" type="text" class="form-control @error('user_id') is-invalid @enderror" value="{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}" readonly>
                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                        </div>
                        <!-- consultants -->
                        <div class="col-md-3">
                            <label for="consultant_id" class="form-label">{{ __('Asesor') }}</label>
                            <select class="form-select js-example-basic-single @error('consultant_id') is-invalid @enderror"
                                    id="consultant_id" name="consultant_id" required>
                                <option value="" disabled selected>Seleccione un Asesor</option>
                                @foreach ($consultants as $consultant)
                                    <option value="{{ $consultant->id }}" {{ old('consultant_id') == $consultant->id ? 'selected' : '' }}>
                                        {{ $consultant->nombres }} {{ $consultant->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            @error('consultant_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Fecha de Resevación -->
                        <div class="col-md-3">
                            <label for="reservation_date" class="form-label">{{ __('Fecha de Reservación') }}</label>
                            <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" id="reservation_date" name="reservation_date" required>
                            @error('reservation_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Hora de Inicio -->
                        <div class="col-md-3">
                            <label for="start_time" class="form-label">{{ __('Hora de Inicio') }}</label>
                            <select class="form-select @error('start_time') is-invalid @enderror" id="start_time" name="start_time" required>
                                <option value="" disabled selected>Seleccione una hora</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                            </select>
                            @error('start_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Hora de Fin -->
                        <div class="col-md-3">
                            <label for="end_time" class="form-label">{{ __('Hora de Fin') }}</label>
                            <input type="text" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" placeholder="Esperando Hora de Inicio" required readonly>
                            @error('end_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Estado de la Reservación -->
                        <div class="col-md-3">
                            <label for="reservation_status" class="form-label">{{ __('Estado de Reservación') }}</label>
                            <select class="form-select js-example-basic-single @error('reservation_status') is-invalid @enderror" id="reservation_status" name="reservation_status" required>
                                <option value="" disabled selected>Seleccione un Estado</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="pendiente">Pendiente</option>
                            </select>
                            @error('reservation_status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Total a Pagar -->
                        <div class="col-md-3">
                            <label for="total_amount" class="form-label">{{ __('Total a Pagar') }}</label>
                            <input type="text" class="form-control @error('total_amount') is-invalid @enderror" id="total_amount" name="total_amount" placeholder="Esperando Hora de Inicio" required readonly>
                            @error('total_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Estado de Pago -->
                        <div class="col-md-3">
                            <p class="form-label fw-bold d-block mb-2">{{ __('Método de Pago') }}</p>
                            <div id="paypal-button-container"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://www.paypal.com/sdk/js?client-id=client-id"></script>

    <script>
        /* reservation_date */
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('reservation_date').setAttribute('min', today);

        const pricePerHour = 50.00; // Precio por hora

        /* Start_time, calcular hora de fin y total */
        document.getElementById('start_time').addEventListener('change', function() {
            const startTime = this.value;

            if (startTime) {
                // Convertir la hora de inicio a un objeto Date
                const startDate = new Date(`1970-01-01T${startTime}:00`);
                // Sumar 1 hora
                startDate.setHours(startDate.getHours() + 1);
                // Obtener la hora de fin en formato HH:mm
                const endTime = startDate.toTimeString().slice(0, 5);
                // Asignar la hora de fin al campo correspondiente
                document.getElementById('end_time').value = endTime;

                // Calcular el total a pagar
                const total = pricePerHour; // Precio por hora
                document.getElementById('total_amount').value = total.toFixed(2); // Mostrar el total en el campo correspondiente
            }else {
                // Si no se selecciona una hora de inicio, limpiar los campos de fin y total
                document.getElementById('end_time').value = '';
                document.getElementById('total_amount').value = '0.00'
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            let consultantId, reservationDate, startTime, endTime, reservationStatus, totalAmount;
            paypal.Buttons({
                createOrder: function(data, actions) {
                    consultantId = document.getElementById('consultant_id').value;
                    reservationDate = document.getElementById('reservation_date').value;
                    startTime = document.getElementById('start_time').value;
                    endTime = document.getElementById('end_time').value;
                    reservationStatus = document.getElementById('reservation_status').value;
                    totalAmount = document.getElementById('total_amount').value;

                    if (!consultantId || !reservationDate || !startTime || !endTime || !reservationStatus || !totalAmount) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Faltan Campos Obligatorios',
                            text: '¡Algunos datos están incompletos. Verifica e intenta nuevamente!',
                            showConfirmButton: false,
                            timer: 3000,
                        });
                        return Promise.reject();
                    }
                    return actions.order.create({
                        purchase_units : [{
                            amount : {
                                value : totalAmount
                            }
                        }]
                    })
                },
                onApprove : function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        // Lógica después de que se captura el pago
                        return fetch('/paypal', {
                            method: 'post',
                            headers: {
                                'content-type': 'application/json',
                                'X-CSRF-TOKEN' : '{{ csrf_token() }}',
                            },
                            body : JSON.stringify({
                                orderID : data.orderID,
                                details : details,
                                user_id : {{ auth()->user()->id }},
                                consultant_id : consultantId,
                                reservation_date : reservationDate,
                                start_time : startTime,
                                end_time : endTime,
                                total_amount : totalAmount,
                            })
                        }).then(function (response) {
                            if (response.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pago Completado',
                                    text: 'Pago y Reservación creada correctamente',
                                }).then(function () {
                                    window.location.href = '/client';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error en el pago',
                                    text: 'Ocurrió un problema al procesar el pago. Intenta nuevamente.',
                                });
                            }
                        }).catch(function(error){
                            console.error('Error en la solicitud:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error inesperado',
                                text: 'No se pudo conectar con el servidor.',
                            });
                        });
                    });
                },
            }).render('#paypal-button-container');
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({});
        });
    </script>
@endpush