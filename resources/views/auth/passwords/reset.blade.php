@extends('layouts.app')

@section('content')
<div class="col-md-12 col-md-offset-4 well">
    <center>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div
                style="position:absolute; top:0; left:68%;"
                class="text-left col-lg-4 col-md-4 col-sm-12"
            >
                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >
                    <strong
                        >La contraseña debe cumplir con los siguientes
                        puntos:</strong
                    >
                    <br />
                    <span>*Minimo 8 y Maximo 12 Caracteres</span>
                    <br />
                    <span>*Caracteres en mayúscula (A - Z)</span>
                    <br />
                    <span>*Caracteres en minúscula (a - z)</span>
                    <br />
                    <span>*Base 10 dígitos (0 - 9)</span>
                    <br />
                    <span>*Caracteres especiales (-@$!%*#?&)</span>
                </div>
            </div>
            <div class="col-md-7 col-md-offset-4 well" style="margin-top: 5%;">
                <div class="row">
                    <!-- Logo -->
                    <div class="col-md-12 text-center">
                        <img style="margin-top: 5%;" alt="Hospital" src="/images/hospital.png">
                    </div>
                    <!-- Campo Token Oculto-->
                    <div class="col-md-12 text-center">
                        <input type="hidden" name="token" value="{{ $token }}">
                    </div>
                    <!-- Formulario -->
                    <br>
                    <div class="col-md-12 text-center">
                        <div class="row">
                            <!-- Correo Electrónico -->
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico') }}</label>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input placeholder="Correo Electrónico" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Password -->
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input placeholder="Contraseña" id="password" type="password" class="form-control @error('password') @if( $message != 'El campo de confirmación de password no coincide.') is-invalid @endif @enderror" name="password" required autocomplete="new-password">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span id="fast" class="fas fa-eye" onclick="mostrarContrasena(1)"></span>
                                                </div>
                                            </div>
                                            @error('password')
                                            @if($message != "El campo de confirmación de password no coincide.")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @endif
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Confirmar Password -->
                            <div class="col-12">
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input placeholder="Confirmar Contraseña" id="password-confirm" type="password" class="form-control @error('password') @if($message == 'El campo de confirmación de password no coincide.') is-invalid @endif @enderror" name="password_confirmation" required autocomplete="new-password">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span id="fastCon" class="fas fa-eye" onclick="mostrarContrasena(0)"></span>
                                                </div>
                                            </div>
                                            @error('password')
                                            @if($message == "El campo de confirmación de password no coincide.")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @endif
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Boton Restablecer Clave -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Restablecer Contraseña') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
        </form>
    </center>
</div>
<script>
    function mostrarContrasena(opc) {
        if (opc) {
            var tipo = document.getElementById("password");
            var fast = document.getElementById("fast");
            if (tipo.type == "password") {
                tipo.type = "text";
                fast.className = "fa fa-eye-slash";
            } else {
                tipo.type = "password";
                fast.className = "fas fa-eye";
            }
        } else {
            var tipo1 = document.getElementById("password-confirm");
            var fastCon = document.getElementById("fastCon");
            if (tipo1.type == "password") {
                tipo1.type = "text";
                fastCon.className = "fa fa-eye-slash";
            } else {
                tipo1.type = "password";
                fastCon.className = "fas fa-eye";
            }
        }
    }
</script>
@endsection