@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Usuario</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Usuarios</a></li>
                        <li class="breadcrumb-item active">Editar Registro</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Editar Usuario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        <!-- Nombres -->
                        <div class="col-md-6">
                            <label for="nombres" class="form-label">{{ __('Nombres') }}</label>
                            <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" value="{{ old('nombres', $usuario->nombres) }}" placeholder="Ingrese los nombres del usuario" required>
                            @error('nombres')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Apellidos -->
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">{{ __('Apellidos') }}</label>
                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" placeholder="Ingrese los apellidos del usuario" required>
                            @error('apellidos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Teléfono -->
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">{{ __('Teléfono') }}</label>
                            <input type="number" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" placeholder="Ingrese el teléfono del usuario" required>
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Rol -->
                        <div class="col-md-6">
                            <label for="rol_id" class="form-label">{{ __('Rol') }}</label>
                            <select class="form-select @error('rol_id') is-invalid @enderror" id="rol_id" name="rol_id" required>
                                <option value="" disabled selected>Seleccione un rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}" {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>{{ $rol->name }}</option>
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
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->email) }}" placeholder="Ingrese el correo electrónico del usuario" required autocomplete="email">
                                <i class="ri-mail-unread-line"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- Password -->
                        <div class="col-md-4">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input type="password" class="form-control" id="password" name="password" value="{{ old('password',$usuario->password) }}" placeholder="Ingrese la contraseña del usuario" readonly>
                        </div>
                        <!-- Foto -->
                        <div class="col-md-4">
                            <label for="foto" class="form-label">{{ __('Foto (Opcional)') }} </label>
                            <input type="file" class="form-control @error('foto') pe-5 is-invalid @enderror" id="foto" name="foto">
                            @if ($usuario->foto)
                                <img src="{{ asset('storage/' . $usuario->foto) }}" alt="Foto de usuario" class="img-thumbnail mt-2" style="max-width: 150px;">
                                
                            @endif
                            @error('foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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