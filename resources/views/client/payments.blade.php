@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pagos</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">cliente</a></li>
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
                    {{-- <a href="{{ route('client.create') }}" class="btn btn-primary btn-label waves-effect waves-light rounded-pill"><i class="ri-user-smile-line label-icon align-middle rounded-pill fs-16 me-2"></i> Nueva Reservación</a> --}}
                </div>
                <div class="card-body">
                    <table id="paymentsClientTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
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
            $('#paymentsClientTable').DataTable({
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
    </script>
@endpush

