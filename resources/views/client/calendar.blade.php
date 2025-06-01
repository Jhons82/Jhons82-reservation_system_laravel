@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">calendario</h4>

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
                    <h4 class="card-title mb-0 flex-grow-1">Calendario de Reservaciones</h4>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                    <div class="modal fade" id="eventModalCalendar" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header p-3 bg-soft-info">
                                    <h5 class="modal-title" id="modal-title"></h5>
                                    <p id="modal-id"></p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- date -->
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-calendar-event-line text-muted fs-16 me-2"></i>
                                        <span class="fw-semibold me-1">Estado: </span>
                                        <span class="text-muted" id="modal-date"></span>
                                    </div>
                                    <!-- time_range -->
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-time-line text-muted fs-16 me-2"></i>
                                        <span class="fw-semibold me-1">Hora: </span>
                                        <span class="text-muted" id="modal-time"></span>
                                    </div>
                                    <!-- reservation_status -->
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-reserved-line text-muted fs-16 me-2"></i>
                                        <span class="fw-semibold me-1">Estado de Reservación: </span>
                                        <span id="modal-status"></span>
                                    </div>
                                    <!-- payment_status -->
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-secure-payment-line text-muted fs-16 me-2"></i>
                                        <span class="fw-semibold me-1">Pago: </span>
                                        <span id="modal-payment"></span>
                                    </div>
                                    <!-- total_amount -->
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-currency-line text-muted fs-16 me-2"></i>
                                        <span class="fw-semibold me-1">Monto: </span>
                                        <span class="text-muted" id="modal-total"></span>
                                    </div>
                                    <!-- Cancellation_reason -->
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-discuss-line text-muted fs-16 me-2"></i>
                                        <span class="fw-semibold me-1">Motivo de Cancelación: </span>
                                        <span class="text-danger" id="modal-cancel"></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-soft-danger" data-bs-dismiss="modal"><i class="ri-close-line align-bottom"></i> Cerrar</button>
                                        <a href="{{ route('client.index') }}" id="verReservacionesBtn" class="btn btn-soft-primary"><i class="ri-eye-line"></i> Ver Reservaciones</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Elementos principales
            const modalElement = document.getElementById('eventModalCalendar');
            const calendarEl = document.getElementById('calendar');

            // Salir si no hay calendario
            if (!calendarEl) return;

            // Limpia el foco al cerrar el modal
            if (modalElement) {
                modalElement.addEventListener('hide.bs.modal', () => {
                    if (document.activeElement && modalElement.contains(document.activeElement)) {
                        document.activeElement.blur();
                    }
                });
            }

            // Mapeo de clases para el header según estado
            const headerClassMap = {
                Confirmada: 'bg-soft-info',
                Cancelada: 'bg-soft-danger',
                default: 'bg-soft-success',
            };

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                timeZone: 'America/Mexico_City',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                },
                events: {
                    url: '{{ route('reservationsClient.data') }}',
                    method: 'GET',
                    failure() {
                        alert('¡Hubo un error al obtener eventos!');
                    },
                },
                eventDidMount(info) {
                    if (info.event.backgroundColor) {
                        info.el.style.backgroundColor = info.event.backgroundColor;
                    }
                },
                eventClick(info) {
                    const { title, id, extendedProps, start } = info.event;
                    const status = extendedProps.reservation_status;
                    const modal = new bootstrap.Modal(document.getElementById('eventModalCalendar'));

                    requestAnimationFrame(() => {
                        const modalElements = {
                            title: document.getElementById('modal-title'),
                            date: document.getElementById('modal-date'),
                            time: document.getElementById('modal-time'),
                            status: document.getElementById('modal-status'),
                            payment: document.getElementById('modal-payment'),
                            total: document.getElementById('modal-total'),
                            cancel: document.getElementById('modal-cancel'),
                            header: document.querySelector('.modal-header'),
                        };

                        modalElements.title.textContent = `${title} - N° Reservación: ${id}`;
                        modalElements.date.textContent = new Date(start).toLocaleDateString('es-ES', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        modalElements.time.textContent = extendedProps.time_range;

                        modalElements.status.textContent = status;
                        modalElements.status.className = '';
                        modalElements.status.classList.add(...extendedProps.badge_class.split(' '));

                        const headerClasses = ['bg-soft-info', 'bg-soft-danger', 'bg-soft-success'];
                        const classMap = {
                            Confirmada: 'bg-soft-info',
                            Cancelada: 'bg-soft-danger',
                            default: 'bg-soft-success',
                        };
                        const newClass = classMap[status] || classMap.default;

                        if (!modalElements.header.classList.contains(newClass)) {
                            headerClasses.forEach(c => modalElements.header.classList.remove(c));
                            modalElements.header.classList.add(newClass);
                        }

                        modalElements.payment.textContent = extendedProps.payment_status;
                        modalElements.payment.className = '';
                        modalElements.payment.classList.add(...extendedProps.payment_badge_class.split(' '));

                        modalElements.total.textContent = `$${extendedProps.total_amount}`;

                        const reason = extendedProps.cancellation_reason;
                        modalElements.cancel.textContent = reason ? reason : 'No hay registro.';
                        modalElements.cancel.classList.toggle('text-muted', !reason);

                        modal.show();
                    });
                }
            });
            calendar.render();
        });


    </script>
    
    {{-- <script>
        document.getElementById('verReservacionesBtn').addEventListener('click', function (e) {
            e.preventDefault();
            const modal = bootstrap.Modal.getInstance(document.querySelector('#eventModalCalendar')); // Usa el ID real de tu modal
            modal.hide();
            setTimeout(function () {
                window.location.href = "{{ route('client.index') }}";
            }, 300);
        });
    </script> --}}
@endpush