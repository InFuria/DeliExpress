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

    <link href="https://fonts.googleapis.com/css?family=Kurale" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Mulish' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Datepicker Files -->
    <link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('datepicker/css/bootstrap-datepicker3.standalone.css')}}">
    <script src="{{asset('datepicker/js/bootstrap-datepicker.js')}}"></script>
    <!-- Languaje -->
    <script src="{{asset('datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>

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

                        @if(auth()->user()->photo !== "" && auth()->user()->photo !== null)
                            <img src="{{asset("storage/users/" . auth()->user()->photo) }}" id="img-list"
                                 style="width: 35px; height: 35px; border-radius: 50%; font-size: 28px; display: flex;
                                      align-items: center;justify-content: center; margin-left: 0.5rem;">
                        @else
                            <span id="img-list" class="material-icons"
                                 style="width: 35px; height: 35px; border-radius: 50%; font-size: 28px; display: flex; background-color: #E5E5E5;
                                      color: white;align-items: center;justify-content: center; margin-left: 0.5rem;">person</span>
                        @endif
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


    <script>
        /** Variable para alertas de responses **/
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
    </script>
</div>

@yield('js')
<script>
    $(document).ready(function (){
        // Header general para solicitudes
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content'),
            }
        });

        /** Imagen del form de usuario general **/
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

        /** Manejo de pestañas en el header **/
        $('.btn-header').click(function () {
            var next = this;

            // Se ocultan las otras pestañas
            $(".header-active").map(function () {

                if (this !== next) {
                    $(this).removeClass('header-active').addClass('header-inactive');
                    var id = $(this).attr('id');
                    $('#' + id + ('Group')).css('display', 'none');

                    $('.secondary-modal').css('display', 'none').find('form').trigger('reset')
                }
            }, next);

            // Se abre la pestaña seleccionada
            $(next).removeClass('header-inactive').addClass('header-active');
            var id = $(next).attr('id');
            $('#' + id + ('Group')).css('display', 'initial');

            // Se vuelve a verificar el active
            verifyActive()
        });

        /** Manejo de pestañas con los botones del footer **/
        $('#continue').click(function () {

            var next = $('.header-active').next();

            if (next.length > 0 && next[0] !== $('button#product')[0]) {
                var butttons = $('.header-container').children('button').map(function () {

                    if (this !== next) {
                        $(this).removeClass('header-active').addClass('header-inactive');
                        var id = $(this).attr('id');
                        $('#' + id + ('Group')).css('display', 'none');
                    }
                }, next);

                // Se abre la pestaña seleccionada
                $(next).removeClass('header-inactive').addClass('header-active');
                var id = $(next).attr('id');
                $('#' + id + ('Group')).css('display', 'initial');

            } else {
                $('#continue').removeAttr("type").attr("type", "submit");
            }

            verifyActive()
        });

        $('#previous').click(function () {
            var prev = $('.header-active').prev();

            var butttons = $('.header-container').children('button').map(function () {

                if (this !== prev) {
                    $(this).removeClass('header-active').addClass('header-inactive');
                    var id = $(this).attr('id');
                    $('#' + id + ('Group')).css('display', 'none');
                }
            }, prev);

            // Se abre la pestaña seleccionada
            $(prev).removeClass('header-inactive').addClass('header-active');
            var id = $(prev).attr('id');
            $('#' + id + ('Group')).css('display', 'initial');

            verifyActive()
        });

        function verifyActive() {
            /*resetProductForm()
            resetProducts()*/

            let cont = $('#continue');
            let prev = $('#previous');
            let active = $('.header-active')


            if (active.next().length === 0 || active.next()[0] === $('button#product')[0]) {
                cont.removeClass('btn-out-primary').addClass('btn-e-primary').addClass('text-white').text('Completar');
            } else {
                cont.removeClass('btn-e-primary').removeClass('text-white').addClass('btn-out-primary').text('Continuar');
            }

            if (active.prev().length === 0) {
                prev.attr('hidden', 'hidden');
            } else {
                prev.removeAttr('hidden');
            }
        }
    });

    /** Limpieza del formulario de productos **/
    function resetProductForm(){

        let form = $('#productStoreForm');
        form.attr('action', "{{ route('products.store') }}");
        form.find('input[name="_method"]').remove()
        form.find('#createProduct').text('Crear producto')
        form.trigger("reset");

        $('#newGroup').find('.label-primary-form').text('Nuevo producto')

        console.log('ahora es aca')
        $('#img-span').remove();

        $('<span id="img-span" class="material-icons mx-4" style="background: rgba(229, 229, 229, 1); ' +
            'width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex; align-items: center;justify-content: center; color: white">' +
            'camera</span>').insertAfter($('#img'))
    }

    /** Reset del bloque de productos **/
    function resetProducts(){
        $('#productsContainer').removeClass('product-panel-filled').addClass('product-right-panel').empty()
            .append('<div style="max-width: 220px; text-align: center; transform: translateZ(50px)">'+
                '<span class="material-icons" style="font-size: 70px; color: #E5E5E5">chrome_reader_mode</span>'+
                '<p style="color: #979797; font-size: 16px; text-align: center; width: 170px">'+
                'Selecciona una categoría para ver los productos disponibles'+
                '</p></div>')

        $('.sub-ul').removeClass('product-active')
        $('.sub-ul a').addClass('noVisible')
    }

    /** Posicion por defecto de los headers del modal **/
    function resetHeaders(){

        let container = $('.header-container');

        if (container.length){

            $.each(container.children(), function(k,v){

                var id = $(v).attr('id');
                if (k === 0){

                    $(v).removeClass('header-inactive').addClass('header-active');
                    $('#' + id + ('Group')).css('display', 'initial');

                } else {

                    $(v).removeClass('header-active').addClass('header-inactive');
                    $('#' + id + ('Group')).css('display', 'none');
                }

            })
        }
    }

    /** Funcionamiento de los botones de cierre **/
    function closePanel(){
        $('.active-panel').css('display', 'none');
        $('.inactive-panel').css('display', 'inline-flex');
    }

    function openProductPanel(){

        $('#productFormContainer').css('display', 'none')
        $('#editProductPreview').css('display', 'flex')

        resetProductForm()
        $('#newGroup').css('display', 'block')
    }

    function closeProductPanel(){
        resetProductForm()
        $('#newGroup').css('display', 'none')
    }

    function openProductForm(category){

        $(`#newGroup`).css(`display`,`block`);
        $('#productFormContainer').css('display', 'block')
        $('#editProductPreview').css('display', 'none')


        $('#productStoreForm').find('#category_id').remove()
        $('#productStoreForm').append('<input type="hidden" id="category_id" value="'+ category +'">')

    }
</script>
</body>
</html>
