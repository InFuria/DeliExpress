<div id="newGroup" class="secondary-modal" style="display: none; height: auto; max-height: 303px; margin-top: 2rem">
    <div class="d-flex">
        <label class="label-primary-form">Nuevo producto</label>

        <button type="button" id="closeBtn" class="pull-right border-0" onclick="closeProductPanel()" style="position: absolute;right: 3%; z-index: 5;" title="Cerrar formulario de producto">
            <span class="material-icons" style="font-size: 18px">close</span>
        </button>
    </div>

    <div class="rounded" id="productFormContainer" style="border: 1px solid #E5E5E5; display: none">
        <form id="productStoreForm" method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group d-flex justify-content-between align-content-end" style="margin-top: 1.5rem; margin-left: 1.5rem;">
                <div class="d-flex align-items-center border rounded" style="width: 255px; height: 106px;">
                    <input type="file" class="d-block border-danger" id="img" name="img" alt=""
                           style="position:absolute; width: 255px; height:106px; opacity: 0" onchange="loadImage(this)">

                    <span id="img-span" class="material-icons mx-4" style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;
                  align-items: center;justify-content: center; color: white">
                        camera
                    </span>

                    <div class="d-flex flex-column">
                        <label class="label-text-form mb-0">Subir imagen</label>
                        <label class="label-text-form mb-0" style="font-size: 11px;">1000 x 1000 píxeles</label>
                    </div>

                </div>


                <div style="width: 48%;margin-right: 1.5rem;">
                    <div style="height: 55px;">
                        <label class="little-label">Título</label>
                        <input type="text" class="form-control py-0 rounded-0 input-out" style="margin-top: -2px; line-height: 20px; color: black !important;" id="name" name="name" required>
                    </div>

                    <div class="d-flex d-inline justify-content-between">
                        <div style="height: 55px; width: 45%">
                            <label class="little-label">Costo</label>
                            <div style="display: flex">
                                <span style="position: absolute; margin-left: 1px; margin-top: 1px;">$</span>
                                <input type="text" class="form-control py-0 rounded-0 input-out" style="margin-top: -2px; line-height: 20px; color: black !important; padding-left: 10px !important;" id="cost" name="cost" required>
                            </div>
                        </div>

                        <div style="height: 55px; width: 45%">
                            <label class="little-label">Precio</label>
                            <div style="display: flex">
                                <span style="position: absolute; margin-left: 1px; margin-top: 1px;">$</span>
                                <input type="text" class="form-control py-0 rounded-0 input-out" style="margin-top: -2px; line-height: 20px; color: black !important; padding-left: 10px !important;" id="price" name="price" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-left: 1.5rem; margin-right: 1.5rem;">
                <label class="little-label">Description</label>
                <div style="width: 100%;">
                    <textarea rows="3" class="form-control rounded-0 input-out" style="margin-top: -2px; line-height: 20px; color: black !important;" id="description" name="description" required></textarea>
                </div>
            </div>

            <div class="modal-footer" style="border-top: #979797; padding-top: 0.25rem; padding-bottom: 0.5rem;">
                <button type="reset" class="btn-out-disabled" onclick="resetProductForm()">Limpiar</button>
                <button type="submit" class="btn-out-purple" id="createProduct" style="width: 190px">Crear producto</button>
            </div>
        </form>
    </div>

    <div id="editProductPreview" class="justify-content-center align-items-center h-100"
         style="margin: 5px 0;border: 1px solid #E5E5E5;border-radius: 6px; display: flex;">
        <div class="rounded" style="max-width: 100%; text-align: center;">
            <span class="material-icons" style="font-size: 70px; color: #E5E5E5">chrome_reader_mode</span>
            <p style="color: #979797; font-size: 16px; text-align: center; width: 255px">
                Selecciona un producto de la lista para editar
            </p>
        </div>
    </div>
</div>
