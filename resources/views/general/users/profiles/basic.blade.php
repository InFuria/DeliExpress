@extends('general.layouts.app')

@section('title', 'Perfil de Usuario')

@section('styles')
    <style>
        .selectize-dropdown-content div:hover {
            background-color: #FF7334;
            color: white;
        }

        .selectize-control.multi .selectize-input > div, .selectize-input span, .selectize-control.single .selectize-input > div {
            font-family: 'Mulish';
            border: 1px solid #FF7334;
            border-radius: 4px;

            padding: 2px 6px;

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
        {{ Breadcrumbs::render('profile-end') }}
    </div>

    <main class="container bg-white shadow-e-sm border-0 mt-3 ml-3"
          style="height: auto; max-height: 100%; max-width: 98%; width: 98% !important; margin-bottom: 15px; display: inline-flex">
        @include('sweetalert::alert')

        <div class="ml-4 mr-3" style="margin-left: 2.5rem !important; margin-top: 1.50rem !important; height: 93%; width: 100%;max-width: 100%;
        display: inline-block;vertical-align: top">

            <form id="userForm" method="post" action="{{ route('users.update', ['user' => $user->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div style="display: inline-flex; width: 100%">
                    <div class="mt-4" id="generalGroup" style="width: 48%;margin-right: 2%">
                        <label class="label-primary">Detalles generales</label>

                        <div class="form-group" style="margin-top: 2rem;">
                            <label class="label-primary-form" for="photo">Fotografia</label>
                            <div class="d-flex align-items-center border rounded shadow-e-sm" style="width: 264px; height: 92px;">

                                <input type="file" class="d-block border-danger" id="photo" name="photo" alt="" style="position:absolute; height:92px; width: 264px; opacity: 0">

                                @if($user->photo != "")
                                    <img id="img-span" alt="" class="mx-4" src="{{ asset('storage/users/' . $user->photo) }}"
                                         style="width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center;justify-content: center;">
                                @else
                                    <img id="img-span" alt="" class="mx-4" src="{{ asset('storage/noimage.jpg') }}"
                                         style="width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center;justify-content: center;">
                                @endif

                                <div class="d-flex flex-column mt-1">
                                    <label class="label-text-form">Subir imagen</label>
                                    <label class="label-text-form" style="font-size: 11px; line-height: 18px;">JPG - JPEG - PNG</label>
                                </div>

                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 2rem;">
                            <div style="display: flex; flex-wrap: wrap;">
                                <div style="width: 47%; height: 67px;">
                                    <label class="label-primary-form" for="name">Nombre</label>
                                    <input type="text" class="form-control rounded-0 input-out" id="name" name="name" value="{{ $user->name }}" placeholder="Nombre completo" required>
                                </div>

                                <div style="width: 47%; height: 67px; margin-left: 6%">
                                    <label class="label-primary-form" for="username">Usuario</label>
                                    <input type="text" class="form-control rounded-0 input-out" id="username" name="username" value="{{ $user->username }}" placeholder="Nombre de usuario" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 2rem;">
                            <div style="display: flex; flex-wrap: wrap;">
                                <div style="width: 47%; height: 67px;">
                                    <label class="label-primary-form" for="phone">Telefono</label>
                                    <input type="text" class="form-control rounded-0 input-out" id="phone" name="phone" value="{{ $user->phone }}" placeholder="Telefono" required>
                                </div>

                                <div style="width: 47%; height: 67px; margin-left: 6%">
                                    <label class="label-primary-form" for="email">E-mail</label>
                                    <input type="text" class="form-control rounded-0 input-out" id="email" name="email" value="{{ $user->email }}" placeholder="E-mail" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 border-left-grey pl-5" id="securityGroup" style="width: 45%;margin-left: 5%">
                        <label class="label-primary">Seguridad</label>

                        <div class="form-group role-container" style="margin-top: 2rem;">
                            <label class="label-primary-form" for="role">Rol</label>
                            <br>
                            <input class="label-out-light" id="role" name="role" value="{{ $user->role->name }}" readonly>
                        </div>

                        <div class="form-group" style="margin-top: 2rem; height: 55%; overflow-y: scroll;overflow-x: hidden;">
                            <label class="label-primary-form" for="permissions">Permisos extra</label>
                            <br>
                            <div style="display: inline-flex;" id="permissionsSpn">
                                @foreach($user->permissions as $item)
                                    <label class="label-out-light mr-2">{{ $item->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer" style="border-top: #979797;">
                    <button type="submit" class="btn-out-compl btn-out-extra border-0 bg-blues text-white">Actualizar general</button>
                </div>
            </form>

            @anyRole(['delivery'])
                @include('general.users.profiles.delivery')
            @endanyRole

            @anyRole(['store'])
                @include('general.users.profiles.store')
            @endanyRole
        </div>
    </main>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            /** Selects **/
            $(function () {

                /** Delivery **/
                $('#enabled').selectize({
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: [{name: 'Habilitado',id: 1},{name: 'No Habilitado',id: 2}]
                });

                $('#available').selectize({
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: [{name: 'Disponible',id: 1},{name: 'Ocupado',id: 2}]
                });


                /** Stores **/
                $('#category').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: [{name: 'Comida Mexicana',id: 1},{name: 'Farmacia',id: 2}]{{--{!! json_encode($categories) !!}--}}
                });

                $('#department').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: [{name: 'Central',id: 1},{name: 'Alto Parana',id: 2}]{{--{!! json_encode($departments) !!}--}},
                });

                $('#municipality').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: [{name: 'Municipio 1',id: 1},{name: 'Municipio 2',id: 2}]{{--{!! json_encode($municipalities) !!}--}},
                });

                $('#zone').selectize({
                    plugins: ['remove_button'],
                    persist: false,
                    valueField: 'id',
                    labelField: 'name',
                    searchField: ['name'],
                    create: false,
                    options: [{name: 'Santa Ana',id: 1},{name: 'Centro',id: 2}]{{--{!! json_encode($zones) !!}--}},
                });
            });
        })
    </script>
@append
