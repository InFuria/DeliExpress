<div class="col-12 p-0 m-0 border-0 rounded-top bg-orange-light shadow-e-md" id="coverContainer" style="max-height: 100px; height: 100px;
display: flex;justify-content: center; overflow: hidden; margin-left: 0 !important;">

    <label class="cover-title">Detalles del descuento</label>

    <button type="button" id="closeBtn" class="pull-right border-0" onclick="closePanel()" style="position: absolute; right: 0;z-index: 5;" title="Cerrar">
        <span class="material-icons" style="font-size: 18px">close</span>
    </button>
</div>

<div class="col-12 mt-4 p-0" id="couponDetails">
    <div style="display: flex; width: 100%; flex-direction: column; align-items: flex-start;">
        <div class="d-flex align-items-center bottom-divider" style="width: 87%; height: 80px;flex: none; align-self: stretch; flex-grow: 0; margin-left: 3rem">
            <span class="material-icons ml-3"
                  style="background: rgba(255, 182, 0, 1); width: 40px; height: 40px; border-radius: 50%; font-size: 18px; display: flex;
                  align-items: center;justify-content: center; color: white">
                done_outline
            </span>

            <div class="d-flex flex-column ml-3">
                <label class="body-1 mb-0" id="aplications"></label>
                <label class="label-text-form mb-0" style="font-size: 13.6px;line-height: 20px">Veces aplicado a ordenes entregadas</label>
            </div>
        </div>

        <div class="d-flex align-items-center bottom-divider" style="width: 87%; height: 80px;flex: none; align-self: stretch; flex-grow: 0; margin-left: 3rem">
            <span class="material-icons ml-3"
                  style="background: rgba(255, 182, 0, 1); width: 40px; height: 40px; border-radius: 50%; font-size: 18px; display: flex;
                  align-items: center;justify-content: center; color: white">
                date_range
            </span>

            <div class="d-flex flex-column ml-3">
                <label class="body-1 mb-0" id="days_past"></label>
                <label class="label-text-form mb-0" style="font-size: 13.6px;line-height: 20px">Transcurridos desde su creación</label>
            </div>
        </div>

        <div class="d-flex align-items-center bottom-divider" style="width: 87%; height: 80px;flex: none; align-self: stretch; flex-grow: 0; margin-left: 3rem">
            <span class="material-icons ml-3"
                  style="background: rgba(255, 182, 0, 1); width: 40px; height: 40px; border-radius: 50%; font-size: 18px; display: flex;
                  align-items: center;justify-content: center; color: white">
                event
            </span>

            <div class="d-flex flex-column ml-3">
                <label class="body-1 mb-0" id="remaining"></label>
                <label class="label-text-form mb-0" style="font-size: 13.6px;line-height: 20px">Restantes de validez</label>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-end justify-content-around col-12 mb-3 mt-5 p-0" style="max-height: 10%; height: 10%;">
        <button class="btn-out-primary btn-out-extra" id="statusCoupon">
        </button>

        <button class="btn-out-primary btn-out-extra" id="editCoupon">
            Editar cupón
        </button>
    </div>
</div>


