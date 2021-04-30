<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 35%;" role="document">
        <div class="modal-content rounded">
            <div class="modal-header bg-orange-main d-flex justify-content-center" style="height: 64px;max-height: 64px;">
                <h6 class="modal-title card-title" id="modalLabel" style="height: 100%">
                </h6>
            </div>
            <div class="modal-body" id="header">
                <form id="locationForm" method="post" action="">
                    @csrf

                    <label class="sub-2 mt-3 mb-2" style="color: #FD4F00;"></label>
                    <div>
                        <div class="d-flex d-inline justify-content-between">
                            <div style="height: 55px; width: 48%">
                                <label class="little-label">Nombre</label>

                                <input type="text" class="form-control py-0 rounded-0 input-out" style="margin-top: -2px; line-height: 20px; color: black !important;" id="name" name="name" required>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="modal-footer" style="border-top: #979797;">
                    <button type="button" class="btn-out-disabled" id="cancel" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-out-primary" id="complete" data-type="asd" data-id="" form="locationForm"></button>
                </div>
            </div>
        </div>
    </div>
</div>
