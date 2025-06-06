<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

    <head>

        <meta charset="utf-8" />
        <title>Landing | J-GOD - Sistema de Reservaciones</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/logo_vf.png') }}">

        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet" />

        <!--Swiper slider css-->
        <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Layout config Js -->
        <script src="{{ asset('assets/js/layout.js') }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    </head>

    <body data-bs-spy="scroll" data-bs-target="#navbar-example">
        <!-- Begin page -->
        <div class="layout-wrapper landing">
            <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
                <div class="container">
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('assets/images/logo_name_black.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="25">
                        <img src="{{ asset('assets/images/logo_name_black.png') }}" class="card-logo card-logo-light" alt="logo light" height="25">
                    </a>
                    <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                        </ul>

                        <div class="">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-success">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-link fw-medium text-decoration-none text-dark"> Iniciar Sesión</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-primary">Registrate</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>

                </div>
            </nav>
            <!-- end navbar -->

            <!-- start hero section -->
            <section class="section pb-0 hero-section" id="hero">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container">
                    <div class="row justify-content-center mt-3">
                        <div class="col-lg-12 col-sm-10">
                            <div class="d-flex p-3 align-items-center">
                                <div class="flex-shrink-0 d-flex align-items-center">
                                <div class="avatar-sm icon-effect">
                                    <div class="avatar-title bg-transparent text-success rounded-circle d-flex justify-content-center align-items-center" style="width:48px; height:48px;">
                                    <i class="ri-calendar-check-line fs-36"></i>
                                    </div>
                                </div>
                                </div>
                                <div class="flex-grow-1">
                                <h5 class="fs-16 mb-0">Calendario de reservaciones</h5>
                                </div>
                            </div>
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
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
                <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                        <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                            <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                            </path>
                        </g>
                    </svg>
                </div>
                <!-- end shape -->
            </section>
            <!-- end hero section -->

            <!-- start services -->
            <section class="section" id="services">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h1 class="mb-3 ff-secondary fw-semibold lh-base">Respaldados por la confianza y recomendación de <span class="text-primary text-decoration-underline">nuestros clientes</span></h1>
                                <p class="text-muted">Nuestro compromiso se basa en ofrecer un servicio de excelencia, a cargo de profesionales especializados que trabajan con ética, responsabilidad y dedicación en cada atención.</p>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row g-3">
                        <!-- Reserva fácil y rápida -->
                        <div class="col-lg-4">
                            <div class="d-flex p-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle">
                                            <i class="ri-calendar-check-line fs-36"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-18">Reserva fácil y rápida</h5>
                                    <p class="text-muted my-3 ff-secondary">Reserva tu asesoría en solo tres pasos. Selecciona el servicio, el horario y listo.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Asesoría personalizada -->
                        <div class="col-lg-4">
                            <div class="d-flex p-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle">
                                            <i class="ri-user-voice-line fs-36"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-18">Asesoría personalizada</h5>
                                    <p class="text-muted my-3 ff-secondary">Recibe atención personalizada por parte de expertos en tu área de interés.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Horarios flexibles -->
                        <div class="col-lg-4">
                            <div class="d-flex p-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle">
                                            <i class="ri-time-line fs-36"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-18">Horarios flexibles</h5>
                                    <p class="text-muted my-3 ff-secondary">Elige el horario que más te convenga. Asesorías disponibles los 7 días de la semana.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Modalidad presencial o virtual -->
                        <div class="col-lg-4">
                            <div class="d-flex p-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle">
                                            {{-- ri-video-chat-line --}}
                                            <i class="ri-map-pin-line fs-36"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-18">Modalidad presencial o virtual</h5>
                                    <p class="text-muted my-3 ff-secondary">Decide si prefieres reunirte en persona o por videollamada.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Pagos seguros en línea -->
                        <div class="col-lg-4">
                            <div class="d-flex p-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle">
                                            <i class="ri-secure-payment-line fs-36"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-18">Pagos seguros en línea</h5>
                                    <p class="text-muted my-3 ff-secondary">Procesamos tus pagos de forma segura mediante plataformas confiables como PayPal.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Recordatorios automáticos -->
                        <div class="col-lg-4">
                            <div class="d-flex p-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle">
                                            <i class="ri-notification-2-line fs-36"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-18">Recordatorios automáticos</h5>
                                    <p class="text-muted my-3 ff-secondary">Recibe notificaciones por correo o WhatsApp antes de cada cita para no olvidar nada.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Profesionales verificados -->
                        <div class="col-lg-4">
                            <div class="d-flex p-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle">
                                            <i class="ri-shield-user-line fs-36"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-18">Profesionales verificados</h5>
                                    <p class="text-muted my-3 ff-secondary">Todos nuestros asesores están certificados y evaluados por los usuarios.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Historial de asesorías -->
                        <div class="col-lg-4">
                            <div class="d-flex p-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle">
                                            <i class="ri-file-list-3-line fs-36"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-18">Historial de asesorías</h5>
                                    <p class="text-muted my-3 ff-secondary">Revisa todas tus reservas pasadas y accede a tus reportes o notas.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Soporte al cliente -->
                        <div class="col-lg-4">
                            <div class="d-flex p-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm icon-effect">
                                        <div class="avatar-title bg-transparent text-success rounded-circle">
                                            <i class="ri-customer-service-2-line fs-36"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-18">Soporte al cliente</h5>
                                    <p class="text-muted my-3 ff-secondary">Nuestro equipo de soporte está disponible para ayudarte en cualquier etapa del proceso.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end services -->

            <!-- start hero section -->
            <section class="section pb-0 hero-section" id="hero">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-sm-10">
                            <div class="text-center mt-lg-5 pt-5">
                                <h1 class="display-6 fw-semibold mb-3 lh-base">Gestiona tu reservación en <span class="text-success">J-GOD </span></h1>
                                <p class="lead text-muted lh-base">En J-GOD, crea tus reservaciones con el especialista adecuado, quien te proporcionará orientación, recomendaciones y conocimientos para ayudarte a tomar las mejores decisiones y alcanzar tus objetivos de manera eficiente.</p>

                                <div class="d-flex gap-2 justify-content-center mt-4">
                                    <a href="{{ route('register') }}" class="btn btn-primary">Empezar <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                                </div>
                            </div>

                            <div class="mt-4 mt-sm-5 pt-sm-5 mb-sm-n5 demo-carousel">
                                <div class="demo-img-patten-top d-none d-sm-block">
                                    <img src="{{ asset('assets/images/landing/img-pattern.png') }}" class="d-block img-fluid" alt="...">
                                </div>
                                <div class="demo-img-patten-bottom d-none d-sm-block">
                                    <img src="{{ asset('assets/images/landing/img-pattern.png') }}" class="d-block img-fluid" alt="...">
                                </div>
                                <div class="carousel slide carousel-fade" data-bs-ride="carousel">
                                    <div class="carousel-inner shadow-lg p-2 bg-white rounded">
                                        <div class="carousel-item active" data-bs-interval="2000">
                                            <img src="{{ asset('assets/images/demos/client-landing-page.png') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="{{ asset('assets/images/demos/client-login.png') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="{{ asset('assets/images/demos/client-register.png') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="{{ asset('assets/images/demos/client-dashboard.png') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="{{ asset('assets/images/demos/client-consult-reservation.png') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="{{ asset('assets/images/demos/client-calendar.png') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item" data-bs-interval="2000">
                                            <img src="{{ asset('assets/images/demos/client-payments.png') }}" class="d-block w-100" alt="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
                <div class="position-absolute start-0 end-0 bottom-0 hero-shape-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                        <g mask="url(&quot;#SvgjsMask1003&quot;)" fill="none">
                            <path d="M 0,118 C 288,98.6 1152,40.4 1440,21L1440 140L0 140z">
                            </path>
                        </g>
                    </svg>
                </div>
                <!-- end shape -->
            </section>
            <!-- end hero section -->

            <!-- start services -->
            <section class="section" id="services">
            </section>
            <!-- end services -->

            <!-- start cta -->
            <section class="py-5 bg-primary position-relative">
                <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            </section>
            <!-- end cta -->

            <!-- start features -->
            <section class="section">
                <div class="container">
                    <div class="row align-items-center gy-4">
                        <div class="col-lg-6 order-2 order-lg-1">
                            <div class="text-muted">
                                <h5 class="fs-12 text-uppercase text-success">Gestión</h5>
                                <h4 class="mb-3">Dashboards intuitivos para cada rol</h4>
                                <p class="mb-4 ff-secondary">Nuestra plataforma incluye dashboards personalizados para clientes, asesores y administradores. Accede fácilmente a estadísticas, próximas asesorías y control total de tu información.</p>

                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="vstack gap-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar-xs icon-effect">
                                                        <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                            <i class="ri-check-fill"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-14 mb-0">Agenda Personalizada</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar-xs icon-effect">
                                                        <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                            <i class="ri-check-fill"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-14 mb-0">Reportes en Tiempo Real</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar-xs icon-effect">
                                                        <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                            <i class="ri-check-fill"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-14 mb-0">Historial de Asesorías</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="vstack gap-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar-xs icon-effect">
                                                        <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                            <i class="ri-check-fill"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-14 mb-0">Notificaciones Automatizadas</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar-xs icon-effect">
                                                        <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                            <i class="ri-check-fill"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-14 mb-0">Panel del Asesor</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-lg-6 col-sm-7 col-10 ms-auto order-1 order-lg-2">
                            <div>
                                <img src="assets/images/landing/features/img-2.png" alt="Dashboards de asesorías" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row align-items-center mt-5 pt-lg-5 gy-4">
                        <div class="col-lg-6 col-sm-7 col-10 mx-auto">
                            <div>
                                <img src="assets/images/landing/features/img-3.png" alt="Documentación asesorías" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-muted ps-lg-5">
                                <h5 class="fs-12 text-uppercase text-success">Soporte</h5>
                                <h4 class="mb-3">Sistema de Reservas Inteligente</h4>
                                <p class="mb-4">Nuestro sistema de reservaciones te permite programar asesorías fácilmente con profesionales verificados, optimizando tu tiempo y asegurando una experiencia efectiva desde el primer clic.</p>

                                <div class="vstack gap-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <div class="avatar-xs icon-effect">
                                                <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                    <i class="ri-check-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0">Disponibilidad 24/7</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <div class="avatar-xs icon-effect">
                                                <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                    <i class="ri-check-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0">Asesores Activos</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <div class="avatar-xs icon-effect">
                                                <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                    <i class="ri-check-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-0">Reservas Completadas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </section>
            <!-- end features -->

            <!-- start faqs -->
            <section class="section">
                <div class="container">

                    <!-- Encabezado principal -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h3 class="mb-3 fw-semibold">Preguntas Frecuentes</h3>
                                <p class="text-muted mb-4 ff-secondary">
                                    Si no encuentras la respuesta a tu pregunta aquí, contáctanos por correo o redes sociales. ¡Estamos para ayudarte!
                                </p>

                                <!-- Botones de contacto -->
                                <div>
                                    <a href="mailto:soporte@tusitio.com" class="btn btn-primary btn-label rounded-pill">
                                        <i class="ri-mail-line label-icon align-middle rounded-pill fs-16 me-2"></i> Envíanos un correo
                                    </a>
                                    <a href="https://wa.me/51999999999" target="_blank" class="btn btn-success btn-label rounded-pill">
                                        <i class="ri-whatsapp-line label-icon align-middle rounded-pill fs-16 me-2"></i> Escríbenos por WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ dividido en dos columnas -->
                    <div class="row g-lg-5 g-4">

                        <!-- Columna 1: Reservaciones -->
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0 me-1">
                                    <i class="ri-calendar-check-line fs-24 align-middle text-success me-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fw-semibold">Reservaciones</h5>
                                </div>
                            </div>

                            <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box" id="reserva-accordion">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="reserva-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#reserva-collapseOne" aria-expanded="true" aria-controls="reserva-collapseOne">
                                            ¿Cómo hago una reservación?
                                        </button>
                                    </h2>
                                    <div id="reserva-collapseOne" class="accordion-collapse collapse show" aria-labelledby="reserva-headingOne" data-bs-parent="#reserva-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Debes iniciar sesión, seleccionar la fecha y hora disponibles, elegir el servicio deseado y confirmar la reserva desde tu panel de usuario.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="reserva-headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#reserva-collapseTwo" aria-expanded="false" aria-controls="reserva-collapseTwo">
                                            ¿Puedo modificar mi reserva después de hecha?
                                        </button>
                                    </h2>
                                    <div id="reserva-collapseTwo" class="accordion-collapse collapse" aria-labelledby="reserva-headingTwo" data-bs-parent="#reserva-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Sí, puedes modificar la fecha o el servicio reservado desde tu cuenta, siempre que lo hagas con al menos 24 horas de anticipación.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="reserva-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#reserva-collapseThree" aria-expanded="false" aria-controls="reserva-collapseThree">
                                            ¿Qué sucede si llego tarde a mi cita?
                                        </button>
                                    </h2>
                                    <div id="reserva-collapseThree" class="accordion-collapse collapse" aria-labelledby="reserva-headingThree" data-bs-parent="#reserva-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Tienes una tolerancia de 15 minutos. Después de ese tiempo, la reserva puede ser cancelada automáticamente y se aplicará la política de no-show.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="reserva-headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#reserva-collapseFour" aria-expanded="false" aria-controls="reserva-collapseFour">
                                            ¿Puedo cancelar una reservación?
                                        </button>
                                    </h2>
                                    <div id="reserva-collapseFour" class="accordion-collapse collapse" aria-labelledby="reserva-headingFour" data-bs-parent="#reserva-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Sí, puedes cancelar desde tu perfil. Si cancelas con al menos 24 horas de anticipación, no se aplicará penalización.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna 2: Pagos y Seguridad -->
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0 me-1">
                                    <i class="ri-lock-line fs-24 align-middle text-success me-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-0 fw-semibold">Pagos y Seguridad</h5>
                                </div>
                            </div>

                            <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box" id="pagos-accordion">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pagos-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pagos-collapseOne" aria-expanded="false" aria-controls="pagos-collapseOne">
                                            ¿Qué métodos de pago aceptan?
                                        </button>
                                    </h2>
                                    <div id="pagos-collapseOne" class="accordion-collapse collapse" aria-labelledby="pagos-headingOne" data-bs-parent="#pagos-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Aceptamos pagos con tarjeta de crédito/débito, PayPal y transferencias bancarias. Todos los pagos se procesan de forma segura.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pagos-headingTwo">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pagos-collapseTwo" aria-expanded="true" aria-controls="pagos-collapseTwo">
                                            ¿Puedo pagar al momento de la cita?
                                        </button>
                                    </h2>
                                    <div id="pagos-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="pagos-headingTwo" data-bs-parent="#pagos-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Algunas reservas permiten pago en sitio. Consulta si tu servicio aplica esta opción al momento de reservar.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pagos-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pagos-collapseThree" aria-expanded="false" aria-controls="pagos-collapseThree">
                                            ¿Cómo sé que mi pago es seguro?
                                        </button>
                                    </h2>
                                    <div id="pagos-collapseThree" class="accordion-collapse collapse" aria-labelledby="pagos-headingThree" data-bs-parent="#pagos-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Utilizamos pasarelas de pago certificadas con cifrado SSL y validación 3D Secure para proteger tus transacciones.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="pagos-headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pagos-collapseFour" aria-expanded="false" aria-controls="pagos-collapseFour">
                                            ¿Qué pasa si tengo un problema con el pago?
                                        </button>
                                    </h2>
                                    <div id="pagos-collapseFour" class="accordion-collapse collapse" aria-labelledby="pagos-headingFour" data-bs-parent="#pagos-accordion">
                                        <div class="accordion-body ff-secondary">
                                            Contáctanos de inmediato desde la sección de soporte. Revisaremos tu caso y te daremos una solución en menos de 24 horas.
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <!-- end faqs -->

            <!-- start review -->
            <section class="section bg-primary" id="reviews">
                <div class="bg-overlay bg-overlay-pattern"></div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="text-center">
                                <div>
                                    <i class="ri-double-quotes-l text-success display-3"></i>
                                </div>
                                <h4 class="text-white mb-5"><span class="text-success">+19 mil</span> clientes satisfechos</h4>

                                <!-- Swiper -->
                                <div class="swiper client-review-swiper rounded" dir="ltr">
                                    <div class="swiper-wrapper">
                                        <!-- Testimonio 1 -->
                                        <div class="swiper-slide">
                                            <div class="row justify-content-center">
                                                <div class="col-10">
                                                    <div class="text-white-50">
                                                        <p class="fs-20 ff-secondary mb-4">"Reservar fue súper fácil y rápido. En minutos ya tenía mi cita confirmada. 100% recomendado."</p>
                                                        <div>
                                                            <h5 class="text-white">Ana Gómez</h5>
                                                            <p>- Cliente verificado</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Testimonio 2 -->
                                        <div class="swiper-slide">
                                            <div class="row justify-content-center">
                                                <div class="col-10">
                                                    <div class="text-white-50">
                                                        <p class="fs-20 ff-secondary mb-4">"Tuve un problema al elegir mi horario, pero el soporte me ayudó al instante por WhatsApp. Excelente atención."</p>
                                                        <div>
                                                            <h5 class="text-white">Carlos Pérez</h5>
                                                            <p>- Usuario frecuente</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Testimonio 3 -->
                                        <div class="swiper-slide">
                                            <div class="row justify-content-center">
                                                <div class="col-10">
                                                    <div class="text-white-50">
                                                        <p class="fs-20 ff-secondary mb-4">"Muy intuitivo el sistema, reservé sin ayuda y recibí notificación al instante. Volveré a usarlo."</p>
                                                        <div>
                                                            <h5 class="text-white">Laura Fernández</h5>
                                                            <p>- Cliente habitual</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Navegación Swiper -->
                                    <div class="swiper-button-next bg-white rounded-circle"></div>
                                    <div class="swiper-button-prev bg-white rounded-circle"></div>
                                    <div class="swiper-pagination position-relative mt-2"></div>
                                </div>
                                <!-- end slider -->
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </section>
            <!-- end review -->

            <!-- start counter -->
            <section class="py-5 position-relative bg-light">
                <div class="container">
                    <div class="row text-center gy-4">
                        <!-- Citas realizadas -->
                        <div class="col-lg-3 col-6">
                            <div>
                                <h2 class="mb-2"><span class="counter-value" data-target="1000">0</span>+</h2>
                                <div class="text-muted">Citas Realizadas</div>
                            </div>
                        </div>

                        <!-- Reseñas positivas -->
                        <div class="col-lg-3 col-6">
                            <div>
                                <h2 class="mb-2"><span class="counter-value" data-target="800">0</span>+</h2>
                                <div class="text-muted">Reseñas Positivas</div>
                            </div>
                        </div>

                        <!-- Clientes satisfechos -->
                        <div class="col-lg-3 col-6">
                            <div>
                                <h2 class="mb-2"><span class="counter-value" data-target="20.3">0</span>k</h2>
                                <div class="text-muted">Clientes Satisfechos</div>
                            </div>
                        </div>

                        <!-- Asesores activos -->
                        <div class="col-lg-3 col-6">
                            <div>
                                <h2 class="mb-2"><span class="counter-value" data-target="50">0</span></h2>
                                <div class="text-muted">Asesores Activos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end counter -->

            <!-- start Work Process -->
            <section class="section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h3 class="mb-3 fw-semibold">¿Cómo funciona?</h3>
                                <p class="text-muted mb-4 ff-secondary">
                                    Reservar tu cita es fácil y rápido. Sigue estos simples pasos para completar tu reservación en minutos.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row text-center">
                        <!-- Paso 1 -->
                        <div class="col-lg-4">
                            <div class="process-card mt-4">
                                <div class="process-arrow-img d-none d-lg-block">
                                    <img src="assets/images/landing/process-arrow-img.png" alt="" class="img-fluid">
                                </div>
                                <div class="avatar-sm icon-effect mx-auto mb-4">
                                    <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                        <i class="ri-quill-pen-line"></i>
                                    </div>
                                </div>
                                <h5>Cuéntanos qué necesitas</h5>
                                <p class="text-muted ff-secondary">
                                    Selecciona el servicio, el asesor y el horario que mejor se adapte a ti.
                                </p>
                            </div>
                        </div>
                        <!-- Paso 2 -->
                        <div class="col-lg-4">
                            <div class="process-card mt-4">
                                <div class="process-arrow-img d-none d-lg-block">
                                    <img src="assets/images/landing/process-arrow-img.png" alt="" class="img-fluid">
                                </div>
                                <div class="avatar-sm icon-effect mx-auto mb-4">
                                    <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                        <i class="ri-user-follow-line"></i>
                                    </div>
                                </div>
                                <h5>Confirma tu reservación</h5>
                                <p class="text-muted ff-secondary">
                                    Revisa los detalles y confirma la cita. También puedes contactar al asesor si lo necesitas.
                                </p>
                            </div>
                        </div>
                        <!-- Paso 3 -->
                        <div class="col-lg-4">
                            <div class="process-card mt-4">
                                <div class="avatar-sm icon-effect mx-auto mb-4">
                                    <div class="avatar-title bg-transparent text-success rounded-circle h1">
                                        <i class="ri-book-mark-line"></i>
                                    </div>
                                </div>
                                <h5>Asiste y disfruta el servicio</h5>
                                <p class="text-muted ff-secondary">
                                    Llega puntual a tu cita y disfruta una atención de calidad por parte de nuestros asesores.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </section>
            <!-- end Work Process -->

            <!-- start team -->
            <section class="section bg-light" id="team">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h3 class="mb-3 fw-semibold">Nuestro <span class="text-danger">Equipo</span></h3>
                                <p class="text-muted mb-4 ff-secondary">Conoce a las personas que están detrás del éxito de nuestro servicio. Nuestro equipo está comprometido con brindarte la mejor experiencia posible en cada paso.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjetas de miembros del equipo -->
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body text-center p-4">
                                    <div class="avatar-xl mx-auto mb-4 position-relative">
                                        <img src="assets/images/users/avatar-2.jpg" alt="" class="img-fluid rounded-circle">
                                        <a href="apps-mailbox.html" class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                            <div class="avatar-title bg-transparent">
                                                <i class="ri-mail-fill align-bottom"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="mb-1"><a href="pages-profile.html" class="text-body">Nancy Martino</a></h5>
                                    <p class="text-muted mb-0 ff-secondary">Líder de Equipo</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body text-center p-4">
                                    <div class="avatar-xl mx-auto mb-4 position-relative">
                                        <img src="assets/images/users/avatar-10.jpg" alt="" class="img-fluid rounded-circle">
                                        <a href="apps-mailbox.html" class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                            <div class="avatar-title bg-transparent">
                                                <i class="ri-mail-fill align-bottom"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="mb-1"><a href="pages-profile.html" class="text-body">Henry Baird</a></h5>
                                    <p class="text-muted mb-0 ff-secondary">Asesor Senior</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body text-center p-4">
                                    <div class="avatar-xl mx-auto mb-4 position-relative">
                                        <img src="assets/images/users/avatar-3.jpg" alt="" class="img-fluid rounded-circle">
                                        <a href="apps-mailbox.html" class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                            <div class="avatar-title bg-transparent">
                                                <i class="ri-mail-fill align-bottom"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="mb-1"><a href="pages-profile.html" class="text-body">Frank Hook</a></h5>
                                    <p class="text-muted mb-0 ff-secondary">Coordinador de Reservas</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body text-center p-4">
                                    <div class="avatar-xl mx-auto mb-4 position-relative">
                                        <img src="assets/images/users/avatar-8.jpg" alt="" class="img-fluid rounded-circle">
                                        <a href="apps-mailbox.html" class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                            <div class="avatar-title bg-transparent">
                                                <i class="ri-mail-fill align-bottom"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="mb-1"><a href="pages-profile.html" class="text-body">Donald Palmer</a></h5>
                                    <p class="text-muted mb-0 ff-secondary">Diseñador de Experiencia</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda fila -->
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body text-center p-4">
                                    <div class="avatar-xl mx-auto mb-4 position-relative">
                                        <img src="assets/images/users/avatar-5.jpg" alt="" class="img-fluid rounded-circle">
                                        <a href="apps-mailbox.html" class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                            <div class="avatar-title bg-transparent">
                                                <i class="ri-mail-fill align-bottom"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="mb-1"><a href="pages-profile.html" class="text-body">Erica Kernan</a></h5>
                                    <p class="text-muted mb-0 ff-secondary">Diseñadora Web</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body text-center p-4">
                                    <div class="avatar-xl mx-auto mb-4 position-relative">
                                        <img src="assets/images/users/avatar-4.jpg" alt="" class="img-fluid rounded-circle">
                                        <a href="apps-mailbox.html" class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                            <div class="avatar-title bg-transparent">
                                                <i class="ri-mail-fill align-bottom"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="mb-1"><a href="pages-profile.html" class="text-body">Alexis Clarke</a></h5>
                                    <p class="text-muted mb-0 ff-secondary">Desarrollador Backend</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body text-center p-4">
                                    <div class="avatar-xl mx-auto mb-4 position-relative">
                                        <img src="assets/images/users/avatar-6.jpg" alt="" class="img-fluid rounded-circle">
                                        <a href="apps-mailbox.html" class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                            <div class="avatar-title bg-transparent">
                                                <i class="ri-mail-fill align-bottom"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="mb-1"><a href="pages-profile.html" class="text-body">Marie Ward</a></h5>
                                    <p class="text-muted mb-0 ff-secondary">Desarrolladora Full Stack</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="card-body text-center p-4">
                                    <div class="avatar-xl mx-auto mb-4 position-relative">
                                        <img src="assets/images/users/avatar-7.jpg" alt="" class="img-fluid rounded-circle">
                                        <a href="apps-mailbox.html" class="btn btn-success btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-xs">
                                            <div class="avatar-title bg-transparent">
                                                <i class="ri-mail-fill align-bottom"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <h5 class="mb-1"><a href="pages-profile.html" class="text-body">Jack Gough</a></h5>
                                    <p class="text-muted mb-0 ff-secondary">Desarrollador React</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de ver más -->
                    {{-- <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mt-2">
                                <a href="pages-team.html" class="btn btn-primary">Ver Todos los Miembros <i class="ri-arrow-right-line ms-1 align-bottom"></i></a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </section>
            <!-- end team -->

            <!-- Start footer -->
            <footer class="custom-footer bg-dark py-5 position-relative">
                <div class="container">
                    <div class="row text-center text-sm-start align-items-center mt-2">
                        <div class="col-sm-6">
                            <div>
                                <p class="copy-rights mb-0">
                                    <script> document.write(new Date().getFullYear()) </script> © Sistema de Reservaciones - J-GOD
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end mt-3 mt-sm-0">
                                <ul class="list-inline mb-0 footer-social-link">
                                    <li class="list-inline-item">
                                        <a href="https://facebook.com/tuempresa" target="_blank" class="avatar-xs d-block">
                                            <div class="avatar-title rounded-circle">
                                                <i class="ri-facebook-fill"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://github.com/tuempresa" target="_blank" class="avatar-xs d-block">
                                            <div class="avatar-title rounded-circle">
                                                <i class="ri-github-fill"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://linkedin.com/company/tuempresa" target="_blank" class="avatar-xs d-block">
                                            <div class="avatar-title rounded-circle">
                                                <i class="ri-linkedin-fill"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="mailto:soporte@tuempresa.com" class="avatar-xs d-block">
                                            <div class="avatar-title rounded-circle">
                                                <i class="ri-mail-fill"></i>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://dribbble.com/tuempresa" target="_blank" class="avatar-xs d-block">
                                            <div class="avatar-title rounded-circle">
                                                <i class="ri-dribbble-line"></i>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end footer -->
        </div>
        <!-- end layout wrapper -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>

        <!--Swiper slider js-->
        <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

        <!-- landing init -->
        <script src="{{ asset('assets/js/pages/landing.init.js') }}"></script>
    </body>
</html>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<!-- FullCalendar con todos los idiomas (versión global) -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/index.global.min.js"></script>

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
                url: '{{ route('welcome.data') }}',
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