<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DeliExpress</title>
    <link rel="icon" type="image/x-icon" href="{{ Asset('assets/img/image5.png') }}"/>
    <link rel="icon" href="{{ Asset('assets/img/image5.png') }}" type="image/png" sizes="16x16">

    <link href='https://fonts.googleapis.com/css?family=Mulish' rel='stylesheet'>

    <link rel="stylesheet" type="text/css" href="{{ Asset('assets/css/express.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ Asset('assets/css/atmos.min.css') }}">
    <link rel="stylesheet" href="{{ Asset('assets/vendor/pace/pace.css') }}">
    <script src="{{ Asset('assets/vendor/pace/pace.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ Asset('css/app.css') }}">
    <script src="{{ Asset('js/app.js') }}"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body , body * {
            font-family: 'Mulish';
            font-style: normal;
        }

        .login-body {
            background-image: url("assets/img/background.jpg");
            background-color: #E5E5E5;
            background-position: center left;
            background-repeat: no-repeat;
            background-size: cover;

            height: 100%;
            margin: 0 auto;
            display: table
        }

        .container {
            height: 100%;
            display: table-cell;
            vertical-align: middle;
        }

        .row-container {
            width: 900px;
            height: 620px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        .container-bordered-left {
            display: flex;
            border-radius: 4px 0 0 4px;
        }

        .container-bordered-right {
            border-radius: 0 4px 4px 0;
        }

        #img-left{
            display: block;
            margin: auto;
            vertical-align: middle;
            width: 161px;
            height: 112px;
        }

        form {
            position: absolute;
            width: 300px;
            height: 367px;
            right: 75px;
            top: 173px;
        }

        .form-row {
            position: absolute;
            width: 100%;
            height: 134px;
            left: 0px;
            top: 0px;
        }

        .register-form {
            position: absolute;
            width: 100%;
            height: 400px;
            left: 0px;
            top: -40px;
        }

        h6 {
            position: absolute;
            width: 78px;
            height: 25px;
            left: 175px;
            top: 70px;

            font-style: initial;
            font-weight: 300;
            font-size: 20px;
            line-height: 25px;
            color: #979797;
        }

        .h6-long {
            width : 200px;
            height : 141px;
            left : 141px;
        }

        .h6-extra-long {
            width : 250px;
            height : 141px;
            left : 120px;
        }

        label, i {
            color: #979797;
        }

        label {
            font-style: normal;
            font-weight: normal;
            font-size: 12px;
            line-height: 12px;

            height: 13px;
            bottom: 5px;
            margin-bottom: 13px;
        }

        #passRecovery {
            position: absolute;
            width: 137px;
            height: 18px;
            left: 75px;
            bottom: 0px;

            /* Small */

            font-family: Mulish;
            font-style: normal;
            font-weight: normal;
            font-size: 11px;
            line-height: 18px;

            /* identical to box height, or 164% */
            display: flex;
            align-items: center;
            text-align: center;
            letter-spacing: 0.25px;


            color: #979797;
        }

        input {
            text-align: center;
        }

        .input-login {
            position: absolute;
            width: 100%;
            height: 67px;
            left: 0px;
            top: 0px;
        }

        .inp-2 {
            top: 67px;
        }

        .inp-3 {
            top: 134px;
        }

        .inp-4 {
            top: 201px;
        }

        .inp-5 {
            top: 268px;
        }

        .input-out {
            outline: 0;
            border-width: 0 0 1px;
            border-color: #979797;

            height:20px;
            margin:0;
            width: 100%;
        }

        .input-img {
            position: absolute;
            width: 20px;
            height: 20px;
            top: 24px;

            font-family: Material Icons;
            font-style: normal;
            font-weight: normal;
            font-size: 20px;
            line-height: 12px;

            /* identical to box height, or 60% */
            display: flex;
            align-items: center;
            text-align: center;

            color: #979797;
        }

        .btn-login{
            position: absolute;
            width: 140px;
            height: 36px;
            left: 75px;
            bottom: 48px;
            font-weight: bolder;
            font-size: 12px;
            letter-spacing: 0.12em;
            filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
            border: 0;
            color: white;
            background-color: #E5E5E5;
        }

        #btnRecovery {
            position: absolute;
            width: 140px;
            height: 38px;
            left: 75px;
            bottom: 187px;
            background-color: #FD4F00;
            color: white;
        }

        #btnBack {
            position: absolute;
            width: 140px;
            height: 36px;
            left: 75px;
            bottom: 132px;
            background-color: white;

            font-family: Mulish;
            font-style: normal;
            font-weight: bold;
            font-size: 12px;
            line-height: 35px;
            /* or 133% */

            align-items: center;
            text-align: center;
            letter-spacing: 1.25px;
            text-transform: uppercase;

            /* Gray-ish dark */

            color: #979797;
        }

        .recovery-message {
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

        .bg-main {
            background-color: #FD4F00;
        }

        .bg-white {
            color: #FFFFFF;
        }

    </style>
    @yield('styles')
</head>

<body class="login-body" id="app">
<main class="container">
    <div class="row row-container">
        <div class="col-6 bg-main container-bordered-left">
            <img id="img-left" src="{{ asset('assets/img/image5.png') }}">
        </div>
        <div class="col-6 bg-white container-bordered-right">
            @include('sweetalert::alert')

            @yield('right-panel')
        </div>
    </div>
</main>

@yield('js')
</body>
</html>
