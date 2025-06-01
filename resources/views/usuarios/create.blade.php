@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Nuevo Usuario</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Usuarios</a></li>
                        <li class="breadcrumb-item active">Nuevo Registro</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Crear Usuario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('usuarios.store') }}" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <!-- Nombres -->
                        <div class="col-md-6">
                            <label for="nombres" class="form-label">{{ __('Nombres') }}</label>
                            <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" value="{{ old('nombres') }}" placeholder="Ingrese los nombres del usuario" required>
                            @error('nombres')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Apellidos -->
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">{{ __('Apellidos') }}</label>
                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" placeholder="Ingrese los apellidos del usuario" required>
                            @error('apellidos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Teléfono -->
                        <div class="col-md-4">
                            <label for="telefono" class="form-label">{{ __('Teléfono') }}</label>
                            <div class="form-icon right">
                                <input type="number" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="Ingrese el teléfono del usuario" required>
                                <i class="ri-phone-line"></i>
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Rol -->
                        <div class="col-md-4">
                            <label for="rol_id" class="form-label">{{ __('Rol') }}</label>
                            <select class="form-select @error('rol_id') is-invalid @enderror" id="rol_id" name="rol_id" required>
                                <option value="" disabled selected>Seleccione un rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>{{ $rol->name }}</option>
                                @endforeach
                            </select>
                            @error('rol_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="col-md-4">
                            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                            <div class="form-icon right">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Ingrese el correo electrónico del usuario" required autocomplete="email">
                                <i class="ri-mail-unread-line"></i>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="col-md-4">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Ingrese la contraseña del usuario" required>
                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="togglePassword"><i class="ri-eye-fill align-middle"></i></button>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Foto -->
                        <div class="col-md-4">
                            <label for="foto" class="form-label">{{ __('Foto (Opcional)') }} </label>
                            <input type="file" class="form-control @error('foto') pe-5 is-invalid @enderror" id="foto" name="foto" accept="image/*">
                            {{-- <img id="preview" class="img-thumbnail rounded-circle border shadow-sm mt-2" style="max-width: 200px; height: auto;"> --}}
                            @error('foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- preview -->
                        <div class="col-md-4 text-center">
                            <img id="preview" class="img-thumbnail mt-2" style="max-width: 150px;">
                        </div>
                        <!-- Buttons -->
                        <div class="col-xxl-12 col-md-6">
                            <button class="btn btn-primary btn-label waves-effect waves-light rounded-pill"><i class="ri-save-2-line label-icon align-middle rounded-pill fs-16 me-2"></i>{{ __('Guardar') }}</button>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-danger btn-label waves-effect waves-light rounded-pill">
                                <i class=" ri-close-line label-icon align-middle rounded-pill fs-16 me-2"></i>{{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

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
    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
            }
        });
    </script>
@endpush