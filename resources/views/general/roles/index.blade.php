@extends('general.layouts.app')

@section('title', 'Roles')

@section('main')

    <div style="display: flex">
        {{ Breadcrumbs::render('roles-end') }}

        @permission('roles.store')
        <a type="button" id="createRole" data-toggle="modal" data-target="#exampleModal"
           class="content container-fluid text-active bg-orange-main rounded shadow-primary border-0 px-0 ml-3 text-active"
           style="max-width: 15%; right: 0;position:relative; height:100%;">
            CREAR ROL
        </a>
        @else
            <a type="button" id="createRole" style="max-width: 15%; right: 0;position:relative; height:100%;"
               class="content container-fluid btn-e-disabled rounded border-0 px-0 ml-3"
               title="No tiene permisos para esta accion">
                CREAR ROL
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
                           placeholder="Ingrese un nombre o descripcion de rol"
                           style="height: 35px !important; padding: 0" required>
                </div>
            </div>

            <div>
                <label class="label-primary">Recientes</label>
                <div style="margin-top: 1rem" id="recent">
                    @foreach($roles->slice(0, 6) as $role)
                        <button id="roleBtn" class="item-list d-flex align-items-center border-0 bg-white rounded"
                                style="width: 100%; height: 80px; cursor: pointer" value="{{ $role->id }}"
                                onclick="getRoleData(this)">

                            <span id="logo-span" class="material-icons icon-span material-icons ml-1 mr-3">
                            badge
                            </span>

                            <div class="d-flex flex-column" style="justify-content: center;">
                                <label id="nameLbl" class="label-text-form label-extra">
                                    {{ $role->name }}
                                </label>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        @permission('roles.show')
        <div id="right-panel" class="border rounded right-panel-content active-panel" style="display: none; padding-bottom: 20px">
            @include('general.roles._show')
        </div>

        <div id="right-panel-empty" class="rounded right-panel-empty inactive-panel">
            <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                <span class="material-icons" style="font-size: 70px; color: #E5E5E5">chrome_reader_mode</span>
                <label style="color: #979797; font-size: 16px; text-align: center; width: 170px">
                    Selecciona un rol para ver mas detalles
                </label>
            </div>
        </div>
        @else
            <div id="right-panel-locked" class="rounded right-panel-empty inactive-panel">
                <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                    <span class="material-icons" style="font-size: 70px; color: #E5E5E5">no_accounts</span>
                    <label style="color: #979797; font-size: 16px; text-align: center">
                        Parece que no tienes permiso para ver esta seccion
                    </label>
                </div>
            </div>
            @endpermission
    </main>

    @permission('roles.store')
    @include('general.roles._modal')
    @endpermission

    @permission('roles.destroy')
    @include('general.roles.partials._delete')
    @endpermission
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            /** Selects **/
            $(function () {
                let permissions = {!! json_encode($permissions) !!};
                permissions.unshift({id:0, name: "Todos"});

                $('#permissions').selectize({
                    plugins: ['remove_button'],
                    maxItems: null,
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: permissions,
                    sortField: {
                        field: 'id',
                        direction: 'asc'
                    }
                });

            });

            /** Reset del formulario **/
            $('#exampleModal').on('hidden.bs.modal', function (){

                var $select = $('#permissions').selectize();
                $select[0].selectize.clear();

                $(this).find('#roleForm').trigger('reset')
            })

            /** Busqueda de roles **/
            $('#search').keyup(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ url('roles') }}",
                    method: 'get',
                    data: {
                        search: $(this).val()
                    },
                    success: function (result) {

                        let recent = $('#recent');

                        recent.empty();

                        console.log(result)
                        if (result.roles.length > 0) {

                            $.each(result.roles.slice(0,6), function (key, value) {

                                recent.append(
                                    '<button id="roleBtn" class="item-list d-flex align-items-center border-0 bg-white rounded"' +
                                    'style="width: 100%; height: 80px; cursor: pointer" value="'+ value.id +'" onclick="getRoleData(this)">' +

                                        '<span id="logo-span" class="material-icons icon-span material-icons ml-1 mr-3">badge</span>'+

                                        '<div class="d-flex flex-column" style="justify-content: center;">'+
                                            '<label id="nameLbl" class="label-text-form label-extra">'+
                                                value.name +
                                            '</label>'+
                                        '</div>'+
                                    '</button>')
                            })
                        } else {

                            recent.append(
                                '<button id="errorMessage" class="d-flex align-items-center border-0 bg-white rounded" style="width: 100%; height: 80px;">' +
                                '<span class="material-icons" style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;' +
                                'align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem; background-color: #FD4F00; color: white">warning</span>' +
                                '<div class="d-flex flex-column" style="justify-content: center;">' +
                                '<label class="label-text-form searchBottomLbl">' +
                                'No se han encontrado resultados' +
                                '</label></div></button>'
                            );
                        }

                    }
                });
            });
        });

        /** Detalles del rol **/
        function getRoleData(button) {

            let element = $(button);
            if (element.hasClass('e-active') === false)
                element.addClass('e-active')

            $('.item-list').not(element).removeClass('e-active')

        @permission('roles.show')
            let roleId = $(button).val();

            $.ajax({
                url: "{{ url('/roles') }}/" + roleId,
                method: 'get',
                success: function (result) {

                    $('#right-panel-empty').css('display', 'none');
                    $('#right-panel').css('display', 'initial');

                    $('#editRole').attr('data-id', result.role.id)

                    let permissionsSpn =$('#permissionsSpn');
                    permissionsSpn.empty();

                    $('#permissions_count').text(result.role.permissions_count)
                    $('#users_count').text(result.role.users_count)

                    if (result.role.permissions.length > 0){
                        $.each(result.role.permissions, function( index, value ) {

                            permissionsSpn.append(
                                '<label class="col-auto btn-out-compl text-normal p-1 ml-2 rounded">'+ value.name +'</label>'
                            );
                        });
                    } else {
                        permissionsSpn.append(
                            '<label class="col-auto text-normal p-1 ml-2 rounded">No se han encontrado permisos asignados</label>'
                        );
                    }

                    @permission('roles.update')
                        $('#editRole').on('click', function (){
                            loadEditForm(result.role)
                        })
                    @endpermission

                    @permission('roles.destroy')
                        $('#deleteRole').on('click', function (){
                            loadDeleteForm(result.role)
                        })
                    @endpermission

                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.responseJSON.message
                    })
                }
            });
        @else
            Toast.fire({
                icon: 'error',
                html: '&nbsp;&nbsp;' + "No posee permisos para ver el detalle del rol"
            })
        @endpermission
        }

        /** Carga de formulario para edicion de rol **/
        function loadEditForm(role){
            let form = $('#roleForm')
            let roleModal = $('#exampleModal')
            let roleId = $('#editRole').data('id')

            if (roleModal.find('input[name="_method"]').length === 0){
                roleModal.find('form').prepend('<input type="hidden" name="_method" value="patch">');
            }

            let url = '{{ route("roles.update", ":id") }}';
            url = url.replace(':id', roleId);
            $('#roleForm').attr("action", url);

            form.find('#name').val(role.name)
            form.find('#slug').val(role.slug)

            var $select = $('#permissions').selectize();
            let permissionsId = [];
            $.each(role.permissions, function (key, item) {
                permissionsId.push(this.id);
            });
            $select[0].selectize.setValue(permissionsId);

            roleModal.modal('show')
        }

        /** Carga de formulario para eliminar un rol **/
        function loadDeleteForm(role){
            let form = $('#deleteForm')
            let roleModal = $('#deleteModal')

            let url = '{{ route("roles.destroy", ":id") }}';
            url = url.replace(':id', role.id);
            form.attr("action", url);

            form.find('#message').html("Esta seguro de que desea eliminar el rol `<strong>" + role.name + "</strong>`? " +
                "Todos los usuarios asignados a este rol pasaran al rol `<strong>No asignado</strong>`.")

            $('#deleteModal').modal('show')
        }

    </script>
@append
