@extends('auth.app')

@section('styles')
    <style>
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
    <h6 class="h6-long">Recuperar Acceso</h6>

    <div id="card" class="card-body">

        <form method="POST" action="{{ route('password.email') }}" id="form">
            @csrf
            <div class="form-row">
                <div class="input-login">
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
            </div>

            <button type="submit" id="btnRecovery" class="btn-login rounded">RECUPERAR</button>
            <a type="button" id="btnBack" class="btn-login rounded" href="{{ url()->previous() }}">REGRESAR</a>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#btnRecovery').click(function (event) {
                event.preventDefault();

                var form = $('#form');
                jQuery.ajax({
                    type: "POST",
                    url: "{{route('password.email')}}",
                    data: {
                        _token: $("#form input[name='_token']").val(),
                        email: $('#email').val()
                    },
                    dataType: 'json',
                    success: function (data) {
                        let email = data.email;

                        form.empty();
                        form.append('<label class="recovery-title">¡Perfecto!</label>' +
                            '<p class="recovery-message">Hemos enviado enviado un enlace de recuperación al correo electrónico '
                            + data.email + '</p>' + '<a type="button" id="btnBack" class="btn-login rounded" href="{{ route('login') }}">REGRESAR</a>');
                    },
                    error: function (data) {

                        let message = data.responseJSON.message;
                        $('#card').append('<div class="alert alert-danger" role="alert">' + message + '</div>');
                    }
                });

            });
        });
    </script>
@append
