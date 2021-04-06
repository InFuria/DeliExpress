@extends('auth.app')

@section('styles')
    <style>
        .login-body {
            background-image: url("../../assets/img/background.jpg") !important;
        }

        .recovery-title {
            position: absolute;
            width: 281px;
            height: 101px;
            left: -19px;
            top: -6px;

            /* Body 3 */

            font-family: Mulish;
            font-style: normal;
            font-weight: normal;
            font-size: 16px;
            line-height: 20px;
            text-align: center;
            letter-spacing: 0.1px;

            /* Black-ish */

            color: #393E41;
        }

        .recovery-message {
            margin-top: 45px;
            position: absolute;
            width: 281px;
            height: 101px;
            left: -19px;
            top: -6px;

            /* Body 3 */

            font-family: Mulish;
            font-style: normal;
            font-weight: 300;
            font-size: 13.6px;
            line-height: 20px;
            /* or 147% */

            text-align: center;
            letter-spacing: 0.25px;

            /* Black-ish */

            color: #393E41;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
@endsection

@section('right-panel')
    <h6 class="h6-extra-long">Ingrese una contraseña</h6>

    <div id="card" class="card-body">
        <form method="POST" action="{{ route('password.assign', ['user' => $id]) }}" id="form">
            @csrf
            <div class="form-row">
                <div class="input-login">
                    <label for="password">Contraseña</label>
                    <i class="material-icons input-img">lock</i>
                    <input type="password" class="form-control rounded-0 input-out @error('password') is-invalid @enderror"
                           id="password" name="password"
                           value="{{ old('password') }}" required autocomplete="password" autofocus>

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="input-login inp-2">
                    <label for="password-confirm">Confirme la contraseña</label>
                    <i class="material-icons input-img">thumb_up_off_alt</i>
                    <input type="password" id="password-confirm" name="password_confirmation"
                           class="form-control rounded-0 input-out @error('password-confirm') is-invalid @enderror"
                           autocomplete="new-password" required autofocus>
                </div>
            </div>

            <button type="submit" id="btnRecovery" class="btn-login rounded">INGRESAR</button>
            <a type="button" id="btnBack" class="btn-login rounded" href="{{ url('/') }}">INICIO</a>
        </form>
    </div>
@endsection
