@extends('layouts.guest')

@section('content')

<div class="auth-page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-sm-1 mb-4 text-white-50">
                    <div>
                        <a href="index.html" class="d-inline-block auth-logo">
                            <img src="{{ asset('assets/images/logo_vf.png') }}" alt="" height="120" width="120">
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
                            <h5 class="text-primary">Bienvenido!</h5>
                            <p class="text-muted">Inicie sesión para continuar a J-GOD.</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                                    <input type="email" class="form-control pe-5 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Ingrese correo electrónico" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    {{-- <div class="float-end">
                                        <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a>
                                    </div> --}}
                                    <label class="form-label" for="password">{{ __('Contraseña') }}</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" placeholder="Ingrese contraseña" id="password" name="password" required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="togglePassword"><i class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                </div>

                                {{-- <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                </div> --}}

                                <div class="mt-4">
                                    <button class="btn btn-success w-100" type="submit">{{ __('Incia Sesión') }}</button>
                                </div>

                                {{-- <div class="mt-4 text-center">
                                    <div class="signin-other-title">
                                        <h5 class="fs-13 mb-4 title">Sign In with</h5>
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
                    <p class="mb-0">No tienes una cuenta? <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> {{ __('Regístrate') }} </a> </p>
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
            const tooglePasswordButton = document.querySelector('#togglePassword');
            const inputPassword = document.querySelector('#password');

            tooglePasswordButton.addEventListener('click', function() {
                // Cambiar el tipo de input entre "password" y "text"
                const type = inputPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                inputPassword.setAttribute('type', type);

                // Cambiar el icono del botón
                this.querySelector('i').classList.toggle('ri-eye-fill');
                this.querySelector('i').classList.toggle('ri-eye-off-fill');
            });
        });
    </script>
@endpush

@endsection