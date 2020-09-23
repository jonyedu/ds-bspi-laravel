@extends('layouts.app')

@section('content')

<div class="row">

    <div class="col-md-8 hidden-xs hidden-sm cover container-cover">
        <div>
            <img style="margin-top: -2%; position: fixed; z-index: -99; width: 62%; height: 105%" src="/images/hospital_2017.jpg" alt="Logo">
        </div>

    </div>
    <div style="position: absolute;top: 50%;left: 95%;height: 30%;width: 50%;margin: -15% 0 0 -25%;" class="col-md-3 hidden-xs hidden-sm cover container-cover">
        <img style="display:block;margin:auto;" src="/images/hospital.png" alt="Logo">
        <br>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <center style="clear : all;font-family: fantasy;font-size: 16pt;">Ingrese a su cuenta</center>
            <br>
            <div class="row">
                <div class="col-12">
                    <!-- Identificacion -->
                    <div class="input-group mb-3">
                        <input id="US_COD" placeholder="Identificacion" type="text" class="form-control @error('US_COD') is-invalid @enderror" name="US_COD" value="{{ old('US_COD') }}" required autocomplete="US_COD" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('US_COD')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- Clave -->
                <div class="col-12">
                    <div class="input-group mb-3">
                        <input id="password" placeholder="Contraseña" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span id="fast" class="fas fa-eye" onclick="mostrarContrasena()"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <!-- Boton Iniciar Sesión -->
                <div class="col-12">
                    <button id="password" type="submit" class="btn btn-primary btn-block">{{ __('Iniciar Sesión') }}</button>
                </div>
                <!-- Label ¿Olvidó su contraseña? -->
                <div class="col-12" align="center">
                    <div class="icheck-primary">
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('¿Olvidó su contraseña?') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function mostrarContrasena() {
        var tipo = document.getElementById("password");
        var fast = document.getElementById("fast");
        if (tipo.type == "password") {
            tipo.type = "text";
            fast.className = "fa fa-eye-slash";            
        } else {
            tipo.type = "password";
            fast.className = "fas fa-eye";
        }
    }
</script>

@endsection