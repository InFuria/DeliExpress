<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded" style="border: 1px solid #E5E5E5 !important;">
            <div class="modal-header bg-tomato d-flex justify-content-center" style="height: 50px;max-height: 50px;">
                <h6 class="modal-title card-title" id="modalLabel" style="height: 100%">
                    Actualizar estado
                </h6>
            </div>
            <div class="modal-body">
                <form id="statusForm" method="post" action="">
                    @csrf

                    <p id="message" class="text-black-50"></p>

                    <div class="buttons-container d-flex justify-content-end">
                        <button type="button" class="btn-out-disabled" onclick="$('#statusModal').modal('hide')">Cancelar</button>
                        <button type="submit" class="btn-out-primary ml-2" id="btnAction" form="statusForm"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
