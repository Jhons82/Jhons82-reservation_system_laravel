@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Consultar Reservaciones</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Reservaciones</a></li>
                        <li class="breadcrumb-item active">Lista de Reservaciones</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Registro de Reservaciones</h5>
                    <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-label waves-effect waves-light rounded-pill"><i class="ri-user-smile-line label-icon align-middle rounded-pill fs-16 me-2"></i> Nueva Reservación</a>
                </div>
                <div class="card-body">
                    <table id="reservationsTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Consultor</th>
                                <th>Fecha</th>
                                <th>H. Inicio</th>
                                <th>H. Fin</th>
                                <th>Estado de Pago</th>
                                <th>Estado de Reservación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->user->nombres }} {{ $reservation->user->apellidos }}</td>
                                    <td>{{ $reservation->consultant->nombres }} {{ $reservation->consultant->apellidos }}</td>
                                    <td>{{ $reservation->reservation_date }}</td>
                                    <td>{{ $reservation->start_time }}</td>
                                    <td>{{ $reservation->end_time }}</td>
                                    <td>
                                        <span class="{{ $reservation->payment_badge_class }}">{{ $reservation->payment_status }}</span>
                                    </td>
                                    <td><span class="{{ $reservation->reservation_badge_class }}">{{ $reservation->reservation_status }}</span></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm btn-label waves-effect waves-light rounded-pill"><i class="ri-edit-box-line label-icon align-middle rounded-pill fs-16 me-2"></i>Editar</a>
                                        <button type="submit" class="btn btn-danger btn-sm btn-label waves-effect waves-light rounded-pill"><i class="ri-delete-bin-line label-icon align-middle rounded-pill fs-16 me-2"></i>Cancelar</button>
                                        <form id="" action="" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
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
            $('#reservationsTable').DataTable({
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