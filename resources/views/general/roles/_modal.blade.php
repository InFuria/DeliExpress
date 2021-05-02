<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;" role="document">
        <div class="modal-content rounded">
            <div class="modal-header bg-orange-main d-flex justify-content-center"
                 style="height: 64px;max-height: 64px;">
                <h6 class="modal-title card-title" id="modalLabel" style="height: 100%">
                    Nuevo Rol
                </h6>
            </div>
            <div class="modal-body">
                <form id="roleForm" method="post" action="{{ route('roles.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group" style="margin-top: 1rem;">
                        <div style="display: flex; flex-wrap: wrap;">
                            <div style="width: 47%; height: 67px;">
                                <label class="label-primary-form" for="name">Nombre</label>
                                <input type="text" class="form-control rounded-0 input-out" id="name" name="name"
                                       placeholder="Nombre descriptivo" required>
                            </div>

                            <div style="width: 47%; height: 67px; margin-left: 6%">
                                <label class="label-primary-form" for="username">Identificador</label>
                                <input type="text" class="form-control rounded-0 input-out" id="slug" name="slug"
                                       placeholder="Identificador del rol. Ej: admin, store, etc" required>
                            </div>
                        </div>
                    </div>


                    <div class="form-group" style="margin-top: 2rem;">
                        <label class="label-primary-form" for="permissions">Permisos</label>
                        <div style="width: 100%; min-height: 67px;">
                            <select id="permissions" name="permissions[]" multiple="multiple">
                            </select>
                        </div>
                    </div>

                </form>

                <div class="modal-footer" style="border-top: #979797; margin-top: 1rem;">
                    <button type="button" class="btn-out-disabled" id="cancel" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-out-primary" id="complete" form="roleForm">Completar</button>
                </div>
            </div>
        </div>
    </div>
</div>
