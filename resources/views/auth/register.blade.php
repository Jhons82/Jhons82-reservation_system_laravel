@extends('layouts.guest')

@section('content')
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-1 mb-4 text-white-50">
                        <div>
                            <a href="index.html" class="d-inline-block auth-logo">
                                <img src="assets/images/logo_vf.png" alt="" height="120" width="120">
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium">Sistema de Reservaciones J-GOD</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Crea una nueva cuenta</h5>
                                <p class="text-muted">Obtén tu cuenta gratuita de J-GOD ahora</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form method="POST" class="needs-validation" novalidate action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">{{ __('Nombres') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nombres') pe-5 is-invalid @enderror" id="nombres" name="nombres" placeholder="Ingrese su nombres" required>
                                        @error('nombres')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">{{ __('Apellidos') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('apellidos') pe-5 is-invalid @enderror" id="apellidos" name="apellidos" placeholder="Ingrese su apellidos" required>
                                        @error('apellidos')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">{{ __('Teléfono') }} <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('telefono') pe-5 is-invalid @enderror" id="telefono" name="telefono" placeholder="Ingrese su teléfono" required>
                                        @error('telefono')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label"> {{ __('Correo Electrónico') }} <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control pe-5 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto" class="form-label">{{ __('Foto (Opcional)') }} </label>
                                        <input type="file" class="form-control @error('foto') pe-5 is-invalid @enderror" id="foto" name="foto">
                                        @error('foto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password">{{ __('Contraseña') }}</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" onpaste="return false" placeholder="Ingrese su contraseña" id="password" name="password" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon toggle-password" type="button"><i class="ri-eye-fill align-middle"></i></button>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password_confirmation">{{ __('Confirmar Contraseña') }}</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" class="form-control pe-5 password-input @error('password-confirm') is-invalid @enderror" onpaste="return false" placeholder="Confirmar su contraseña" id="password_confirmation" name="password_confirmation" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon toggle-password" type="button"><i class="ri-eye-fill align-middle"></i></button>
                                            @error('password-confirm')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="mb-4">
                                        <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the Velzon <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
                                    </div> --}}

                                    <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                        <h5 class="fs-13">Password must contain:</h5>
                                        <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                        <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                        <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                        <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">{{ __('Regístrate') }}</button>
                                    </div>

                                    {{-- <div class="mt-4 text-center">
                                        <div class="signin-other-title">
                                            <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                        </div>

                                        <div>
                                            <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                        </div>
                                    </div> --}}
                                </form>

                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Ya tengo una cuenta? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline"> {{ __('Inicia Sesión') }} </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePasswordButtons = document.querySelectorAll('.toggle-password');

            togglePasswordButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const inputPassword = this.previousElementSibling;

                    if (inputPassword && inputPassword.classList.contains('password-input')) {
                        const type = inputPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                        inputPassword.setAttribute('type', type);

                        const icon = this.querySelector('i');
                        if (icon) {
                            icon.classList.toggle('ri-eye-fill');
                            icon.classList.toggle('ri-eye-off-fill');
                        }
                    }
                })
            });
        });
    </script>
@endpush
@endsection