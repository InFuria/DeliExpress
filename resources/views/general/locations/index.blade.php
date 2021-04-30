@extends('general.layouts.app')

@section('title', 'Ubicaciones')

@section('styles')
    <style>

        main.container{
            display: inline-flex;
            max-height: 100%;
            height: 700px;
        }

        main.container, .right-panel-empty{
            max-width: 98% !important;
            width: 98% !important;
        }

        .container > div {
            display: inline-block;
            width: 100% !important;
            height: 93%;
            margin-left: 1.5rem !important;
            margin-right: 1rem !important;
            margin-top: 1.50rem !important;
        }

        .search {
            height: 35px !important;
            padding: 0
        }

        .btn-extra {
            width: 200px;
        }
    </style>
@endsection

@section('main')

    <div style="display: flex">

        {{ Breadcrumbs::render('locations-end') }}

        @permission('locations.store')
        <a type="button" id="createDepartment" data-type="department"
           class="content container-fluid create-location text-active bg-orange-main rounded shadow-primary border-0 px-0 ml-3 text-active"
           style="max-width: 15%; right: 0;position:relative; height:100%;">
            CREAR DEPARTAMENTO
        </a>
        @else
            <a type="button" id="createDepartment" style="max-width: 15%; right: 0;position:relative; height:100%;"
               class="content container-fluid btn-e-disabled rounded border-0 px-0 ml-3"
               title="No tiene permisos para esta accion">
                CREAR DEPARTAMENTO
            </a>
        @endpermission

    </div>

    @include('sweetalert::alert')

    <div class="d-flex d-inline-flex m-0 p-0">
        @include('general.locations.departments._list')
        @include('general.locations.municipalities._list')
        @include('general.locations.zones._list')
    </div>

    @permission('locations.store')
    @include('general.locations.partials._create')
    @endpermission

    @permission('locations.destroy')
    @include('general.locations.partials._delete')
    @endpermission
@endsection

@section('js')
    <script>

        /** Manejo de estado de botones por bloque **/
        $('#recent-departments, #recent-municipalities, #recent-zones').on('click', '.item-list', function (){
            if ($(this).hasClass('e-active') === false)
                $(this).addClass('e-active')

            $(this).parent().children('.item-list').not($(this)).removeClass('e-active')
        })

        /** Busqueda de departamentos **/
        $('#department-search').keyup(function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('locations/departments') }}",
                method: 'get',
                data: {
                    search: $(this).val()
                },
                success: function (result) {

                    $('#recent-departments').empty();

                    resetMunicipalities()
                    resetZones()

                    if (result.departments.length > 0) {
                        $.each(result.departments.slice(0,6), function (key, value) {

                            insertIn (value, "department")
                        })
                    } else {
                        $('#recent-departments').append(
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

        /** Busqueda de municipios **/
        $('#municipality-search').keyup(function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('locations/municipalities') }}",
                method: 'get',
                data: {
                    search: $(this).val(),
                    department: $(this).data('id')
                },
                success: function (result) {

                    $('#recent-municipalities').empty();
                    resetZones()

                    if (result.municipalities.length > 0) {
                        $.each(result.municipalities.slice(0,6), function (key, value) {

                            insertIn (value, "municipality")
                        })
                    } else {
                        $('#recent-municipalities').append(
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

        /** Busqueda de zonas **/
        $('#zone-search').keyup(function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('locations/zones') }}",
                method: 'get',
                data: {
                    search: $(this).val(),
                    municipality: $(this).data('id')
                },
                success: function (result) {

                    $('#recent-zones').empty();

                    if (result.zones.length > 0) {
                        $.each(result.zones.slice(0,6), function (key, value) {

                            insertIn (value, "zone")
                        })
                    } else {
                        $('#recent-zones').append(
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


        /** Manejo de los botones para crear ubicaciones ------------------------------------------------------------**/
        $('#createDepartment').on('click', function (){

            loadLocationForm($(this))
        })

        $('.locations-container').on("click", ".create-location", function (){

            loadLocationForm($(this))
        })

        /** Dar formato al modal de crear **/
        function loadLocationForm(element){
            let button = $(element)
            let create = $('#createModal')
            let form = $('#locationForm')

            let id = button.parent().data('id')
            let type = button.data('type')
            let parent = button.closest('button').find('#nameLbl').text()

            create.find('#complete').attr({'data-id': id, 'data-type': type});

            switch (type){

                case "department":
                    create.find('h6').text("Nuevo departamento")
                    form.find('.sub-2').text("Detalles del departamento");
                    create.find('#complete').addClass('btn-extra').text("Crear departamento");

                    break;

                case "municipality":
                    create.find('h6').text(parent + " - Nuevo municipio")
                    form.find('.sub-2').text("Detalles del municipio");
                    create.find('#complete').text('Crear municipio')

                    break;

                case "zone":
                    create.find('h6').text(parent + " - Nueva zona")
                    form.find('.sub-2').text("Detalles de la zona");
                    create.find('#complete').text('Crear zona')

                    break;

                default:
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + "Hubo un error al procesar los datos de la ubicacion!"
                    })
            }

            create.modal('show')
        }

        /** Manejo de formulario de creacion y actualizacion de ubicaciones **/
        $('#locationForm').on('submit', function (e){

            e.preventDefault()

            let create = $('#createModal');
            let type = create.find('#complete').attr('data-type');
            let id   = create.find('#complete').attr('data-id');
            let name = $(this).find('#name').val();

            storeLocation(type, name, id)
        })

        /** Funcion para crear y actualizar ubicaciones **/
        function storeLocation(type, name, id){

            let data = null;
            switch (type){
                case "department":
                    data = {type: 'department', name: name}
                    break;

                case "municipality":
                    data = {type: 'municipality', name: name, department_id: id}
                    break;

                case "zone":
                    data = {type: 'zone', name: name, municipality_id: id}
                    break;

                default:
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + "Hubo un error al procesar los datos de la ubicacion!"
                    })
            }

            if ($('#locationForm').find('input[name="_method"]').length === 0){

                $.ajax({
                    url: "locations",
                    method: 'POST',
                    data: data,
                    success: function (result) {

                        loadDepartments()

                        resetInitial()

                        $('#createModal').modal('hide')

                        Toast.fire({
                            icon: 'success',
                            html: '&nbsp;&nbsp;' + result.message
                        })
                    },
                    error: function (result) {
                        Toast.fire({
                            icon: 'error',
                            html: '&nbsp;&nbsp;' + result.responseJSON.message
                        })
                    }
                });

            } else {

                let url = '{{ route("locations.update", ":id") }}';
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    method: 'PATCH',
                    data: data,
                    success: function (result) {

                        loadDepartments()

                        resetInitial()

                        $('#createModal').modal('hide')

                        Toast.fire({
                            icon: 'success',
                            html: '&nbsp;&nbsp;' + result.message
                        })
                    },
                    error: function (result) {
                        Toast.fire({
                            icon: 'error',
                            html: '&nbsp;&nbsp;' + result.responseJSON.message
                        })
                    }
                });
            }
        }



        /** Manejo de los botones para editar ubicaciones -----------------------------------------------------------**/
        $('.locations-container').on("click", ".edit-location", function (){

            let button = $(this)
            let editModal = $('#createModal')
            let form = $('#locationForm')

            let id = button.parent().data('id')
            let type = button.data('type')
            let parent = button.closest('button').find('#nameLbl').text()
            let url = null

            editModal.find('#complete').attr({'data-id': id, 'data-type': type});

            switch (type){

                case "department":
                    editModal.find('h6').text("Editar departamento - " + parent)
                    form.find('.sub-2').text("Detalles del departamento");
                    editModal.find('#complete').addClass('btn-extra').text("Actualizar");

                    url = '{{ route("locations.departments", ":id") }}';
                    url = url.replace(':id', id);

                    break;

                case "municipality":
                    editModal.find('h6').text("Editar municipio - " + parent)
                    form.find('.sub-2').text("Detalles del municipio");
                    editModal.find('#complete').text('Actualizar')

                    url = '{{ route("locations.municipalities", ":id") }}';
                    url = url.replace(':id', id);

                    break;

                case "zone":
                    editModal.find('h6').text("Editar zona - " + parent)
                    form.find('.sub-2').text("Detalles de la zona");
                    editModal.find('#complete').text('Actualizar')

                    url = '{{ route("locations.zones", ":id") }}';
                    url = url.replace(':id', id);

                    break;

                default:
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + "Hubo un error al procesar los datos de la ubicacion!"
                    })
            }

            // Obtener el nombre mas actualizado para esta ubicacion
            $.ajax({
                url: url,
                method: 'GET',
                success: function (result) {

                    $('#locationForm').find('#name').val(result.location.name);
                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.responseJSON.message
                    })
                }
            });

            if (form.find('input[name="_method"]').length === 0){
                form.prepend('<input type="hidden" name="_method" value="patch">');
            }

            editModal.modal('show')
        })



        /** Manejo de los botones para eliminar ubicaciones ---------------------------------------------------------**/
        $('.locations-container').on("click", ".delete-location", function (){

            let button = $(this)
            let deleteModal = $('#deleteModal')
            let form = $('#deleteForm')

            let id = button.parent().data('id')
            let type = button.data('type')
            let parent = button.closest('button').find('#nameLbl').text()

            deleteModal.find('#btnAction').attr({'data-id': id, 'data-type': type});

            switch (type){

                case "department":
                    deleteModal.find('h6').text("Eliminar departamento")
                    form.find('#message').text("Esta seguro de que desea eliminar el departamento " + parent + "?");

                    break;

                case "municipality":
                    deleteModal.find('h6').text("Eliminar municipio")
                    form.find('#message').text("Esta seguro de que desea eliminar el municipio " + parent + "?");

                    break;

                case "zone":
                    deleteModal.find('h6').text("Eliminar zona")
                    form.find('#message').text("Esta seguro de que desea eliminar la zona " + parent + "?");

                    break;

                default:
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + "Hubo un error al procesar los datos de la ubicacion!"
                    })
            }

            deleteModal.modal('show')
        })

        /** Manejo de formulario de eliminacion **/
        $('#deleteForm').on('submit', function (e){

            e.preventDefault()

            let deleteModal = $('#deleteModal');
            let type = deleteModal.find('#btnAction').attr('data-type');
            let id   = deleteModal.find('#btnAction').attr('data-id');
            let name = $(this).find('#name').val();

            let url = '{{ route("locations.destroy", ":id") }}';
            url = url.replace(':id', id);

            let data = null;
            switch (type){
                case "department":
                    data = {type: 'department'}
                    break;

                case "municipality":
                    data = {type: 'municipality'}
                    break;

                case "zone":
                    data = {type: 'zone'}
                    break;

                default:
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + "Hubo un error al procesar los datos de la ubicacion!"
                    })
            }

            $.ajax({
                url: url,
                method: 'DELETE',
                data: data,
                success: function (result) {

                    loadDepartments()

                    resetInitial()

                    $('#deleteModal').modal('hide')

                    Toast.fire({
                        icon: 'success',
                        html: '&nbsp;&nbsp;' + result.message
                    })
                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.responseJSON.message
                    })
                }
            });
        })



        /** Recarga lista de departamentos **/
        function loadDepartments(){
            $('#recent-departments').empty()

            $.ajax({
                url: "locations/departments",
                method: 'GET',
                success: function (result) {

                    if (result.departments.length > 0) {
                        $.each(result.departments.slice(0,6), function (key, value) {

                            insertIn (value, "department")
                        })
                    } else {
                        $('#recent-departments').append(
                            '<button id="errorMessage" class="d-flex align-items-center border-0 bg-white rounded" style="width: 100%; height: 80px;">' +
                            '<span class="material-icons" style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;' +
                            'align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem; background-color: #FD4F00; color: white">warning</span>' +
                            '<div class="d-flex flex-column" style="justify-content: center;">' +
                            '<label class="label-text-form searchBottomLbl">' +
                            'No se han encontrado resultados' +
                            '</label></div></button>'
                        );
                    }
                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.responseJSON.message
                    })
                }
            });
        }

        /** Recarga lista de municipios **/
        function loadMunicipalities(department){
            $('.inactive-panel').attr('style', 'display: none !important');
            $('#municipalities-list > .active-panel').css('display', 'initial')
            $('#municipality-search').attr('data-id', department)

            resetZones()
            $('#recent-municipalities').empty()

            $.ajax({
                url: "locations/municipalities",
                data: {department: department},
                method: 'GET',
                success: function (result) {

                    if (result.municipalities.length > 0) {
                        $.each(result.municipalities.slice(0,6), function (key, value) {

                            insertIn (value, "municipality")
                        })
                    } else {
                        $('#recent-municipalities').append(
                            '<button id="errorMessage" class="d-flex align-items-center border-0 bg-white rounded" style="width: 100%; height: 80px;">' +
                            '<span class="material-icons" style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;' +
                            'align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem; background-color: #FD4F00; color: white">warning</span>' +
                            '<div class="d-flex flex-column" style="justify-content: center;">' +
                            '<label class="label-text-form searchBottomLbl">' +
                            'No se han encontrado resultados' +
                            '</label></div></button>'
                        );
                    }
                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.responseJSON.message
                    })
                }
            });
        }

        /** Recarga lista de zonas **/
        function loadZones(municipality){
            $('.inactive-panel').attr('style', 'display: none !important');
            $('#zones-list > .active-panel').css('display', 'initial')
            $('#zone-search').attr('data-id', municipality)

            $('#recent-zones').empty()

            $.ajax({
                url: "locations/zones",
                data: {municipality: municipality},
                method: 'GET',
                success: function (result) {

                    if (result.zones.length > 0) {
                        $.each(result.zones.slice(0,6), function (key, value) {

                            insertIn (value, "zone")
                        })
                    } else {
                        $('#recent-zones').append(
                            '<button id="errorMessage" class="d-flex align-items-center border-0 bg-white rounded" style="width: 100%; height: 80px;">' +
                            '<span class="material-icons" style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;' +
                            'align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem; background-color: #FD4F00; color: white">warning</span>' +
                            '<div class="d-flex flex-column" style="justify-content: center;">' +
                            '<label class="label-text-form searchBottomLbl">' +
                            'No se han encontrado resultados' +
                            '</label></div></button>'
                        );
                    }
                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.responseJSON.message
                    })
                }
            });
        }

        /** Funcion para insertar los nuevos elementos **/
        function insertIn (data, type){

            if (type === "department"){

                $('#recent-departments').append(
                    '<button id="departmentBtn" class="item-list d-flex align-items-center justify-content-between border-0 bg-white rounded" ' +
                    'value="'+ data.id +'" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)" onclick="loadMunicipalities($(this).val())">'+

                    '<div class="d-flex align-items-center justify-content-start">'+
                    '<span id="logo-span" class="material-icons icon-span material-icons ml-1 mr-3">'+
                    'public</span>'+
                    '<div class="d-flex flex-column justify-content-center">'+
                    '<label id="nameLbl" class="label-text-form label-extra">'+
                    data.name+
                    '</label>'+
                    '<label class="label-text-form searchBottomLbl">'+
                    data.municipalities_count + ' municipios asignados' +
                    '</label>'+
                    '</div>'+
                    '</div>'+

                    '<div class="locations-buttons-container" data-id="'+ data.id +'">'+
                    '<a type="button" class="locations-button create-location" title="Añadir municipio" data-type="municipality">'+
                    '<span class="material-icons">add</span>'+
                    '</a>'+

                    '<a type="button" class="locations-button edit-location" title="Editar departamento" data-type="department">'+
                    '<span class="material-icons">drive_file_rename_outline</span>'+
                    '</a>'+

                    '<a type="button" class="locations-button delete-location" title="Eliminar departamento" data-type="department">'+
                    '<span class="material-icons">close</span>'+
                    '</a>'+
                    '</div>'+
                    '</button>')
            }

            if (type === "municipality"){

                $('#recent-municipalities').append(
                    '<button id="municipalityBtn" class="item-list d-flex align-items-center justify-content-between border-0 bg-white rounded" ' +
                    'value="'+ data.id +'" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)" onclick="loadZones($(this).val())">'+

                    '<div class="d-flex align-items-center justify-content-start">'+
                    '<span id="logo-span" class="material-icons icon-span material-icons ml-1 mr-3">'+
                    'dashboard</span>'+
                    '<div class="d-flex flex-column justify-content-center">'+
                    '<label id="nameLbl" class="label-text-form label-extra">'+
                    data.name+
                    '</label>'+
                    '<label class="label-text-form searchBottomLbl">'+
                    data.zones_count + ' zonas asignadas' +
                    '</label>'+
                    '</div>'+
                    '</div>'+

                    '<div class="locations-buttons-container" data-id="'+ data.id +'">'+
                    '<a type="button" class="locations-button create-location" title="Añadir zona" data-type="zone">'+
                    '<span class="material-icons">add</span>'+
                    '</a>'+

                    '<a type="button" class="locations-button edit-location" title="Editar municipio" data-type="municipality">'+
                    '<span class="material-icons">drive_file_rename_outline</span>'+
                    '</a>'+

                    '<a type="button" class="locations-button delete-location" title="Eliminar municipio" data-type="municipality">'+
                    '<span class="material-icons">close</span>'+
                    '</a>'+
                    '</div>'+
                    '</button>')
            }

            if (type === "zone"){

                $('#recent-zones').append(
                    '<button id="zoneBtn" class="item-list d-flex align-items-center justify-content-between border-0 bg-white rounded" ' +
                    'value="'+ data.id +'" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">'+

                    '<div class="d-flex align-items-center justify-content-start">'+
                    '<span id="logo-span" class="material-icons icon-span material-icons ml-1 mr-3">'+
                    'pin_drop</span>'+
                    '<div class="d-flex flex-column justify-content-center">'+
                    '<label id="nameLbl" class="label-text-form label-extra">'+
                    data.name+
                    '</label>'+
                    '</div>'+
                    '</div>'+

                    '<div class="locations-buttons-container" data-id="'+ data.id +'">'+
                    '<a type="button" class="locations-button edit-location" title="Editar zona" data-type="zone">'+
                    '<span class="material-icons">drive_file_rename_outline</span>'+
                    '</a>'+

                    '<a type="button" class="locations-button delete-location" title="Eliminar zona" data-type="zone">'+
                    '<span class="material-icons">close</span>'+
                    '</a>'+
                    '</div>'+
                    '</button>')
            }
        }

        /** Funcion para actualizar las vistas de municipios y zonas **/
        function resetInitial(){
            $('.active-panel').css('display', 'none')
            $('#municipalities-list > .inactive-panel').css('display', 'initial');
            $('#zones-list > .inactive-panel').css('display', 'initial');
        }
        function resetMunicipalities(){

            $('#municipalities-list > .active-panel').css('display', 'none')
            $('#municipalities-list > .inactive-panel').css('display', 'initial')
        }
        function resetZones(){

            $('#zones-list > .active-panel').css('display', 'none')
            $('#zones-list > .inactive-panel').css('display', 'initial')
        }

        /** Cambio de visibilidad con hover en botones ancor **/
        function mouseOver(element){
            $(element).children('.locations-buttons-container').css('visibility', 'visible')
        }
        function mouseOut(element){
            $(element).children('.locations-buttons-container').css('visibility', 'hidden')
        }

        /** Manejo de modal **/
        $('#createModal').on('hide.bs.modal', function (){
            $('#locationForm').trigger('reset')

            $(this).find('input[name="_method"]').remove()

            let complete = $('#complete')
            complete.text("");
            complete.attr("data-id", "");
            complete.attr("data-type", "");
        })
    </script>
@append
