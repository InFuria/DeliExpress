@extends('general.layouts.app')

@section('title', 'Clientes')

@section('styles')
    <style>
        .label-extra{
            color: black;
            font-size: 16px;
            letter-spacing: 0.05rem;
            margin-bottom: 4px !important;
            border: 0;
            cursor: pointer;
        }
    </style>
@endsection

@section('main')

    <div style="display: flex">
        {{ Breadcrumbs::render('clients-end') }}

        @permission('clients.store')
        <a type="button" id="createClient" data-toggle="modal" data-target="#exampleModal"
           class="content container-fluid text-active bg-orange-main rounded shadow-primary border-0 px-0 ml-3 text-active"
           style="max-width: 15%; right: 0;position:relative; height:100%;">
            CREAR CLIENTE
        </a>
        @else
            <a type="button" id="createClient" style="max-width: 15%; right: 0;position:relative; height:100%;"
               class="content container-fluid btn-e-disabled rounded border-0 px-0 ml-3"
               title="No tiene permisos para esta accion">
                CREAR CLIENTE
            </a>
            @endpermission

    </div>

    <main class="container bg-white shadow-e-sm border-0 mt-3 ml-3" style="height: 700px; max-height: 100%; max-width: 82%; width: 82%; display: inline-flex">
        @include('sweetalert::alert')

        <div class="mr-3" style="margin-left: 1.5rem !important; margin-top: 1.50rem !important; height: 93%; width: 37.3%;max-width: 37.3%; display: inline-block;vertical-align: top">
            <div style="height: 20%">
                <label class="label-primary mt-2" for="search">Buscar</label>
                <div class="form-group" style="margin-top: 1.5rem;">
                    <input type="text" class="form-control rounded-0 input-out" id="search" name="search"
                           placeholder="Ingrese un nombre, apellido o email" style="height: 35px !important; padding: 0" required>
                </div>
            </div>

            <div>
                <label class="label-primary">Recientes</label>
                <div style="margin-top: 1rem" id="recent">
                    @foreach($clients->slice(0, 6) as $client)
                        <button id="clientBtn" class="item-list d-flex align-items-center border-0 bg-white rounded"
                                value="{{ $client->id }}" onclick="getClientData(this)">

                            <span id="img-span" class="material-icons img-span material-icons">
                            portrait
                            </span>

                            <div class="d-flex flex-column" style="justify-content: center;">
                                <label id="nameLbl" class="label-text-form label-extra">
                                    {{ $client->first_name }} {{ $client->second_name }} {{ $client->first_lastname }} {{ $client->second_lastname }}
                                </label>
                                <label class="label-text-form searchBottomLbl">{{ $client->email }}</label>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        @permission('clients.show')
            <div id="right-panel" class="border rounded right-panel-content active-panel" style="display:none; padding-bottom: 20px">
                @include('general.clients._show')
            </div>

            <div id="right-panel-empty" class="rounded right-panel-empty inactive-panel">
                <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                    <span class="material-icons" style="font-size: 70px; color: #E5E5E5">chrome_reader_mode</span>
                    <label style="color: #979797; font-size: 16px; text-align: center; width: 170px">
                        Selecciona un cliente para ver mas detalles
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

    @permission('clients.store')
    @include('general.clients._modal')
    @endpermission

    @permission('clients.status')
    @include('general.clients.partials._status')
    @endpermission
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            /** Reset del formulario **/
            $('#exampleModal').on('hidden.bs.modal', function (){
                $(this).find('#modalCouponForm').trigger('reset')
            })

            /** Busqueda de clientes **/
            $('#search').keyup(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ url('clients') }}",
                    method: 'get',
                    data: {
                        search: $('#search').val()
                    },
                    success: function (result) {

                        let recent = $('#recent');

                        recent.empty();

                        if (result.clients.length > 0) {

                            $.each(result.clients.slice(0,6), function (key, client) {

                                recent.append(

                                    '<button id="clientBtn" class="item-list d-flex align-items-center border-0 bg-white rounded"'+
                                            'value="'+ client.id +'" onclick="getClientData(this)">'+

                                        '<span id="img-span" class="material-icons img-span material-icons">portrait</span>'+

                                        '<div class="d-flex flex-column" style="justify-content: center;">'+
                                            '<label id="nameLbl" class="label-text-form label-extra">'+
                                                client.first_name+client.second_name+client.first_lastname+client.second_lastname +
                                            '</label>'+
                                            '<label class="label-text-form searchBottomLbl">'+ client.email+'</label>'+
                                        '</div>'+
                                    '</button>'
                                )
                            })
                        } else {

                            recent.append(
                                '<button id="clientMessage" class="d-flex align-items-center border-0 bg-white rounded" style="width: 100%; height: 80px;">' +
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

        /** Creacion de direcciones de cliente **/
        function addAddress(element) {
            // Si aun no esta habilitado el input se crea
            if ($('#newAddress').length === 0) {

                let container = $('.addresses-container');

                container.append('<div class="d-flex align-items-center my-2">'+
                    '<input type="text" id="newAddress" class="new-input">'+
                    '<button type="button" class="closeOutBtn pull-right border-0" onclick="removeInput(`newAddress`)" title="Eliminar campo">'+
                    '<span class="material-icons" style="font-size: 18px">close</span></button>' +
                '</div>');

                // Carga la direccion al ingresar intro
                $('#newAddress').on('keyup', function (event) {
                    if (event.keyCode === 13) {

                        container.append('<div class="d-flex align-items-center mx-4 my-2 w-75">'+
                            '<input type="text" id="addresses[]" name="addresses[]" class="input-out" value="'+ $(this).val() +'">'+
                            '<button type="button" class="closeOutBtn pull-right border-0" onclick="removeInput(this)" title="Eliminar campo">'+
                            '<span class="material-icons" style="font-size: 18px">close</span></button>'+
                            '</div>');

                        $('#newAddress').parent().remove()
                    }
                });
            }
        }

        /** Funcion para remover inputs **/
        function removeInput(id){
            if(typeof id === 'object'){
                $(id).parent().remove();

            }else{
                $('#' + id).parent().remove();
            }
        }

        /** Detalles del cliente **/
        function getClientData(button) {

            let element = $(button);
            if (element.hasClass('e-active') === false)
                element.addClass('e-active')

            $('.item-list').not(element).removeClass('e-active')

            @permission('clients.show')
            let clientId = $(button).val();

            $.ajax({
                url: "{{ url('/clients') }}/" + clientId,
                method: 'get',
                success: function (result) {

                    $('#right-panel-empty').css('display', 'none');
                    $('#right-panel').css('display', 'initial');

                    updateStatusButton(result.client.status)

                    let clientCointainer = $('#clientDetails');
                    clientCointainer.find('#total_orders').text(result.client.orders_count)
                    clientCointainer.find('#delivered').text(result.delivered)
                    clientCointainer.find('#canceled').text(result.canceled)
                    clientCointainer.find('#addresses').text(result.client.addresses_count)

                    let name = result.client.first_name + " " + result.client.first_lastname;

                @permission('clients.status')
                    $('#statusClient').on('click', function (){
                        let statusModal = $('#statusModal');
                        let statusForm = statusModal.find('#statusForm');
                        let action = $('#btnAction');

                        let url = '{{ route("clients.status", ":id") }}';
                        url = url.replace(':id', result.client.id);
                        statusForm.attr('action', url);

                        let status = result.client.status === 1 || result.client.status === true ? "deshabilitar" : "habilitar";
                        action.text(status.toUpperCase())
                        statusForm.find('#message').text("Esta seguro que desea " + status + " al cliente "+ name +"?")

                        statusModal.modal('show')
                    })
                    @else
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + "No posee permisos para actualizar el estado del cupón"
                    })
                @endpermission


                @permission('clients.update')
                    $('#editClient').on('click', function (){
                        loadClientForm(result.client)
                    })

                    @else
                        Toast.fire({
                            icon: 'error',
                            html: '&nbsp;&nbsp;' + "No posee permisos para actualizar clientes"
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
                html: '&nbsp;&nbsp;' + "No posee permisos para ver el detalle de clientes"
            })
        @endpermission
        }

        /** Formulario de edicio **/
        function loadClientForm(client){
            let form = $('#clientForm');
            form.find('#email').val(client.email)
            form.find('#first_name').val(client.first_name)
            form.find('#second_name').val(client.second_name)
            form.find('#first_lastname').val(client.first_lastname)
            form.find('#second_lastname').val(client.second_lastname)
            form.find('#mobile').val(client.mobile)
            form.find('#phone').val(client.phone)

            let container = $('.addresses-container');
            $.each(client.addresses, function (k, v){
                container.append('<div class="d-flex align-items-center mx-4 my-2 w-75">'+
                    '<input type="text" id="addresses[]" name="addresses[]" class="input-out" value="'+ v.direction +'">'+
                    '<button type="button" class="closeOutBtn pull-right border-0" onclick="removeInput(this)" title="Eliminar campo">'+
                    '<span class="material-icons" style="font-size: 18px">close</span></button>'+
                    '</div>');
            })

            if (form.find('input[name="_method"]').length === 0){
                form.prepend('<input type="hidden" name="_method" value="patch">');
            }

            let url = '{{ route("clients.update", ":id") }}';
            url = url.replace(':id', client.id);
            form.attr('action', url)

            $('#exampleModal').modal('show')
        }


        /** Manejo de botones de estado de cliente **/
        function updateStatusButton(status){
            let statusBtn = $('#statusClient');

            if (status === 1 || status === true) {
                statusBtn.removeClass('btn-out-primary').addClass('btn-out-disabled').text('Deshabilitar cliente')
            } else {
                statusBtn.removeClass('btn-out-disabled').addClass('btn-out-primary').text('Habilitar cliente')
            }
        }


        $('#exampleModal').on('hidden.bs.modal', function (){
            resetHeaders()

            $('#clientForm').trigger('reset')
            $('#addresses-container').empty()
        });
    </script>
@append
