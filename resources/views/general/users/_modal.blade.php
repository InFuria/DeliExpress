<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 35%;" role="document">
        <div class="modal-content rounded">
            <div class="modal-header bg-orange-main d-flex justify-content-center" style="height: 64px;max-height: 64px;">
                <h6 class="modal-title card-title" id="modalLabel" style="height: 100%">
                    Nuevo usuario
                </h6>
            </div>
            <div class="modal-body" id="header">
                <div class="d-flex header-container align-items-stretch bg-white border-0 shadow-e-sm rounded" style="height: 70px">
                    <button class="bg-white btn-header header-active rounded-0" id="general">
                        <span class="material-icons d-block mb-2">person_outline</span>
                        GENERALES
                    </button>
                    <button class="bg-white btn-header header-inactive rounded-0" id="security">
                        <span class="material-icons d-block mb-2">lock</span>
                        SEGURIDAD
                    </button>
                </div>

                <form id="modalUserForm" method="post" action="" enctype="multipart/form-data">
                    @csrf

                    @include('general.users.partials._general')

                    @include('general.users.partials._security')
                </form>

                <div class="modal-footer" style="border-top: #979797;">
                    <button type="button" class="btn-out-disabled" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-out-primary" id="previous" hidden>Regresar</button>
                    <button type="button" class="btn-out-primary" id="continue" form="modalUserForm">Continuar</button>
                </div>
            </div>
        </div>
    </div>
</div>
