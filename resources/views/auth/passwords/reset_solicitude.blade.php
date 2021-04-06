<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DeliExpress</title>
    <link rel="icon" type="image/x-icon" href="{{ Asset('assets/img/image5.png') }}"/>
    <link rel="icon" href="{{ Asset('assets/img/image5.png') }}" type="image/png" sizes="16x16">

    <link href='https://fonts.googleapis.com/css?family=Mulish' rel='stylesheet'>

    <link rel="stylesheet" type="text/css" href="{{ Asset('assets/css/atmos.min.css') }}">
    <link rel="stylesheet" href="{{ Asset('assets/vendor/pace/pace.css') }}">
    <script src="{{ Asset('assets/vendor/pace/pace.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ Asset('css/app.css') }}">
    <script src="{{ Asset('js/app.js') }}"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        body, body * {
            font-family: 'Mulish';
            font-style: normal;
            color: #979797;
        }

        .login-body {
            background-color: #E5E5E5;
            background-position: center left;
            background-repeat: no-repeat;
            background-size: cover;

            height: 100%;
            width: 100%;
            margin: 0 auto;
            display: table
        }

        .container {
            height: 100%;
            margin-bottom: 0;
            display: table-cell;
            vertical-align: middle;
        }

        .row-container {
            height: auto;
            /*box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);*/
        }

        form {
            position: absolute;
            width: 242px;
            height: 367px;
            right: 100px;
            top: 173px;
        }

        h6 {
            font-style: initial;
            font-size: 25px;
            line-height: 25px;
            color: #979797;
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

        input {
            text-align: center;
        }

        .bg-main {
            background-color: #FD4F00;
        }

        .bg-white {
            color: #FFFFFF;
        }

        .btn-verify {
            display: block;
            height:100%;
            width:100%;

            text-align: center;
            left: auto;
            font-size: 15px;
            line-height: 1.7;
            text-decoration: none !important;
            padding: 15px 19px;
            background-color: #F55E50;
            color: white;
            margin:0;
        }

        .btn-verify:hover {
            color: white;
        }
    </style>
</head>

<body class="login-body" id="app">
<main class="container">
    <div class="row row-container justify-content-center">
        <div class="col-8 bg-white rounded px-0 mx-3">
            <div class="col-12 rounded-top bg-main m-0 d-flex" style="height: auto">
                <img src="{{ Asset('assets/img/image5.png') }}" width="100px" style="margin-left: auto; margin-right: auto; display: block;">
            </div>

            <table cellpadding="0" cellspacing="0" align="center" border="0"
                   style="font-size:0px; width:100%; background:#ffffff">
                <tbody>
                <tr>
                    <td style="text-align:center; vertical-align:top; direction:ltr; font-size:0px; padding:40px 50px">

                        <div aria-labelledby="mj-column-per-100" class="x_mj-column-per-100 x_outlook-group-fix mt-3"
                             style="vertical-align:top; display:inline-block; direction:ltr; font-size:13px; text-align:left; width:100%">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                                <tbody>
                                <tr>
                                    <td align="left">
                                        <div>
                                            <h6 style="font-size: 16px; line-height: 16px;">Hola, {{ $user->username }}:</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <p style="font-size: 16px">Estamos enviando este email porque hemos recibido una solicitud de cambio de contraseña para su cuenta.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center"
                                        style="padding:10px 25px; padding-top:20px">
                                        <table align="center" border="0" style="border-collapse:separate">
                                            <tbody>
                                            <tr>
                                                <td align="center" valign="middle" bgcolor="#F55E50" style="border:none; border-radius:3px;height: 100%; width: auto">
                                                    <a style="width: auto" class="btn-verify" href="{{ $url }}">Actualizar contraseña</a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left">
                                        <p style="font-size: 16px">Este enlace de actualizacion expirara en 60 minutos.</p>
                                        <p style="font-size: 16px">Si no solicito la actualizacion solo ignore este mensaje, o contacte con nuestro soporte si tiene alguna duda.</p>
                                    </td>
                                </tr>
                                <tr>
                                <tr>
                                    <td style="word-break:break-word; font-size:0px; padding:30px 0px"><p
                                            style="font-size:1px; margin:0px auto; border-top:1px solid #DCDDDE; width:100%"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="font-size:0px; padding:0px">
                                        <div style="color:#747F8D; font-size:13px; line-height:16px; text-align:left">
                                            <p>¿Hubo algun inconveniente? <a
                                                    href="" style="color:#7289DA">
                                                    Ingresa aqui</a> para ponerte en contacto con nuestro equipo
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
