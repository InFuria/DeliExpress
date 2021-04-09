@extends('general.layouts.app')

@section('title', 'Usuarios')

@section('styles')
    <style>
        .selectize-dropdown-content div:hover {
            background-color: #FF7334;
            color: white;
        }

        .selectize-control.multi .selectize-input > div, .selectize-input span {
            font-family: 'Mulish';
            border: 1px solid #FF7334;
            border-radius: 4px;
            background-color: white;
            color: #FF7334 !important;
        }

        .selectize-input span {
            align-items: center;
            padding-top: 5px;
            padding-left: 5px;
            padding-right: 5px;
            height: 30px;
        }

        .remove-single {

            position: absolute;
            z-index: 1;
            width: 17px;
            height: 100%;
            padding-top: 5px;

            text-align: center;
            vertical-align: middle;

            font-weight: bold;
            font-size: 12px !important;
            text-decoration: none;

            display: inline-block;
            border-left: 1px solid #d0d0d0;
            border-radius: 0 2px 2px 0;
            box-sizing: border-box;

            color: #FF7334 !important;
        }

        .users-list:hover {
            background-color: #FF7334 !important;
        }

        .users-list:hover #roleLbl {
            color: white !important;
        }

        dl {
            font-family: 'Mulish' !important;
            line-height: 20px !important;
            color: #979797 !important;

            width: 100%;
            overflow: hidden;
            padding: 0;
            margin: 0;
        }
        dt {
            float: left;
            width: 25%;
        }
        dd {
            float: left;
            width: 75%;
        }

        .right-panel-empty {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 0.75rem !important;
            margin-top: 1.50rem !important;
            height: 93%;
            width: 55%;
            max-width: 55%;
        }

        .right-panel-content {
            margin-left: 0.75rem !important;
            margin-top: 1.50rem !important;
            height: 93%;
            width: 55%;
            max-width: 55%;
        }

        #closeBtn{
            display: flex;
            float: right;
            justify-content: center;
            padding: 0;
            border-radius: 10%;
            background-color: #FF7334;
            color: white;
            border: 0;
            z-index: 1;
        }
    </style>
@endsection
@section('main')

    <div style="display: flex">
        <nav class="card rounded shadow-sm border-0 ml-3" style="height: 50px; max-width: 82%; width: 82%">
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
               class="content container-fluid btn-e-disabled rounded border-0 px-0 ml-3"
               title="No tiene permisos para esta accion">
                CREAR USUARIO
            </a>
            @endpermission

    </div>

    <main class="container bg-white shadow-sm border-0 mt-3 ml-3"
          style="height: 700px; max-height: 100%; max-width: 82%; width: 82%; display: inline-flex">
        @include('sweetalert::alert')

        <div class="ml-4 mr-3"
             style="margin-left: 2.5rem !important; margin-top: 1.50rem !important; height: 93%; width: 37.3%;max-width: 37.3%; display: inline-block;vertical-align: top">
            <div style="height: 20%">
                <label class="label-primary mt-2" for="search">Buscar</label>
                <div class="form-group" style="margin-top: 1.5rem;">
                    <input type="text" class="form-control rounded-0 input-out" id="search" name="search"
                           placeholder="Ingrese un nombre o un usuario"
                           style="height: 35px !important; padding: 0" required>
                </div>
            </div>

            <div>
                <label class="label-primary">Recientes</label>
                <div style="margin-top: 1rem" id="recent">
                    @foreach($users->slice(0, 6) as $user)
                        <button id="userBtn" class="users-list d-flex align-items-center border-0 bg-white rounded"
                                style="width: 100%; height: 80px; cursor: pointer" value="{{ $user->id }}"
                                onclick="getUserData(this)">
                            <img src="{{ asset("storage/users/" . $user->photo) }}" id="img-list"
                                 style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;
                                  align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem;">

                            <div class="d-flex flex-column" style="justify-content: center;">
                                <label id="nameLbl" class="label-text-form"
                                       style="color: black; font-size: 16px; letter-spacing: 0.05rem; margin-bottom: 4px !important;  border: 0; cursor: pointer">
                                    {{ $user->name }} ({{ $user->username }})
                                </label>
                                <label class="label-text-form" id="roleLbl"
                                       style="font-size: 14px; line-height: 18px;margin-bottom: 0 !important; border: 0; cursor: pointer">{{ $user->role->name }}</label>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        @permission('users.store')
        <div id="right-panel" class="border rounded right-panel-content" style="display: none">
            @include('general.users._show')
        </div>

        <div id="right-panel-empty" class="rounded right-panel-empty">
            <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                <span class="material-icons" style="font-size: 110px; color: #E5E5E5">chrome_reader_mode</span>
                <label style="color: #979797; font-size: 16px; text-align: center; width: 170px">
                    Selecciona un usuario para ver mas detalles
                </label>
            </div>
        </div>
        @else
            <div id="right-panel-locked" class="rounded right-panel-empty">
                <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                    <span class="material-icons" style="font-size: 110px; color: #E5E5E5">no_accounts</span>
                    <label style="color: #979797; font-size: 16px; text-align: center">
                        Parece que no tienes permiso para ver esta seccion
                    </label>
                </div>
            </div>
            @endpermission
    </main>

    @permission('users.store')
    @include('general.users._modal', ['roles' => $roles])
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
            $(function () {
                $('#role').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    placeholder: 'Seleccione un rol',
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: {!! json_encode($roles) !!},
                    sortField: {
                        field: 'name',
                        direction: 'asc'
                    }
                });

                $('#permissions').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    maxItems: null,
                    placeholder: 'Seleccione permisos extra si es necesario',
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: {!! json_encode($permissions) !!},
                    sortField: {
                        field: 'name',
                        direction: 'asc'
                    }
                });
            });


            /** Busqueda de usuarios **/
            $('#search').keyup(function (e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('users') }}",
                    method: 'get',
                    data: {
                        search: $('#search').val()
                    },
                    success: function (result) {

                        let recent = $('#recent');

                        recent.empty();

                        if (result.users.length > 0) {

                            $.each(result.users.slice(0,6), function (key, value) {

                                let photo = "storage/users/" + value.photo;

                                recent.append(
                                    '<button id="userBtn" class="users-list d-flex align-items-center border-0 bg-white rounded" ' +
                                    'style="width: 100%; height: 80px; cursor: pointer" value="' + value.id + '" onclick="getUserData(this)">' +
                                    '<img src="{{asset("/")}}' + photo + '" id="img-list"' +
                                    'style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;' +
                                    'align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem;">' +
                                    '<div class="d-flex flex-column" style="justify-content: center;">' +
                                    '<label id="nameLbl" class="label-text-form"' +
                                    'style="color: black; font-size: 16px; letter-spacing: 0.05rem; margin-bottom: 4px !important;  border: 0; cursor: pointer">' +
                                    value.name + ' (' + value.username + ')</label>' +
                                    '<label class="label-text-form" id="roleLbl"' +
                                    'style="font-size: 14px; line-height: 18px;margin-bottom: 0 !important; border: 0; cursor: pointer">' +
                                    value.role.name + '</label></div></button>'
                                )

                            })
                        } else {

                            recent.append(
                                '<button id="userMessage" class="d-flex align-items-center border-0 bg-white rounded" style="width: 100%; height: 80px;">' +
                                '<span class="material-icons" style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;' +
                                'align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem; background-color: #FD4F00; color: white">warning</span>' +
                                '<div class="d-flex flex-column" style="justify-content: center;">' +
                                '<label class="label-text-form" id="roleLbl"' +
                                'style="font-size: 18px; line-height: 18px;margin-bottom: 0 !important; border: 0; pointer-events: none !important;">' +
                                'No se han encontrado resultados' +
                                '</label></div></button>'
                            );
                        }

                    }
                });
            });
        });

        /** Funcionamiento del boton de cierre **/
        function closePanel(){
            $('#right-panel').css('display', 'none');
            $('#right-panel-empty').css('display', 'inline-flex');
        }

        /** Limpieza de form al pasar de editar a crear **/
        $('#createUser').on('click', function (){
            let modalForm = $('#modalUserForm');
            modalForm.attr('action', "{{ route('users.store') }}").trigger('reset');
            modalForm.find('input[name="_method"]').remove();
            modalForm.find('.modal-title').val('Nuevo usuario');

            var $select = $('#role').selectize();
            $select[0].selectize.clear();

            var $select = $('#permissions').selectize();
            $select[0].selectize.clear();

            $('#img-span').replaceWith('<span id="img-span" class="material-icons material-icons mx-4"'+
                'style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;'+
                'align-items: center;justify-content: center; color: white">'+
                'cloud_upload</span>'
            );

        })

        /** Detalles de usuario **/
        function getUserData(button) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            @permission('users.store')
            let userId = $(button).val();

            $.ajax({
                url: "{{ url('/users') }}/" + userId,
                method: 'get',
                success: function (result) {

                    $('#right-panel-empty').css('display', 'none');
                    $('#right-panel').css('display', 'initial');

                    $('#roleSpn').text(result.user.role.name);
                    $('#userImg').attr('src', "{{ asset('/storage/users') }}/" + result.user.photo);

                    let phone = result.user.phone !== "" ? result.user.phone: "No ingresado";
                    let status = result.user.status === 1 ? "Activo" : "Inactivo";
                    let label = result.user.status === 1 ? "bg-yellow " : "bg-danger ";

                    $('#userInfo').empty();
                    $('#userInfo').append(
                        '<label class="label-primary-form mt-3">Informacion general</label>'+
                        '<dl>' +
                            '<dt>Nombre</dt>' +
                            '<dd>'+result.user.name+'</dd>' +
                            '<dt>Usuario</dt>' +
                            '<dd>'+result.user.username+'</dd>' +
                            '<dt>E-mail</dt>' +
                            '<dd>'+result.user.email+'</dd>' +
                            '<dt>Telefono</dt>' +
                            '<dd>'+phone+'</dd>' +
                            '<dt>Estado</dt>' +
                            '<dd><label class="'+ label +'text-white px-1 rounded">'+status+'</label></dd>' +
                        '</dl>'
                    );

                    let permissionsSpn =$('#permissionsSpn');
                    permissionsSpn.empty();

                    if (result.user.permissions.length > 0){
                        $.each(result.user.permissions, function( index, value ) {

                            permissionsSpn.append(
                                '<label class="col-auto btn-out-compl text-normal p-1 ml-2 rounded">'+ value.name +'</label>'
                            );
                        });
                    } else {
                        permissionsSpn.append(
                            '<label class="col-auto text-normal p-1 ml-2 rounded">Este usuario no posee permisos extra</label>'
                        );
                    }


                    let userModal = $('#exampleModal');
                    $('#editUser').on('click', function (){

                        if (userModal.find('input[name="_method"]').length === 0){
                            console.log('no esta');
                            userModal.find('form').prepend('<input type="hidden" name="_method" value="patch">');

                        } else{
                            console.log('esta');
                        }

                        userModal.find('.modal-title').val('Editar usuario');
                        userModal.show();

                        let user = result.user;
                        userModal.find('#name').val(user.name)
                        userModal.find('#username').val(user.username)
                        userModal.find('#phone').val(user.phone)
                        userModal.find('#email').val(user.email)

                        userModal.find('#img-span').remove()
                        $('<img id="img-span" class="mx-4" src="{{ asset("storage/users") }}/' + user.photo + '" style="width: 64px; height: 64px; border-radius: 50%;' +
                            ' display: flex; align-items: center;justify-content: center;">')
                            .insertAfter($('#photo'))

                        // initialize the selectize control's
                        var $select = $('#role').selectize();
                        $select[0].selectize.setValue(user.role.id);

                        var $select = $('#permissions').selectize();
                        let permissionsId = [];

                        $.each(user.permissions, function (key, item) {
                            permissionsId.push(this.id);
                        });

                        $select[0].selectize.setValue(permissionsId);

                        let url = '{{ route("users.update", ":id") }}';
                        url = url.replace(':id', user.id);
                        userModal.find('form').attr('action', url);

                    })

                }
            });
            @endpermission
        }

    </script>
@append
