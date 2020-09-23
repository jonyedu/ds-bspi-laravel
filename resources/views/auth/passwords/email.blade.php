@extends('layouts.app')

@section('content')
<div class="col-md-12 col-md-offset-4 well">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <center>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="col-md-4 col-md-offset-4 well" style="margin-top: 5%;background-color:#EEEEEE;">
                <div class="col-md-12 text-center">
                    <img style="margin-top: 5%;" alt="Hospital" src="/images/hospital.png">
                </div>
                <br>
                <p style="text-align:center;">
                    Por favor ingrese su correo electrónico. Recibirá las instrucciones para obtener su nueva contraseña.
                </p>
                <form name="claveForm" method="POST">
                    <div class="input-group mb-3">
                        <input placeholder="Correo Electrónico" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <br>
                    <div class="form-group row mb-0">
                        <div class="col-md-12" align="center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Enviar enlace de restablecimiento') }}
                            </button>
                        </div>
                    </div>
                </form>

                <br>
                <div class="row">
                    <div class="col-12" align="center">
                        <div class="icheck-primary">
                            @if (Route::has('login'))
                            <a class="btn btn-link" href="{{ route('login') }}">
                                {{ __('Iniciar Sesión') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </center>

</div>

@endsection