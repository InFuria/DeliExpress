@extends('auth.app')

@section('styles')
    <style>
        .login-body {
            background-image: url("/assets/img/background.jpg");
        }
    </style>
@endsection

@section('right-panel')
    <h6 class="h6-extra-long">Actualizar contraseña</h6>

    <div id="card" class="card-body">
        <form method="POST" action="{{ route('password.update') }}" id="form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-row">
                <div class="input-login">
                    <label for="email">E-mail</label>
                    <i class="material-icons input-img">email</i>
                    <input type="email" class="form-control rounded-0 input-out" id="email" name="email" required
                           onkeyup="checkFields()">
                </div>

                <div class="input-login inp-2">
                    <label for="password">Contraseña</label>
                    <i class="material-icons input-img">lock</i>
                    <input type="password"
                           class="form-control rounded-0 input-out @error('password') is-invalid @enderror"
                           id="password" name="password"
                           value="{{ old('password') }}" required autocomplete="password" autofocus>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-login inp-3">
                    <label for="password-confirm">Confirme la contraseña</label>
                    <i class="material-icons input-img">thumb_up_off_alt</i>
                    <input type="password" id="password-confirm" name="password_confirmation"
                           class="form-control rounded-0 input-out @error('password-confirm') is-invalid @enderror"
                           autocomplete="new-password" required autofocus>
                </div>
            </div>

            <button type="submit" id="btnRecovery" class="btn-login rounded" style="bottom: 75px !important;">ACTUALIZAR</button>
            <a type="button" id="btnBack" class="btn-login rounded" href="{{ url('/') }}" style="bottom: 20px !important;">INICIO</a>
        </form>
    </div>
@endsection
