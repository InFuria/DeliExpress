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

    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js')  }}"></script>

    <link href='https://fonts.googleapis.com/css?family=Mulish' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006288/BBBootstrap/choices.min.css?version=7.0.0">
    <script src="https://res.cloudinary.com/dxfq3iotg/raw/upload/v1569006273/BBBootstrap/choices.min.js?version=7.0.0"></script>

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
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <div class="btn-group ml-auto mr-3 pl-2" id="profileGroup" style="border-left: 1px solid #E5E5E5;">
                    <a href="{{ route('users.profile') }}"
                       class="border-0 bg-transparent d-flex align-items-center">

                        <p style="font-size: 15px; margin: 0; letter-spacing: 0.025rem; color: black">{{ explode(" ", auth()->user()->name)[0] }}</p>

                        <img src="{{ asset("storage/users/" . auth()->user()->photo) }}" id="img-list"
                             style="width: 35px; height: 35px; border-radius: 50%; font-size: 28px; display: flex;
                                  align-items: center;justify-content: center; margin-left: 0.5rem;">
                    </a>

<!--                    Dropdown para futuras modificaciones-->
<!--                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">Mi Perfil</button>
                        <button class="dropdown-item" type="button">Salir</button>
                        <button class="dropdown-item" type="button">Mas opciones</button>
                    </div>-->
                </div>
            </div>
        </nav>

        @yield('main')
    </div>
</div>

@yield('js')
<script>
    $(document).ready(function (){
        /** Imagen del form **/
        $('#photo').on('change', function () { //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                var data = $(this)[0].files; //this file data

                $.each(data, function (index, file) { //loop though each file
                    var fRead = new FileReader(); //new filereader
                    var ext = file.name.split('.').pop();
                    var name = file.name;

                    if (ext === 'jpg' || ext === 'jpeg' || ext === 'png') {
                        fRead.onload = (function (file) { //trigger function on successful read
                            return function (e) {

                                $('#img-span').remove();

                                var appendImg = $('<img id="img-span" class="mx-4" src="' + e.target.result + '" style="width: 64px; height: 64px; border-radius: 50%;' +
                                    ' display: flex; align-items: center;justify-content: center;">'); //create image element


                                $(appendImg).insertAfter($('#photo')); //append image to output element
                            };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.

                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: true,
                            confirmButtonColor: '#FD4F00',
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                        Toast.fire({
                            icon: 'error',
                            html: '&nbsp;&nbsp;El archivo no es valido para el navegador'
                        })
                    }
                });

            }
        });
    });
</script>
</body>
</html>
