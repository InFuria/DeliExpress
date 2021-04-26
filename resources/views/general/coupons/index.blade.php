@extends('general.layouts.app')

@section('title', 'Cupones')

@section('styles')
    <style>
        div.selectize-input.items.required.invalid.not-full.has-options, div.selectize-input.items.required.has-options.full.has-items,
        div.selectize-input.items.not-full.has-options, div.selectize-input.items.not-full.has-options.has-items,
        div.selectize-input.items.required.invalid.not-full, div.selectize-input.items.has-options.full.has-items {
            padding: 0 !important;
        }

        div.selectize-input > input {
            font-size: 12px !important;
        }

        div.selectize-control{
            margin-top: -4px !important;
        }

        .selectize-control.multi .selectize-input > div, .selectize-input span {
            background-color: white;
            color: #FF7334 !important;
        }

        .item {
            display: inline-flex;
            align-items: center;
            background-color: white !important;
        }

        .item a {
            top: auto !important;
            bottom: auto !important;
            background-color: white !important;
        }



        .datepicker {
            z-index: 1600 !important; /* has to be larger than 1050 */
        }


        td.today.day{
            background-color: #FFB600 !important;
            color: white !important;
        }

        td.day{
            color: #393E41 !important;
        }

        .datepicker table tr td.active{
            background-color: #FF7334 !important;
            color: white !important;
        }

        th.dow{
            color: #979797 !important;
            text-transform: capitalize !important;
        }

        th.today{
            display: table-cell !important;
        }

        .datepicker thead tr .next, .datepicker thead tr .prev {
            font-size: 13px !important;
            content: '';
            color: #979797 !important;
        }

        .datepicker thead tr .next:hover, .datepicker thead tr .prev:hover, .datepicker-switch:hover, td.day:hover {
            background-color: rgba(253, 79, 0, 0.1) !important;
        }

        .datepicker-switch{
            color: #393E41 !important;
        }

        .datepicker-days, .table-condensed{
            width: 300px !important;
        }

    </style>
@endsection

@section('main')

    <div style="display: flex">
        {{ Breadcrumbs::render('coupons-end') }}

        @permission('coupons.store')
            <a type="button" id="createCoupon" data-toggle="modal" data-target="#exampleModal"
               class="content container-fluid text-active bg-orange-main rounded shadow-primary border-0 px-0 ml-3 text-active"
               style="max-width: 15%; right: 0;position:relative; height:100%;">
                CREAR CUPON
            </a>
        @else
            <a type="button" id="createCoupon" style="max-width: 15%; right: 0;position:relative; height:100%;"
               class="content container-fluid btn-e-disabled rounded border-0 px-0 ml-3"
               title="No tiene permisos para esta accion">
                CREAR CUPON
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
                           placeholder="Código de cupón"
                           style="height: 35px !important; padding: 0" required>
                </div>
            </div>

            <div>
                <label class="label-primary">Recientes</label>
                <div style="margin-top: 1rem" id="recent">
                    @foreach($coupons->slice(0, 6) as $coupon)
                        <button id="couponBtn" class="item-list d-flex align-items-center border-0 bg-white rounded"
                                style="width: 100%; height: 80px; cursor: pointer" value="{{ $coupon->id }}"
                                onclick="getCouponData(this)">

                            <span id="logo-span" class="material-icons material-icons ml-1 mr-3"
                            style="background: #FF7334; width: 40px; height: 40px; border-radius: 50%; font-size: 20px; display: flex;
                            align-items: center;justify-content: center; color: white">
                            sell
                            </span>

                            <div class="d-flex flex-column" style="justify-content: center;">
                                <label id="nameLbl" class="label-text-form"
                                       style="color: black; font-size: 16px; letter-spacing: 0.05rem; margin-bottom: 4px !important;  border: 0; cursor: pointer">
                                    {{ $coupon->code }}
                                </label>
                                <label class="label-text-form searchBottomLbl"
                                       style="font-size: 14px; line-height: 18px;margin-bottom: 0 !important; border: 0; cursor: pointer">{{ $coupon->discount }}% de descuento</label>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        @permission('coupons.show')
            <div id="right-panel" class="border rounded right-panel-content active-panel" style="display: none; padding-bottom: 20px; height: 70%">
                @include('general.coupons._show')
            </div>

            <div id="right-panel-empty" class="rounded right-panel-empty inactive-panel">
                <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
                    <span class="material-icons" style="font-size: 70px; color: #E5E5E5">chrome_reader_mode</span>
                    <label style="color: #979797; font-size: 16px; text-align: center; width: 170px">
                        Selecciona un cupón para ver mas detalles
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

    @permission('coupons.status')
    @include('general.coupons.partials._status')
    @endpermission

    @permission('coupons.store')
    @include('general.coupons._modal', ['stores' => $stores])
    @endpermission

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            /** Selects **/
            $(function () {
                $('#stores').selectize({
                    plugins: ['remove_button'],
                    maxItems: null,
                    persist: false,
                    valueField: 'id',
                    labelField: 'short_name',
                    searchField: ['short_name'],
                    create: false,
                    options: {!! json_encode($stores) !!},
                    sortField: {
                        field: 'short_name',
                        direction: 'asc'
                    }
                });

            });

            $('#exampleModal').on('shown.bs.modal', function() {
                $('#expired_date').datepicker({
                    format: "dd/mm/yyyy",
                    weekStart: 1,
                    maxViewMode: 2,
                    todayBtn: "linked",
                    clearBtn: true,
                    autoclose: true,
                    language: "es",
                    orientation: "bottom left",
                    multidate: false,
                    keyboardNavigation: false,
                    todayHighlight: true,
                    startDate: '-0d'
                });
            });

            /** Reset del formulario **/
            $('#exampleModal').on('hidden.bs.modal', function (){
                $(this).find('#modalCouponForm').trigger('reset')
            })

            /** Busqueda de cupones **/
            $('#search').keyup(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ url('coupons') }}",
                    method: 'get',
                    data: {
                        search: $('#search').val()
                    },
                    success: function (result) {

                        let recent = $('#recent');

                        recent.empty();

                        if (result.coupons.length > 0) {

                            $.each(result.coupons.slice(0,6), function (key, value) {

                                recent.append(
                                    '<button id="couponBtn" class="item-list d-flex align-items-center border-0 bg-white rounded"'+
                                    'style="width: 100%; height: 80px; cursor: pointer" value="'+ value.id +'" onclick="getCouponData(this)">'+
                                    '<span id="logo-span" class="material-icons material-icons ml-1 mr-3"'+
                                    'style="background: #FF7334; width: 40px; height: 40px; border-radius: 50%; font-size: 20px; display: flex;'+
                                    'align-items: center;justify-content: center; color: white">'+
                                    'sell'+
                                    '</span>'+
                                    '<div class="d-flex flex-column" style="justify-content: center;">'+
                                        '<label id="nameLbl" class="label-text-form" style="color: black; font-size: 16px; letter-spacing: 0.05rem; margin-bottom: 4px !important;  border: 0; cursor: pointer">'+
                                            value.code +
                                        '</label>'+
                                        '<label class="label-text-form searchBottomLbl" style="font-size: 14px; line-height: 18px;margin-bottom: 0 !important; border: 0; cursor: pointer"'+
                                               value.discount + '% de descuento</label>' +
                                    '</div>' +
                                    '</button>'
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


        function updateStatusButton(status){
            let statusBtn = $('#statusCoupon');

            if (status === 1 || status === true) {
                statusBtn.removeClass('btn-out-primary').addClass('btn-out-disabled').text('Deshabilitar cupón')
            } else {
                statusBtn.removeClass('btn-out-disabled').addClass('btn-out-primary').text('Habilitar cupón')
            }
        }


        /** Detalles de cupon **/
        function getCouponData(button) {

            let element = $(button);
            if (element.hasClass('e-active') === false)
                element.addClass('e-active')

            $('.item-list').not(element).removeClass('e-active')

            @permission('coupons.show')
                let couponId = $(button).val();

                $.ajax({
                    url: "{{ url('/coupons') }}/" + couponId,
                    method: 'get',
                    success: function (result) {

                        $('#right-panel-empty').css('display', 'none');
                        $('#right-panel').css('display', 'initial');

                        updateStatusButton(result.coupon.status)

                        let couponCointainer = $('#couponDetails');
                        couponCointainer.find('#aplications').text(result.aplications)
                        couponCointainer.find('#days_past').text(result.days_past + ' días')
                        couponCointainer.find('#remaining').text(result.remaining + ' días')




                        $('#statusCoupon').on('click', function (){
                            let statusModal = $('#statusModal');
                            let couponForm = statusModal.find('#statusForm');
                            let action = $('#btnAction');

                            let url = '{{ route("coupons.status", ":id") }}';
                            url = url.replace(':id', result.coupon.id);
                            couponForm.attr('action', url);

                            let status = result.coupon.status === 1 || result.coupon.status === true ? "deshabilitar" : "habilitar";
                            action.text(status.toUpperCase())
                            couponForm.find('#message').text("Esta seguro que desea " + status + " el cupon seleccionado?")

                            statusModal.modal('show')
                        })


                        @permission('coupons.update')
                            $('#editCoupon').on('click', function (){
                                loadCouponForm(result)
                            })

                            @else
                            Toast.fire({
                                icon: 'error',
                                html: '&nbsp;&nbsp;' + "No posee permisos para ver el detalle de cupones"
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
                    html: '&nbsp;&nbsp;' + "No posee permisos para ver el detalle de cupones"
                })
            @endpermission
        }

        /** Edicion de cupon **/
        function loadCouponForm(result){
            let couponForm = $('#modalCouponForm');
            let couponModal = $('#exampleModal');
            let coupon = result.coupon;

            if (couponForm.find('input[name="_method"]').length === 0){
                couponForm.prepend('<input type="hidden" name="_method" value="patch">');
            }

            couponModal.find('.modal-title').val('Editar cupón');

            couponForm.find('#code').val(coupon.code)
            couponForm.find('#discount').val(coupon.discount)
            couponForm.find('#expired_date').val(coupon.expired_date)

            let storesId = [];
            var $select = $('#stores').selectize();
            $.each(coupon.stores, function (key, item) {
                storesId.push(this.id);
            });
            $select[0].selectize.setValue(storesId);


            let url = '{{ route("coupons.update", ":id") }}';
            url = url.replace(':id', coupon.id);
            couponForm.attr('action', url);

            couponModal.modal('show');
        }
    </script>
@append
