@extends('general.layouts.app')

@section('title', 'Negocios')

@section('styles')
    <style>
        .product-right-panel {
            display: inline-flex;
            align-items: center;
            justify-content: center !important;
            margin-left: 0.75rem !important;
            margin-top: 1.50rem !important;
            height: 93%;
            width: 47%;
            max-width: 47%;
            border-radius: 6px;
        }

        .store-border-bottom {
            border-bottom: 1px solid #E5E5E5;
        }

        .new-input {
            background: rgba(253, 79, 0, 0.1);
            border: 0;
            margin-left: 1rem;
            outline: none;
            box-sizing: border-box;
            padding-left: 10px !important;
        }

        .sub {
            width: 75%;
            margin-left: 2rem !important;
        }

        .cat-header {
            height: 30px;
        }
    </style>
@endsection
@section('main')

    <div style="display: flex">

        {{ Breadcrumbs::render('stores-end') }}

        @permission('users.store')
        <a type="button" id="createStore" data-toggle="modal" data-target="#exampleModal"
           class="content container-fluid text-active bg-orange-main rounded shadow-primary border-0 px-0 ml-3 text-active"
           style="max-width: 15%; right: 0;position:relative; height:100%;">
            CREAR NEGOCIO
        </a>
        @else
            <a type="button" id="createStore" style="max-width: 15%; right: 0;position:relative; height:100%;"
               class="content container-fluid btn-e-disabled rounded border-0 px-0 ml-3"
               title="No tiene permisos para esta accion">
                CREAR NEGOCIO
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
                           placeholder="Ingrese el nombre de un negocio"
                           style="height: 35px !important; padding: 0" required>
                </div>
            </div>

            <div>
                <label class="label-primary">Recientes</label>
                <div style="margin-top: 1rem" id="recent">
                    @foreach($stores->slice(0, 6) as $store)
                        <button id="storeBtn" class="item-list d-flex align-items-center border-0 bg-white rounded"
                                style="width: 100%; height: 80px; cursor: pointer" value="{{ $store->id }}"
                                onclick="getStoreData(this)">

                            <img
                                src="{{ $store->logo != "" ? asset("storage/stores/$store->id/$store->logo") : asset("storage/noimage.jpg")}}"
                                id="img-list"
                                style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;
                                 align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem;">

                            <div class="d-flex flex-column" style="justify-content: center;">
                                <label id="nameLbl" class="label-text-form"
                                       style="color: black; font-size: 16px; letter-spacing: 0.05rem; margin-bottom: 4px !important;  border: 0; cursor: pointer">
                                    {{ $store->long_name }}
                                </label>

                                <label class="label-text-form searchBottomLbl">
                                    @foreach($store->categories as $cat)
                                        {{ $cat->name }} {{ $store->categories->last()->id == $cat->id ? '' : ' - ' }}
                                    @endforeach
                                </label>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        @permission('stores.store')
        <div id="right-panel" class="border right-panel-content active-panel rounded" style="display: none;">
            @include('general.stores._show')
        </div>

        <div id="right-panel-empty" class="rounded right-panel-empty inactive-panel">
            <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                <span class="material-icons" style="font-size: 70px; color: #E5E5E5">chrome_reader_mode</span>
                <p style="color: #979797; font-size: 16px; text-align: center; width: 170px">
                    Selecciona un negocio para ver mas detalles
                </p>
            </div>
        </div>
        @else
            <div id="right-panel-locked" class="rounded right-panel-empty inactive-panel">
                <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                    <span class="material-icons" style="font-size: 70px; color: #E5E5E5">no_accounts</span>
                    <p style="color: #979797; font-size: 16px; text-align: center">
                        Parece que no tienes permiso para ver esta seccion
                    </p>
                </div>
            </div>
            @endpermission
    </main>

    @permission('users.store')
    @include('general.stores._modal')
    @endpermission
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            @if (Session::get('deleted'))
                $('#exampleModal').modal('show');
            @endif

            /** Limpia el modal inicial de los detalles del form de productos **/
            $('#exampleModal').on('hidden.bs.modal', function () {
                closeProductPanel()
                resetProducts()
                //resetHeaders()
            })

            /** Selects **/
            $(function () {
                $('#categories').selectize({
                    plugins: ['remove_button'],
                    maxItems: null,
                    persist: false,
                    placeholder: 'Tipo de negocio',
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: {!! json_encode($categories) !!},
                    sortField: {
                        field: 'name',
                        direction: 'asc'
                    }
                });

                $('#department_id').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    placeholder: 'Departamento',
                    create: false,
                    options: {!! json_encode($departments) !!},
                });

                $('#municipality_id').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    placeholder: 'Municipio',
                    create: false,
                    options: {!! json_encode($municipalities) !!},
                });

                $('#zone_id').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    placeholder: 'Zona',
                    create: false,
                    options: {!! json_encode($zones) !!},
                });
            });

            /** Imagenes del form de negocios **/
            $('#logo').on('change', function () { //on file input change

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

                                    $('#logo-span').remove();

                                    var appendImg = $('<img id="logo-span" class="mx-4" src="' + e.target.result + '" style="width: 64px; height: 64px; border-radius: 50%;' +
                                        ' display: flex; align-items: center;justify-content: center;">'); //create image element


                                    $(appendImg).insertAfter($('#logo')); //append image to output element
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

            $('#cover').on('change', function () { //on file input change
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

                                    $('#cover-span').remove();

                                    var appendImg = $('<img id="cover-span" class="mx-4" src="' + e.target.result + '" style="width: 64px; height: 64px; border-radius: 50%;' +
                                        ' display: flex; align-items: center;justify-content: center;">'); //create image element


                                    $(appendImg).insertAfter($('#cover')); //append image to output element
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

            /** Limpieza de form al pasar de editar a crear **/
            $('#createStore').on('click', function () {
                resetHeaders();

                let modalForm = $('#modalStoreForm');
                modalForm.attr('action', "{{ route('stores.store') }}").trigger('reset');
                modalForm.find('input[name="_method"]').remove();
                modalForm.find('.modal-title').val('Nuevo negocio');

                var $select = $('#categories').selectize();
                $select[0].selectize.clear();

                var $select = $('#department_id').selectize();
                $select[0].selectize.clear();

                var $select = $('#municipality_id').selectize();
                $select[0].selectize.clear();

                var $select = $('#zone_id').selectize();
                $select[0].selectize.clear();

                $('.categoriesContainer').empty();
                $('#productGroup, #product').css('display', 'none');

                $('#logo-span').replaceWith('<span id="logo-span" class="material-icons material-icons mx-4"' +
                    'style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;' +
                    'align-items: center;justify-content: center; color: white">' +
                    'camera</span>'
                );

                $('#cover-span').replaceWith('<span id="cover-span" class="material-icons material-icons mx-4"' +
                    'style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;' +
                    'align-items: center;justify-content: center; color: white">' +
                    'camera</span>'
                );
            })

            /** Busqueda de negocios **/
            $('#search').keyup(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ url('stores') }}",
                    method: 'get',
                    data: {
                        search: $('#search').val()
                    },
                    success: function (result) {

                        let recent = $('#recent');

                        recent.empty();

                        if (result.stores.length > 0) {

                            $.each(result.stores.slice(0, 6), function (key, value) {

                                let logo = value.logo !== "" ? "storage/stores/" + value.id + "/" + value.logo : "storage/noimage.jpg";

                                let categories = "";

                                $.each(value.categories, function (k, v) {
                                    categories += v.name + " " + (k === value.categories.length - 1 ? '' : ' - ')
                                });

                                recent.append(
                                    '<button id="storeBtn" class="item-list d-flex align-items-center border-0 bg-white rounded" ' +
                                    'style="width: 100%; height: 80px; cursor: pointer" value="' + value.id + '" onclick="getStoreData(this)">' +
                                    '<img src="{{asset("/")}}' + logo + '" id="img-list"' +
                                    'style="width: 50px; height: 50px; border-radius: 50%; font-size: 28px; display: flex;' +
                                    'align-items: center;justify-content: center; margin-left: 0.5rem; margin-right: 1.5rem;">' +
                                    '<div class="d-flex flex-column" style="justify-content: center;">' +
                                    '<label id="nameLbl" class="label-text-form"' +
                                    'style="color: black; font-size: 16px; letter-spacing: 0.05rem; margin-bottom: 4px !important;  border: 0; cursor: pointer">' +
                                    value.long_name + '</label>' +
                                    '<label class="label-text-form searchBottomLbl">' +
                                    categories + '</label></div></button>'
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


        /** Imagen del form de productos **/
        function loadImage(element){

            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                var data = $(element)[0].files; //this file data

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


                                $(appendImg).insertAfter($('#img')); //append image to output element
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
        }


        /** Funcionalidad collapse de categorias **/
        $(".categoriesContainer").on('click', '.cat-header', function () {

            let header = $(this);
            let content = header.next();

            content.slideToggle(100, function () {
                let span = header.children('span');

                if ($(span).text() === "arrow_drop_down"){
                    $(span).text("arrow_drop_up")
                } else {
                    $(span).text("arrow_drop_down")
                }
            });

        });


        /** Creacion de categorias y productos **/
        function addCategory(element, store_id) {
            // Si aun no esta habilitado el input se crea
            if ($('#newCategory').length === 0) {

                $('<div class="d-flex align-items-center mt-2">'+
                    '<input type="text" id="newCategory" class="new-input">'+
                    '<button type="button" class="closeOutBtn pull-right border-0" onclick="removeInput(`newCategory`)" title="Eliminar campo">'+
                    '<span class="material-icons" style="font-size: 18px">close</span></button>' +
                '</div>').insertBefore($(element));

                // Carga la categoria al ingresar intro
                $('#newCategory').on('keyup', function (event) {
                    if (event.keyCode === 13) {

                        event.preventDefault();

                        $.ajax({
                            url: "categories/products",
                            method: 'POST',
                            data: {
                                name: $(this).val(),
                                store_id: store_id
                            },
                            success: function (result) {
                                $('#newCategory').parent().remove();

                                insertIn(result.category, 'newCategory');
                            },
                            error: function (result) {
                                Toast.fire({
                                    icon: 'error',
                                    html: '&nbsp;&nbsp;' + result.responseJSON.message
                                })
                            }
                        });
                    }
                });
            }
        }

        function addSubCategory(element, category_id) {
            if ($('#newSubCategory').length === 0) {

                $('<div class="d-flex align-items-center mt-2">'+
                    '<input type="text" id="newSubCategory" class="new-input sub">'+
                    '<button type="button" class="closeOutBtn pull-right border-0" onclick="removeInput(`newSubCategory`)" title="Eliminar campo">'+
                    '<span class="material-icons" style="font-size: 18px">close</span></button>' +
                    '</div>').insertBefore($(element));


                // Carga la sub categoria al ingresar intro
                $('#newSubCategory').on('keyup', function (event) {
                    if (event.keyCode === 13) {

                        event.preventDefault();

                        $.ajax({
                            url: "categories/products/sub/" + category_id,
                            method: 'POST',
                            data: {
                                name: $(this).val(),
                                category_id: category_id
                            },
                            success: function (result) {
                                $('#newSubCategory').parent().remove();

                                insertIn(result.category, 'newSubCategory');
                            },
                            error: function (result) {
                                Toast.fire({
                                    icon: 'error',
                                    html: '&nbsp;&nbsp;' + result.responseJSON.message
                                })
                            }
                        });
                    }
                });
            }
        }

        /** Cambio de visibilidad con hover en botones ancor **/
        function mouseOver(element){
            $(element).children('a').css('visibility', 'visible')
        }
        function mouseOut(element){
            $(element).children('a').css('visibility', 'hidden')
        }


        /** Funcion para insertar los nuevos elementos **/
        function insertIn (data, type){
            if (type === 'newCategory'){

                $('.categoriesContainer').prepend(
                    '<div class="d-flex justify-content-center align-items-start dropdown mx-0" id="' + data.id + '" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">'+
                        '<div class="w-100 mx-0 px-0">' +
                            '<div class="cat-header w-100 d-flex align-items-start" id="dropdownMenuButton" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">' +
                                '<span class="material-icons arrow-drop">arrow_drop_down</span>' +
                                '<p style="width: 100%; font-size: 14px;">' + data.name + '</p>' +
                            '</div>'+
                            '<div class="dropdown-content w-100" style="display: none;">' +
                                '<a type="button" class="createSubCategory" style="font-size: 14px; margin-left: 2rem; ' +
                                'margin-bottom: 0.5rem; color: #FF7334" onClick="addSubCategory(this, '+ data.id + ')">' +
                                'Añadir sub-categoría' +
                                '</a>' +
                            '</div>' +
                        '</div>' +
                        '<a type="button" id="deleteCategory" class="closeOutBtn pull-right border-0" title="Eliminar categoria" ' +
                        'data-toggle="modal" data-target="#deleteModal" data-type="deleteCategory" data-id="' + data.id + '" data-name="' + data.name + '"' +
                        'style="top: 3px;right: 0;position: absolute; visibility: hidden"><span class="material-icons" style="font-size: 18px">close</span>' +
                        '</a>'+
                    '</div>');
            }

            if (type === 'newSubCategory'){
                $('div#' + data.category_id +' div.dropdown-content')
                    .prepend(
                        '<div class="d-flex align-items-center" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">' +

                            '<a type="button" id="deleteSubCategory" class="closeOutBtn pull-right border-0" title="Eliminar sub-categoria" ' +
                            'data-toggle="modal" data-target="#deleteModal" data-type="deleteSubCategory" data-id="' + data.id + '" data-name="' + data.name + '"' +
                            'style="position: absolute; visibility: hidden">' +
                            '<span class="material-icons" style="font-size: 18px">close</span>' +
                            '</a>' +

                            '<ul class="sub-ul m-0" id="' + data.id + '" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">' +
                            '<li class="sub-category" onclick="fillProducts(' + data.id + '); openProductPanel();">' +
                            '<span class="count">' + data.products_count + '</span><label>' + data.name + '</label>' +
                            '</li>' +
                            '<a type="button" id="createProduct" class="btn-add-product" onclick="resetProductForm();openProductForm('+ data.id +');">Añadir producto</a>' +
                            '</ul>'+
                        '</div>'
                );

                /** Manejo de estado de ul's **/
                $('.sub-ul').on('click', function (){
                    let ul = $(this);

                    if (ul.hasClass('product-active') === false){
                        ul.addClass('product-active');

                        resetProductForm()
                    }

                    $('.sub-ul').not(ul).removeClass('product-active')
                })
            }
        }


        /** Funcion para remover inputs **/
        function removeInput(id){
            $('#' + id).parent().remove();
        }

        /** Manejo de productos **/
        $('#productStoreForm').on('submit', function (e){
            e.preventDefault();

            let formData = new FormData(this)

            var form = $('#productStoreForm');
            var url = form.attr('action');

            let category_id = form.find('#category_id').val();

            let store_url = $('#modalStoreForm').attr('action');
            let store_id = store_url.substring(store_url.lastIndexOf('/') + 1);

            formData.append('category_id', category_id)
            formData.append('store_id', store_id)

            let method = form.find('_method').val();
            method = method === undefined ? 'POST' : method;

            $.ajax({
                url: url,
                method: method,
                data: formData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function (result) {
                    Toast.fire({
                        icon: 'success',
                        html: '&nbsp;&nbsp;' + result.message
                    })

                    resetProductForm();

                    fillProducts(result.product.category_id)
                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.responseJSON.message
                    })
                }
            });

        })

        // Cargar productos por subcategoria
        function fillProducts(subCategory){

            $.ajax({
                url: "products/bySubCategory/" + subCategory,
                method: 'GET',
                success: function (result) {

                    let container = $('#productsContainer');
                    if (result.products.length > 0){

                        container.removeClass('product-right-panel').addClass('product-panel-filled').empty()

                        $.each(result.products, function(k, v){

                            let img = v.img !== '' ? "{{ asset('/storage/stores') }}/" + v.store_id + "/products/" + v.img : "{{ asset('/storage/noimage.jpg') }}";

                            let price = v.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                            container.append(
                                '<div class="product-item d-flex" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)" ' +
                                'onclick="openProductForm('+ v.category_id +');editProduct('+v.id+', this);">' +
                                    '<div class="d-flex align-items-center w-100" style="margin-left: 1rem">' +
                                        '<img src="' + img + '" class="product-img"/>' +
                                        '<div class="d-flex flex-column ml-3" style="width: 90%">' +
                                            '<label class="body-1 mb-0" id="title">' + v.name + '</label>' +
                                            '<label class="label-text-form mb-0" id="price">$' + price + '</label>' +
                                        '</div>' +
                                    '</div>' +
                                    '<a type="button" id="deleteProduct" class="closeOutBtn pull-right border-0" title="Eliminar producto" ' +
                                    'data-toggle="modal" data-target="#deleteModal" data-type="deleteProduct" data-id="' + v.id + '" data-name="' + v.name + '"' +
                                    'style="top: 0; right: 0; position: absolute;visibility: hidden">' +
                                    '<span class="material-icons" style="font-size: 18px">close</span>' +
                                    '</a>' +
                                '</div>'
                            )
                        })

                        $('ul#' + subCategory + ' span.count').text(result.products.length)

                    } else {
                        container.addClass('product-right-panel').removeClass('product-panel-filled').empty()
                        container.append(
                            '<div style="max-width: 220px; text-align: center; transform: translateZ(50px)">' +
                                '<span class="material-icons" style="font-size: 70px; color: #E5E5E5">chrome_reader_mode</span>' +
                                '<p style="color: #979797; font-size: 16px; text-align: center; width: 170px">' +
                                    'No se encontraron productos para esta sub categoria' +
                                '</p>' +
                            '</div>'
                        )
                    }
                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.responseJSON.message
                    })

                    return null;
                }
            });
        }

        // Carga del form para editar un producto
        function editProduct(product, button){
            let element = $(button);
            element.addClass('e-active')
            $('.product-item').not(element).removeClass('e-active')

            let container = $('#newGroup')
            container.css('display', 'block')

            let url = '{{ route("products.show", ":id") }}';
            url = url.replace(':id', product);

            $.ajax({
                url: url,
                method: 'GET',
                success: function (result) {

                    let form = container.find('#productStoreForm')
                    let product = result.product;
                    let url = '{{ route("products.update", ":id") }}';
                    url = url.replace(':id', product.id);

                    let title = container.find('.label-primary-form')
                    if (title.text() !== 'Editar producto')
                        title.text('Editar producto')

                    let btn = container.find('#createProduct')
                    if (btn.text() !== 'Actualizar producto')
                        btn.text('Actualizar producto')

                    if (form.find('input[name="_method"]').length === 0){
                        form.prepend('<input type="hidden" name="_method" value="patch">');
                    }

                    form.attr('action', url)
                    form.find('#name').val(product.name)
                    form.find('#cost').val(product.cost)
                    form.find('#price').val(product.price)
                    form.find('#description').val(product.description)

                    form.find('#img-span').remove()

                    let route = '{{ asset('storage/stores/') }}' + '/' + product.store_id + '/products/' + product.img
                    if (product.img === "" || product.img === undefined)
                        route = "{{ asset('storage/noimage.jpg') }}"

                    $('<img id="img-span" class="mx-4" src="' + route + '" style="width: 64px; height: 64px; border-radius: 50%;' +
                        ' display: flex; align-items: center;justify-content: center;">').insertAfter('#img')

                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.message
                    })
                }
            });
        }

        // Eliminar un producto
        $('#deleteModal').on('show.bs.modal', function(e){
            let button = $(e.relatedTarget);
            let form = $(this).find('#deleteForm');

            let id = button.data('id');
            let name = button.data('name');
            let type = button.data('type');

            // Eliminar producto
            if (type === "deleteProduct"){

                let url = '{{ route("products.destroy", ":id") }}';
                url = url.replace(':id', id);

                $(this).find('.modal-title').text("Eliminar producto");
                form.find('#message').text("Esta seguro de que desea eliminar el producto `" + name + "`?");

                $('#deleteForm').on('submit', function (e){
                    e.preventDefault()

                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function (result) {

                            Toast.fire({
                                icon: 'success',
                                html: '&nbsp;&nbsp;' + result.message
                            })

                            $('#deleteModal').hide()

                            fillProducts(result.category.id)

                            $('ul#' + result.category.id + ' span.count').text(result.category.products_count)

                            resetProductForm()

                            $('#newGroup').css('display', 'none')
                        },
                        error: function (result) {
                            Toast.fire({
                                icon: 'error',
                                html: '&nbsp;&nbsp;' + result.message
                            })
                        }
                    });

                })
            }

            // Eliminar categoria de producto
            if (type === "deleteCategory"){
                let url = '{{ route("categories.products.destroy", ":id") }}';
                url = url.replace(':id', id);

                $(this).find('.modal-title').text("Eliminar categoria");
                form.find('#message').text("Esta seguro de que desea eliminar la categoria `" + name + "`?");

                $('#deleteForm').on('submit', function (e){
                    e.preventDefault()

                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function (result) {

                            Toast.fire({
                                icon: 'success',
                                html: '&nbsp;&nbsp;' + result.message
                            })

                            button.parent().remove()

                            $('#deleteModal').modal('hide')

                            resetProductForm()

                            $('#newGroup').css('display', 'none')
                        },
                        error: function (result) {
                            Toast.fire({
                                icon: 'error',
                                html: '&nbsp;&nbsp;' + result.message
                            })
                        }
                    });

                })
            }

            // Eliminar sub categorias de producto
            if (type === "deleteSubCategory"){
                let url = '{{ route("sub.categories.destroy", ":id") }}';
                url = url.replace(':id', id);

                $(this).find('.modal-title').text("Eliminar sub-categoria");
                form.find('#message').text("Esta seguro de que desea eliminar la sub-categoria `" + name + "`?");

                $('#deleteForm').on('submit', function (e){
                    e.preventDefault()

                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function (result) {

                            Toast.fire({
                                icon: 'success',
                                html: '&nbsp;&nbsp;' + result.message
                            })

                            button.parent().remove()

                            $('#deleteModal').modal('hide')

                            button.parent().remove()

                            resetProductForm()

                            $('#newGroup').css('display', 'none')
                        },
                        error: function (result) {
                            Toast.fire({
                                icon: 'error',
                                html: '&nbsp;&nbsp;' + result.message
                            })
                        }
                    });

                })
            }
        })

        /** Detalles de negocio **/
        function getStoreData(button) {

            let element = $(button);
            if (element.hasClass('e-active') === false)
                element.addClass('e-active')

            $('.item-list').not(element).removeClass('e-active')

            @permission('stores.store')
            let storeId = $(button).val();

            $.ajax({
                url: "{{ url('/stores') }}/" + storeId,
                method: 'get',
                success: function (result) {

                    $('#right-panel-empty').css('display', 'none');
                    $('#right-panel').css('display', 'initial');

                    if (result.store.cover !== "") {
                        $('#storeCover').attr('src', "{{ asset('/storage/stores') }}/" + result.store.id + "/" + result.store.cover);
                    } else {
                        $('#storeCover').attr('src', "");
                    }


                    $('.cover-title').text(result.store.long_name);
                    $('#storeDescription').text(result.store.description);

                    $('#productsLbl').text(result.details.products);
                    $('#totalLbl').text(result.details.total);
                    $('#deliveredLbl').text(result.details.delivered);
                    $('#cancelledLbl').text(result.details.cancelled);

                    /** Manejo de rates **/
                    $('#rateValues').empty()
                    $('#rateValues').append('<h3 class="md-36" style="font-weight: bold">' + result.store.rate_avg + '</h3><h6>&nbsp;/ 5</h6>');

                    let stars = $('#rateCointainer').children();

                    $.each(stars, function (k, v) {

                        let decimals = (k + 1) - result.store.rate_avg;

                        if (k + 1 <= result.store.rate_avg) {
                            $(v).text('star');
                        } else if ((result.store.rate_avg % 1) >= 0.5 && decimals < 1) {
                            $(v).text('star_half');

                        } else if (k + 1 > result.store.rate_avg) {
                            $(v).text('star_border');
                        }
                    });

                    /** Edicion de negocio **/
                    let storeModal = $('#exampleModal #modalStoreForm');
                    $('#editStore').on('click', function () {

                        resetHeaders();
                        resetProducts();

                        $('#product').css('display', 'initial');

                        if (storeModal.find('input[name="_method"]').length === 0) {
                            storeModal.prepend('<input type="hidden" name="_method" value="patch">');
                        }

                        storeModal.find('.modal-title').val('Editar negocio');
                        storeModal.show();

                        let store = result.store;
                        storeModal.find('#long_name').val(store.long_name)
                        storeModal.find('#short_name').val(store.short_name)
                        storeModal.find('#description').val(store.description)
                        storeModal.find('#address').val(store.address)
                        storeModal.find('#phone').val(store.phone)
                        storeModal.find('#mobile').val(store.mobile)
                        storeModal.find('#email').val(store.email)

                        // Logo
                        storeModal.find('#logo-span').remove();

                        if (store.logo !== "" && store.logo !== null){
                            let logoRoute = "{{ asset("storage/stores") }}/" + store.id + "/" + store.logo;

                            $('<img id="logo-span" class="mx-4" src="' + logoRoute + '" ' +
                                'style="width: 64px; height: 64px; border-radius: 50%;' +
                                'font-size: 28px; display: flex;align-items: center;justify-content: center; color: white"></span>').insertAfter('#logo');
                        } else {
                            $('<span id="logo-span" class="material-icons mx-4"'+
                            'style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;'+
                            'align-items: center;justify-content: center; color: white">'+
                            'camera</span>').insertAfter('#logo');
                        }


                        // Cover
                        storeModal.find('#cover-span').remove();
                        if (store.cover !== "" && store.cover !== null) {
                            $('<img id="cover-span" class="mx-4" src="{{ asset("storage/stores") }}/' + store.id + "/" + store.cover + '"' +
                                'style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%;' +
                                'font-size: 28px; display: flex;align-items: center;justify-content: center; color: white"></span>').insertAfter('#cover');
                        } else {
                            $('<span id="cover-span" class="material-icons mx-4"' +
                                'style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;' +
                                'align-items: center;justify-content: center; color: white">' +
                                'camera</span>').insertAfter('#cover');
                        }

                        // initialize the selectize control's
                        let categoriesId = [];
                        $.each(store.categories, function (key, item) {
                            categoriesId.push(this.id);
                        });
                        var $select = $('#categories').selectize();
                        $select[0].selectize.setValue(categoriesId);

                        var $select = $('#department_id').selectize();
                        $select[0].selectize.setValue(store.department_id);

                        var $select = $('#municipality_id').selectize();
                        $select[0].selectize.setValue(store.municipality_id);

                        var $select = $('#zone_id').selectize();
                        $select[0].selectize.setValue(store.zone_id);


                        /** Listado de categorias de productos **/
                        $('.categoriesContainer').empty();
                        $.each(result.store.product_categories, function(k, v){

                            // Carga de categorias de productos
                            insertIn(v, 'newCategory')

                            // Carga de subcategorias
                            $.ajax({
                                url: "{{ url('/categories/products/sub') }}/" + v.id,
                                method: 'get',
                                success: function (result) {

                                    let subCategories = result.category;
                                    if (subCategories.length > 0){

                                        $.each(subCategories, function(index, sub){
                                            insertIn(sub, 'newSubCategory');
                                        });
                                    }
                                }
                            });
                        });

                        // Se agrega el boton final de agregar categorias de productos
                        $('.categoriesContainer').append(
                            '<a type="button" class="createCategory" style="font-size: 14px; margin-left: 1rem; color: #FF7334" onClick="addCategory(this, '+ result.store.id + ')">'+
                            'Añadir categoría</a>'
                        );


                        /** Actualizacion de url **/
                        let url = '{{ route("stores.update", ":id") }}';
                        url = url.replace(':id', store.id);
                        storeModal.attr('action', url);

                    })

                },
                error: function (result) {
                    Toast.fire({
                        icon: 'error',
                        html: '&nbsp;&nbsp;' + result.responseJSON.message
                    })
                }
            });
        @endpermission
        }

    </script>
@append
