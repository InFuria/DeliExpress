<div class="col-12 p-0 m-0 border-0 rounded-top bg-orange-light shadow-e-md" id="coverContainer" style="max-height: 100px; height: 100px;
display: flex;justify-content: center; overflow: hidden; margin-left: 0 !important;">

    <label class="cover-title">Detalles del rol</label>

    <button type="button" id="closeBtn" class="pull-right border-0" onclick="closePanel()" style="position: absolute; right: 0;z-index: 5;" title="Cerrar">
        <span class="material-icons" style="font-size: 18px">close</span>
    </button>
</div>

<div class="col-12 mt-4 p-0" id="roleDetails" style="max-height: 55%;height: 55%;">
    <div style="display: flex; width: 100%; flex-direction: column; align-items: flex-start;">
        <div class="d-flex align-items-center bottom-divider" style="width: 87%; height: 80px;flex: none; align-self: stretch; flex-grow: 0; margin-left: 3rem">
            <span class="material-icons icon-list-item ml-3">
                done_outline
            </span>

            <div class="d-flex flex-column ml-3">
                <label class="body-1 mb-0" id="users_count"></label>
                <label class="label-text-form mb-0" style="font-size: 13.6px;line-height: 20px">Usuarios asignados a este rol</label>
            </div>
        </div>

        <div class="d-flex align-items-center bottom-divider" style="width: 87%; height: 80px;flex: none; align-self: stretch; flex-grow: 0; margin-left: 3rem">
            <span class="material-icons icon-list-item ml-3">
                date_range
            </span>

            <div class="d-flex flex-column ml-3">
                <label class="body-1 mb-0" id="permissions_count"></label>
                <label class="label-text-form mb-0" style="font-size: 13.6px;line-height: 20px">Permisos asignados a este rol</label>
            </div>
        </div>
    </div>

    <label class="col label-primary-form mt-4 ml-4 pl-4">Detalle de permisos:</label>
    <div class="d-flex align-items-start m-0 p-0 ml-4" style="max-height: 60%; height: 60%; overflow-y: scroll;overflow-x: hidden;">
        <div class="row mt-3 ml-3 p-0 d-flex align-items-start">
            <div class="pl-3 col-12" style="font-family: 'Mulish'; line-height: 20px; color: #979797;">

                <div class="row" style="display: inline-flex;" id="permissionsSpn">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-end justify-content-around col-12 mb-3 mt-5 p-0" style="max-height: 10%; height: 10%;">
        <button class="btn-out-primary btn-out-extra" id="deleteRole">
            Eliminar rol
        </button>

        <button class="btn-out-primary btn-out-extra" id="editRole" data-id="">
            Editar rol
        </button>
    </div>
</div>


