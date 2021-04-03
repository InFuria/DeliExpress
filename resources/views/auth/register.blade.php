@extends('auth.app')

@section('right-panel')
    <h6>Registrarse</h6>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="register-form">
            <div class="input-login">
                <label for="name">Nombre</label>
                <i class="material-icons input-img">face</i>
                <input id="name" name="name" type="text"
                       class="form-control rounded-0 input-out @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <div class="input-login inp-2">
                <label for="username">Usuario</label>
                <i class="material-icons input-img">assignment_ind</i>
                <input id="username" name="username" type="text"
                       class="form-control rounded-0 input-out @error('username') is-invalid @enderror"
                       value="{{ old('username') }}" required autocomplete="username" autofocus>

                @error('username')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>


            <div class="input-login inp-3">
                <label for="email">E-mail</label>
                <i class="material-icons input-img">email</i>
                <input type="email" class="form-control rounded-0 input-out @error('email') is-invalid @enderror"
                       id="email" name="email"
                       value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="input-login inp-4">
                <label for="password">Contraseña</label>
                <i class="material-icons input-img">vpn_key</i>
                <input type="password" id="password" name="password"
                       class="form-control rounded-0 input-out @error('password') is-invalid @enderror"
                       autocomplete="new-password" required autofocus>

                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-login inp-5">
                <label for="password-confirm">Confirme la contraseña</label>
                <i class="material-icons input-img">thumb_up_off_alt</i>
                <input type="password" id="password-confirm" name="password_confirmation"
                       class="form-control rounded-0 input-out @error('password-confirm') is-invalid @enderror"
                       autocomplete="new-password" required autofocus>
            </div>

            <div style="bottom: -180px; position: absolute; vertical-align: bottom">
                <button type="submit" id="btnRecovery" class="btn-login border-0 rounded">REGISTRAR</button>
                <a type="button" id="btnBack" class="btn-login border-0 rounded" href="{{ route('login') }}">REGRESAR</a>
            </div>

        </div>
    </form>
@endsection
