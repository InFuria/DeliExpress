<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 35%;" role="document">
        <div class="modal-content rounded">
            <div class="modal-header bg-orange-main d-flex justify-content-center"
                 style="height: 64px;max-height: 64px;">
                <h6 class="modal-title card-title" id="modalLabel" style="height: 100%">
                    Nuevo cupón
                </h6>
            </div>
            <div class="modal-body">
                <form id="modalCouponForm" method="post" action="{{ route('coupons.store') }}" enctype="multipart/form-data">
                    @csrf

                    <label class="sub-2 mt-3 mb-2" style="color: #FD4F00;">Configuración del cupón</label>
                    <div>
                        <div class="d-flex d-inline justify-content-between">
                            <div style="height: 55px; width: 48%">
                                <label class="little-label">Código</label>

                                <input type="text" class="form-control py-0 rounded-0 input-out text-uppercase" style="margin-top: -2px; line-height: 20px; color: black !important;" id="code" name="code" required>
                            </div>

                            <div style="height: 55px; width: 48%">
                                <label class="little-label">Porcentaje (%) de descuento</label>

                                <input type="text" class="form-control py-0 rounded-0 input-out" style="margin-top: -2px; line-height: 20px; color: black !important;" id="discount" name="discount" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex d-inline justify-content-between">
                            <div style="height: 55px; width: 48%">
                                <label class="little-label">Valido hasta</label>

                                <input type="text" class="form-control py-0 rounded-0 input-out" style="margin-top: -2px; line-height: 20px; color: black !important;" id="expired_date" name="expired_date" required>
                            </div>

                            <div style="height: 55px; width: 48%">
                                <label class="little-label">Negocio asignado</label>

                                <select id="stores" name="stores" required multiple>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>

                <div class="modal-footer" style="border-top: #979797; margin-top: 1rem;">
                    <button type="button" class="btn-out-disabled" id="cancel" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-out-primary" id="continue" form="modalCouponForm">Completar</button>
                </div>
            </div>
        </div>
    </div>
</div>
