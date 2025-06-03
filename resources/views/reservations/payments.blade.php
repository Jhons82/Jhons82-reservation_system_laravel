@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pagos</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Administrador</a></li>
                        <li class="breadcrumb-item active">Reservacioness</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Registro de Pagos</h5>
                    {{-- <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-label waves-effect waves-light rounded-pill"><i class="ri-user-smile-line label-icon align-middle rounded-pill fs-16 me-2"></i> Nueva Reservación</a> --}}
                </div>
                <div class="card-body">
                    <table id="paymentsTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Asesor</th>
                                <th>Fecha / H. Inicio-Fin</th>
                                <th>ID Transacción</th>
                                <th>ID Pagador</th>
                                <th>Correo Pagador</th>
                                <th>Estado</th>
                                <th>Pagos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>
                                        <small class="text-primary">
                                            {{ $payment->reservation->user->nombres }}
                                            <cite title="Usuario">{{ $payment->reservation->user->apellidos }}</cite>
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-success">
                                            {{ $payment->reservation->consultant->nombres }}
                                            <cite title="Consultor">{{ $payment->reservation->consultant->apellidos }}</cite>
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($payment->reservation->reservation_date)->format('d/m/Y') }} /
                                            {{ \Carbon\Carbon::parse($payment->reservation->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($payment->reservation->end_time)->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="{{ $payment->reservation->payment_badge_class }}">{{ $payment->transaction_id }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ $payment->reservation->reservation_badge_class }}">{{ $payment->payer_id }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $payment->payer_email }}</small>
                                    </td>
                                    <td>
                                        <span class="{{ $payment->reservation->reservation_badge_class }}">{{ $payment->reservation->reservation_status }}</span>
                                    </td>
                                    <td>{{ $payment->amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#paymentsTable').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                }
            });
        });

        $(document).on('click','.btn-cancel', function(e) {
            e.preventDefault();
            var reservationId = $(this).data('id');
            
            Swal.fire({
                title: "Cancelar Reservación",
                text: "Por favor, ingresa el motivo de la cancelación",
                icon: "warning",
                input: "textarea",
                inputPlaceholder: "Escribe el motivo de la cancelación...",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Cancelar Reservación",
                cancelButtonText: "Cerrar",
                preConfirm: (cancellationReason) => {
                    if (!cancellationReason) {
                        Swal.showValidationMessage('Es necesario ingresar un motivo de cancelación');
                        return false;
                    } else {
                        return new Promise((resolve, reject) => {
                            $.ajax({
                                url: "{{ route('reservations.cancel') }}", // Ruta para cancelar la reserva
                                method: "POST", // Método POST para enviar la solicitud
                                data: {
                                    _token: "{{ csrf_token() }}", // Token CSRF para la seguridad de Laravel
                                    reservation_id: reservationId, // ID de la reserva
                                    cancellation_reason: cancellationReason, // Razón de la cancelación
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Reservación Cancelada',
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 3000
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'error',
                                            text: response.message,
                                            showConfirmButton: true,
                                        });
                                    }
                                    resolve();
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Ocurrió un error al cancelar la reservación. Por favor, inténtalo de nuevo.',
                                        showConfirmButton: true,
                                    });
                                    reject();
                                }
                            });
                        });
                    }
                }
            });
        })
    </script>
    @if (session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
            }).showToast();
        </script>
        
    @endif
@endpush

