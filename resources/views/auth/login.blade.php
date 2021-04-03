@extends('auth.app')

@section('right-panel')
    <h6 id="title">Ingresar</h6>

    <form action="" method="post" id="form">
        @csrf
        <div class="form-row">
            <div class="input-login">
                <label for="email">E-mail</label>
                <i class="material-icons input-img">email</i>
                <input type="email" class="form-control rounded-0 input-out" id="email" name="email" required onkeyup="checkFields()">
            </div>

            <div class="input-login inp-2">
                <label for="password">Contraseña</label>
                <i class="material-icons input-img">lock</i>
                <input type="password" class="form-control rounded-0 input-out" id="password" name="password" required onkeyup="checkFields()">
            </div>
        </div>

        <button type="submit" id="btnLogin" class="btn-login rounded">INGRESAR</button>
        <a type="button" id="passRecovery" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
    </form>
@endsection

@section('js')
    <script>
        var form = $('#form');

        $(document).ready(function () {
            $('#flush').on('click', function (){
                {{ session()->forget('validate') }}
            })
        });

        function checkFields(){
            var email = $('#email').val();
            var pass = $('#password').val();
            var btnLogin = $('#btnLogin');

            if (email.length > 1 && pass.length > 1){
                btnLogin.css('background-color', '#FD4F00');
            } else {
                btnLogin.css('background-color', '#E5E5E5');
            }
        }
    </script>
@append
