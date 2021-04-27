<div class="col-12 img-container p-0 m-0 border-0 rounded-top shadow-e-md" id="coverContainer">

    <div class="img-wrap m-0 p-0" style="justify-content: center;position: relative;display: inline-flex;border-radius: 6px 6px 0 0">
        <img id="storeCover" class="img-content" src="" alt="" style="flex: none;"/>
    </div>

    <label class="cover-title"></label>

    <button type="button" id="closeBtn" class="pull-right border-0" onclick="closePanel()" style="position: absolute;
  right: 0;z-index: 5;" title="Cerrar">
        <span class="material-icons" style="font-size: 18px">close</span>
    </button>
</div>

<div class="col-12 m-0 p-0" style="max-height: 68%; height: 68%;">
    <div class="description-container col-12" style="padding: 1.5rem 2rem 0.5rem 2.5rem;height: 23%; text-align: justify">
        <p id="storeDescription" class="p-0 m-0" style="font-size: 13.6px">
        </p>
    </div>

    <div class="show-details-container" style="display: flex; width: 100%">
        <div class="show-columns-container">
            <div style="width: 97%">
                <div class="d-flex align-items-center store-border-bottom" style="position: static; width: 90%; height: 80px;flex: none; align-self: stretch; flex-grow: 0; margin-left: 1.25rem">
                <span class="material-icons ml-3"
                      style="background: rgba(255, 182, 0, 1); width: 40px; height: 40px; border-radius: 50%; font-size: 18px; display: flex;
                      align-items: center;justify-content: center; color: white">
                    menu_book
                </span>

                    <div class="d-flex flex-column ml-3">
                        <label class="body-1 mb-0" id="productsLbl">24</label>
                        <label class="label-text-form mb-0" style="font-size: 13.6px;line-height: 20px">Productos de menu</label>
                    </div>
                </div>

                <div class="d-flex align-items-center store-border-bottom" style="position: static; width: 90%; height: 80px;flex: none; align-self: stretch; flex-grow: 0; margin-left: 1.5rem">
                <span class="material-icons ml-3"
                      style="background: rgba(255, 182, 0, 1); width: 40px; height: 40px; border-radius: 50%; font-size: 18px; display: flex;
                      align-items: center;justify-content: center; color: white">
                    receipt
                </span>

                    <div class="d-flex flex-column ml-3">
                        <label class="body-1 mb-0" id="totalLbl">24</label>
                        <label class="label-text-form mb-0" style="font-size: 13.6px;line-height: 20px">Pedidos en total</label>
                    </div>
                </div>
            </div>


            <div style="width: 97%">
                <div class="d-flex align-items-center store-border-bottom" style="position: static; width: 90%; height: 80px;flex: none; align-self: stretch; flex-grow: 0; margin-left: 1.5rem">
                <span class="material-icons ml-3"
                      style="background: rgba(255, 182, 0, 1); width: 40px; height: 40px; border-radius: 50%; font-size: 18px; display: flex;
                      align-items: center;justify-content: center; color: white">
                    done_all
                </span>

                    <div class="d-flex flex-column ml-3">
                        <label class="body-1 mb-0" id="deliveredLbl">24</label>
                        <label class="label-text-form mb-0" style="font-size: 13.6px;line-height: 20px">Pedidos entregados</label>
                    </div>
                </div>

                <div class="d-flex align-items-center store-border-bottom" style="position: static; width: 90%; height: 80px;flex: none; align-self: stretch; flex-grow: 0; margin-left: 1.5rem">
                <span class="material-icons ml-3"
                      style="background: rgba(255, 182, 0, 1); width: 40px; height: 40px; border-radius: 50%; font-size: 18px; display: flex;
                      align-items: center;justify-content: center; color: white">
                    clear
                </span>

                    <div class="d-flex flex-column ml-3">
                        <label class="body-1 mb-0" id="cancelledLbl">24</label>
                        <label class="label-text-form mb-0" style="font-size: 13.6px;line-height: 20px">Pedidos cancelados</label>
                    </div>
                </div>
            </div>

        </div>

        <div class="rate-container" style="width: 306px; margin-right: 20px;">
            <div class="border rounded mb-4"
                 style="height: 320px;display: flex;flex-wrap: wrap;justify-content: center;">

                <div id="rateValues" class=w-100" style="display: inline-flex; margin-bottom: -60px; margin-top: 60px">
                </div>

                <div id="rateCointainer" class="w-100" style="display: inline-flex;justify-content: center;">
                    <i class="material-icons md-36 star"></i>
                    <i class="material-icons md-36 star"></i>
                    <i class="material-icons md-36 star"></i>
                    <i class="material-icons md-36 star"></i>
                    <i class="material-icons md-36 star"></i>
                </div>
            </div>
            <div class="align-items-end flex-column col-12 mb-3 p-0" style="max-height: 10%; height: 10%;">
                <button class="btn-out-primary btn-out-extra" id="editStore" data-toggle="modal"
                        data-target="#exampleModal">
                    Editar Usuario
                </button>
            </div>
        </div>
    </div>
</div>


