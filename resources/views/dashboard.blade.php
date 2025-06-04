@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Bienvenido, {{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}!</h4>
                                <p class="text-muted mb-0">Este es el estado actual.</p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group">
                                                <input type="text" class="form-control border-0 dash-filter-picker shadow" data-provider="flatpickr" data-range-date="true" data-date-format="d M, Y" data-deafult-date="{{ \Carbon\Carbon::now()->format('d M, Y') }} to {{ \Carbon\Carbon::now()->format('d M, Y') }}" id="dateRange">
                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-auto">
                                            @auth
                                                @php
                                                    $rol = Auth::user()->rol_id;
                                                @endphp

                                                @if ($rol === 1)
                                                    <a href="{{ route('reservations.create') }}" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i> Crear Reservación</a>
                                                @elseif ($rol === 3)
                                                    <a href="{{ route('client.create') }}" class="btn btn-soft-success"><i class="ri-add-circle-line align-middle me-1"></i> Crear Reservación</a>
                                                @endif
                                            @endauth
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
                @auth
                    @php
                        $rol = Auth::user()->rol_id;
                    @endphp
                    <div class="row">
                        <!-- total de reservaciones -->
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            @if ($rol === 1)
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total general de Reservaciones</p>
                                            @else
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Todas mis Reservaciones</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        @if (!is_null($totalReservations))
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                    <span class="counter-value" data-target="{{ $totalReservations }}">0</span> reservaciones
                                                </h4>
                                                @if ($rol === 3)
                                                    <a href="{{ route('client.index') }}" class="text-decoration-underline">Ver Reservaciones</a>
                                                @elseif ($rol === 1)
                                                    <a href="{{ route('reservations.index') }}" class="text-decoration-underline">Ver Reservaciones</a>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-success rounded fs-3">
                                                <i class="ri-stack-line text-success"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Reservaciones por fecha -->
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            @if ($rol === 1)
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total de Reservaciones por hoy</p>
                                            @else
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Mis Reservaciones por hoy</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $totalCurrent }}">0</span> disponibles</h4>
                                            @if ($rol === 1)
                                                <a href="{{ route('reservations.calendar') }}" class="text-decoration-underline">Ver Calendario</a>
                                            @elseif ($rol === 3)
                                                <a href="{{ route('client.calendar') }}" class="text-decoration-underline">Ver mi Calendario</a>
                                            @endif
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-primary rounded fs-3">
                                                <i class="ri-calendar-check-line text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                        <!-- Total general de clientes  -->
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total general de Clientes</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $totalClientsAssets }}">0</span> clientes</h4>
                                            @if ($rol === 1)
                                                <a href="{{ route('usuarios.index') }}" class="text-decoration-underline">Ver Usuarios</a>
                                            @elseif ($rol == 3)
                                                <a href="{{ route('client.index') }}" class="text-decoration-underline">Ver Reservaciones</a>
                                            @endif
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-info rounded fs-3">
                                                <i class="ri-user-3-line text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                        <!-- Total general de asesores -->
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total general de Asesores</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $totalAdvisersAssets }}">0</span> asesores</h4>
                                            @if ($rol === 1)
                                                <a href="{{ route('usuarios.index') }}" class="text-decoration-underline">Ver Usuarios</a>
                                            @elseif ($rol == 3)
                                                <a href="{{ route('client.index') }}" class="text-decoration-underline">Ver Reservaciones</a>
                                            @endif
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-warning rounded fs-3">
                                                <i class="ri-user-voice-line text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "d M, Y",
            defaultDate: [
                "{{ \Carbon\Carbon::now()->format('d M, Y') }}",
                "{{ \Carbon\Carbon::now()->format('d M, Y') }}"
            ],
            onChange: function(selectedDates, dateStr, instance) {
                // Aquí puedes capturar los valores de fecha y hacer un fetch o submit para filtrar
                console.log('Fecha seleccionada:', dateStr); // ej: "04 Jun, 2025 to 05 Jun, 2025"
            }
        });
    </script>
@endpush