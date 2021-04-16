@extends('general.layouts.app')

@section('title', 'Usuarios')

@section('styles')
    <style>

        .users-list:hover {
            background-color: #FF7334 !important;
        }

        .users-list:hover .searchBottomLbl {
            color: white !important;
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
            width: 60%;
            max-width: 60%;
        }
    </style>
@endsection
@section('main')

    <div style="display: flex">
        <nav class="card rounded shadow-e-sm border-0 ml-3" style="height: 50px; max-width: 82%; width: 82%">
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

    <main class="container bg-white shadow-e-sm border-0 mt-3 ml-3"
          style="height: 700px; max-height: 100%; max-width: 82%; width: 82%; display: inline-flex">
        @include('sweetalert::alert')

        <div class="mr-3"
             style="margin-left: 1.5rem !important; margin-top: 1.50rem !important; height: 93%; width: 37.3%;max-width: 37.3%; display: inline-block;vertical-align: top">
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

                            <img src="{{ $user->photo != "" ? asset("storage/users/" . $user->photo) : asset("storage/users/person.png") }}" id="img-list"
                                 style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;
                                 align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem;">

                            <div class="d-flex flex-column" style="justify-content: center;">
                                <label id="nameLbl" class="label-text-form"
                                       style="color: black; font-size: 16px; letter-spacing: 0.05rem; margin-bottom: 4px !important;  border: 0; cursor: pointer">
                                    {{ $user->name }} ({{ $user->username }})
                                </label>
                                <label class="label-text-form searchBottomLbl"
                                       style="font-size: 14px; line-height: 18px;margin-bottom: 0 !important; border: 0; cursor: pointer">{{ $user->role->name }}</label>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        @permission('users.show')
        <div id="right-panel" class="border rounded right-panel-content" style="display: none; padding-bottom: 20px">
            @include('general.users._show')
        </div>

        <div id="right-panel-empty" class="rounded right-panel-empty">
            <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                <span class="material-icons" style="font-size: 70px; color: #E5E5E5">chrome_reader_mode</span>
                <label style="color: #979797; font-size: 16px; text-align: center; width: 170px">
                    Selecciona un usuario para ver mas detalles
                </label>
            </div>
        </div>
        @else
            <div id="right-panel-locked" class="rounded right-panel-empty">
                <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                    <span class="material-icons" style="font-size: 70px; color: #E5E5E5">no_accounts</span>
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

                $('#status').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: [{id: 0, name:'Deshabilitado'}, {id: 1, name: 'Habilitado'}],
                    sortField: {
                        field: 'name',
                        direction: 'desc'
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

                                let photo = value.photo !== "" ? "storage/users/" + value.photo : "storage/users/person.png";

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
                                    '<label class="label-text-form searchBottomLbl"' +
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
                                '<label class="label-text-form searchBottomLbl"' +
                                'style="font-size: 18px; line-height: 18px;margin-bottom: 0 !important; border: 0; pointer-events: none !important;">' +
                                'No se han encontrado resultados' +
                                '</label></div></button>'
                            );
                        }

                    }
                });
            });
        });

        /** Limpieza de form al pasar de editar a crear **/
        $('#createUser').on('click', function (){
            let modalForm = $('#modalUserForm');
            modalForm.attr('action', "{{ route('users.store') }}").trigger('reset');
            modalForm.find('input[name="_method"]').remove();
            modalForm.find('.modal-title').val('Nuevo usuario');

            var $select = $('#status').selectize();
            $select[0].selectize.clear();

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

            @permission('users.update')
            let userId = $(button).val();

            $.ajax({
                url: "{{ url('/users') }}/" + userId,
                method: 'get',
                success: function (result) {

                    $('#right-panel-empty').css('display', 'none');
                    $('#right-panel').css('display', 'initial');

                    $('#roleSpn').text(result.user.role.name);

                    if (result.user.photo !== ''){
                        $('#userImg').attr('src', "{{ asset('/storage/users') }}/" + result.user.photo);
                    } else {
                        $('#userImg').attr('src', "{{ asset('/storage/users/person.png') }}");
                    }


                    let phone = result.user.phone !== "" ? result.user.phone: "No ingresado";
                    let status = result.user.status === 1 ? "Habilitado" : "Deshabilitado";
                    let label = result.user.status === 1 ? "bg-yellow " : "bg-danger ";
                    let verified = result.user.email_verified_at !== "" && result.user.email_verified_at != null ? "Si" : "No";

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
                            '<dd class="mb-0"><label class="'+ label +'text-white px-1 rounded">'+status+'</label></dd>' +
                            '<dt>Verificado</dt>'+
                            '<dd>'+verified+'</dd>'+
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

                    // Boton de reenvio de verificacion
                    let route = '{{ route("verification.resend.id", ":id") }}';
                    route = route.replace(':id', result.user.id);
                    $('#resend').attr("href", route);
                    console.log(route);

                    let userModal = $('#exampleModal');
                    $('#editUser').on('click', function (){

                        if (userModal.find('input[name="_method"]').length === 0){
                            userModal.find('form').prepend('<input type="hidden" name="_method" value="patch">');
                        }

                        userModal.find('.modal-title').val('Editar usuario');
                        userModal.show();

                        let user = result.user;
                        userModal.find('#name').val(user.name)
                        userModal.find('#username').val(user.username)
                        userModal.find('#phone').val(user.phone)
                        userModal.find('#email').val(user.email)

                        userModal.find('#img-span').remove()

                        if(user.photo === '')
                            user.photo = 'person.png';

                        $('<img id="img-span" class="mx-4" src="{{ asset("storage/users") }}/' + user.photo + '" style="width: 64px; height: 64px; border-radius: 50%;' +
                            ' display: flex; align-items: center;justify-content: center;">')
                            .insertAfter($('#photo'))

                        // initialize the selectize control's
                        var $select = $('#status').selectize();
                        $select[0].selectize.setValue(user.status);

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
