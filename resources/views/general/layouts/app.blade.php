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

    <link rel="stylesheet" type="text/css" href="{{ Asset('assets/css/atmos.min.css') }}">
    <link rel="stylesheet" href="{{ Asset('assets/vendor/pace/pace.css') }}">
    <script src="{{ Asset('assets/vendor/pace/pace.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ Asset('css/app.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ Asset('assets/css/express.css') }}">
    <script src="{{ Asset('js/app.js') }}"></script>

    <link href='https://fonts.googleapis.com/css?family=Mulish' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @yield('styles')
</head>

<body>
<div class="wrapper">
    <aside class="sidebar">
        @include('general.layouts.sidebar')
    </aside>

    <div class="main-content main-row">
        <nav class="navbar navbar-expand sticky-top" style="padding: 0; background-color: #F7F7F7">
            <h6 class="ml-3">@yield('title')</h6>
        </nav>

        @yield('main')
    </div>
</div>

@yield('js')
<script>
    $(document).ready(function (){
        $('.menu-inactive').on('click', function(event){
            /* logica de css para botones del menu */
        });
    });
</script>
</body>
</html>
