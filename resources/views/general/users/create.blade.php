<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="margin-top: 5.6%">
    <div class="modal-dialog" role="document" style="max-width: 35%;">
        <div class="modal-content rounded">
            <div class="modal-header bg-orange-main d-flex justify-content-center" style="height: 64px;max-height: 64px;">
                <h6 class="modal-title card-title" id="modalLabel" style="height: 100%">Nuevo usuario</h6>
            </div>
            <div class="modal-body" id="header">
                <div class="d-flex align-items-stretch bg-white border-0 shadow-md rounded" style="height: 70px">
                    <button class="bg-white btn-header header-active rounded-0" id="general">
                        <span class="material-icons d-block mb-2">person_outline</span>
                        GENERALES
                    </button>
                    <button class="bg-white btn-header header-inactive rounded-0" id="security">
                        <span class="material-icons d-block mb-2">lock</span>
                        SEGURIDAD
                    </button>
                </div>

                <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4" id="generalGroup">
                        <div class="form-group" style="margin-top: 2rem;">
                                <label class="label-primary-form" for="photo">Fotografia</label>
                            <div class="d-flex align-items-center border rounded shadow-sm" style="width: 264px; height: 92px;">

                                <input type="file" class="d-block border-danger" id="photo" name="photo" alt="" style="position:absolute; height:92px; width: 264px; opacity: 0">

                                <span id="img-span" class="material-icons material-icons mx-4"
                                      style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;
                                      align-items: center;justify-content: center; color: white">
                                    cloud_upload
                                </span>

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
                                    <input type="text" class="form-control rounded-0 input-out" id="name" name="name" placeholder="Nombre completo" required>
                                </div>

                                <div style="width: 47%; height: 67px; margin-left: 6%">
                                    <label class="label-primary-form" for="username">Usuario</label>
                                    <input type="text" class="form-control rounded-0 input-out" id="username" name="username" placeholder="Nombre de usuario" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 2rem;">
                            <div style="display: flex; flex-wrap: wrap;">
                                <div style="width: 47%; height: 67px;">
                                    <label class="label-primary-form" for="phone">Telefono</label>
                                    <input type="text" class="form-control rounded-0 input-out" id="phone" name="phone" placeholder="Telefono" required>
                                </div>

                                <div style="width: 47%; height: 67px; margin-left: 6%">
                                    <label class="label-primary-form" for="email">E-mail</label>
                                    <input type="text" class="form-control rounded-0 input-out" id="email" name="email" placeholder="E-mail" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4" id="securityGroup" style="display:none">

                        <div class="form-group" style="margin-top: 2rem;">
                            <label class="label-primary-form" for="roles">Roles</label>
                            <div style="width: 70%; height: 67px;">
                                <select id="roles" name="roles[]" multiple="multiple" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 2rem;">
                            <label class="label-primary-form" for="permissions">Permisos</label>
                            <div style="width: 70%; height: 67px;">
                                <select id="permissions" name="permissions[]" multiple="multiple">
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" style="border-top: #979797;">
                        <button type="button" class="btn-out-disabled" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn-out-primary" id="previous" hidden>Regresar</button>
                        <button type="button" class="btn-out-primary" id="continue">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
