@extends('general.layouts.app')

@section('title', 'Usuarios')

@section('main')

    <div style="display: flex">
        <nav class="card rounded shadow-sm border-0 ml-3" style="height: 50px; max-width: 85%">
            @yield('breadcrumb')
        </nav>

        @permission('users.store')
            <a type="button" id="createUser" data-toggle="modal" data-target="#exampleModal"
               class="content container-fluid text-active bg-orange-main rounded shadow-primary border-0 px-0 ml-3 text-active"
               style="max-width: 15%; right: 0;position:relative; height:100%;">
                CREAR USUARIO
            </a>
        @else
            <a type="button" id="createUser" style="max-width: 15%; right: 0;position:relative; height:100%;"
               class="content container-fluid btn-e-disabled rounded border-0 px-0 ml-3" title="No tiene permisos para esta accion">
                CREAR USUARIO
            </a>
        @endpermission

    </div>

    <main class="bg-white shadow-sm border-0 mt-3 ml-3"
          style="height: 700px; max-height: 100%; max-width: 83%; display: inline-block">
        @include('sweetalert::alert')

        <div class="ml-4 mr-3 border"
             style="margin-left: 2.5rem !important; margin-top: 1.50rem !important; height: 93%; width: 37.3%;max-width: 37.3%; display: inline-block;vertical-align: top">
            <div>
                <label class="label-primary mt-2">Buscar</label>
            </div>

            <div>
                <label class="label-primary">Recientes</label>
            </div>
        </div>

        <div class="border rounded"
             style="margin-left: 0.75rem !important; margin-top: 1.50rem !important; height: 93%; width: 55%; max-width: 55%;display: inline-block;vertical-align: top">

        </div>
    </main>

@permission('users.store')
    @include('general.users.create', ['roles' => $roles])
@endpermission

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            // Manejo de pestañas en el header
            $('.btn-header').click(function () {
                var next = this;

                // Se ocultan las otras pestañas
                $(".header-active").map(function () {

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

                // Se vuelve a verificar el active
                verifyActive()
            });

            // Manejo de pestañas con los botones del footer
            $('#continue').click(function () {

                var next = $('.header-active').next();

                if (next.length > 0) {
                    var butttons = $('#header').children('div').children('button').map(function () {

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
                    console.log('here');
                    $('#continue').removeAttr("type").attr("type", "submit");
                }

                // Se vuelve a verificar el active
                verifyActive()
            });

            $('#previous').click(function () {
                var prev = $('.header-active').prev();

                var butttons = $('#header').children('div').children('button').map(function () {

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

                // Se vuelve a verificar el active
                verifyActive()
            });

            function verifyActive() {
                let cont = $('#continue');
                let prev = $('#previous');
                let active = $('.header-active')

                if (active.next().length === 0) {
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

            /** Selects **/
            var multipleRoles = new Choices('#roles', {
                removeItemButton: true,
                maxItemCount: 2,
                itemSelectText: 'Click para seleccionar',
                noResultsText: 'No se encuentran roles activos',
                searchFields: ['name'],
                placeholder: true,
                placeholderValue: 'Seleccione los roles',
                noChoicesText: 'Ya no quedan opciones para seleccionar',
                maxItemText: (maxItemCount) => {
                    return `Solo se pueden seleccionar hasta ${maxItemCount} roles`;
                },
            });

            var multiplePermissions = new Choices('#permissions', {
                removeItemButton: true,
                itemSelectText: 'Click para seleccionar',
                noResultsText: 'No se encuentran permisos activos',
                searchFields: ['name'],
                placeholder: true,
                placeholderValue: 'Seleccione permisos extra si es necesario',
                noChoicesText: 'Ya no quedan opciones para seleccionar'
            });

            $('#roles').on('change', function (){
                let place = $('.choices__input');
                console.log(place.val().length > 0);
                if (place.val().length > 0){
                    place.removeAttr('placeholder');
                }
            });

            /** Imagen del form **/
            $('#photo').on('change', function () { //on file input change
                if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
                {
                    if ($('#updatedImg'))
                        $('#updatedImg').remove();

                    var data = $(this)[0].files; //this file data

                    $.each(data, function (index, file) { //loop though each file
                        var fRead = new FileReader(); //new filereader
                        var ext = file.name.split('.').pop();
                        var name = file.name;

                        if (ext === 'jpg' || ext === 'jpeg' || ext === 'png') {
                            fRead.onload = (function (file) { //trigger function on successful read
                                return function (e) {

                                    var appendImg = $('<img id="updatedImg" class="mx-4" src="'+ e.target.result +'" style="width: 64px; height: 64px; border-radius: 50%;' +
                                        ' display: flex; align-items: center;justify-content: center;">'); //create image element


                                    $('#img-span').remove();

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






            $('#formSubmit').click(function (e) {
                e.preventDefault();
                console.log('here');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ url('/books') }}",
                    method: 'post',
                    data: {
                        name: $('#name').val(),
                        auther_name: $('#auther_name').val(),
                        description: $('#description').val(),
                    },
                    success: function (result) {
                        if (result.errors) {
                            $('.alert-danger').html('');

                            $.each(result.errors, function (key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>' + value + '</li>');
                            });
                        } else {
                            $('.alert-danger').hide();
                            $('#exampleModal').modal('hide');
                        }
                    }
                });
            });
        });
    </script>
@append
