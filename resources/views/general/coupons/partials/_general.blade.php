<div class="mt-4" id="generalGroup">
    <div class="form-group d-flex justify-content-between" style="margin-top: 2rem;">
        <div>
            <label class="label-primary-form" for="logo">Logo</label>
            <div class="d-flex align-items-center border rounded"
                 style="width: 287px; height: 92px;">

                <input type="file" class="d-block border-danger" id="logo" name="logo" alt=""
                       style="position:absolute; height:92px; width: 287px; opacity: 0">

                <span id="logo-span" class="material-icons mx-4"
                      style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;
                      align-items: center;justify-content: center; color: white">
                    camera
                </span>

                <div class="d-flex flex-column">
                    <label class="label-text-form mb-0">Subir imagen</label>
                    <label class="label-text-form mb-0" style="font-size: 11px;">600 x 600
                        píxeles</label>
                </div>

            </div>
        </div>

        <div>
            <label class="label-primary-form" for="cover">Fotografía de portada</label>
            <div class="d-flex align-items-center border rounded"
                 style="width: 287px; height: 92px;">

                <input type="file" class="d-block border-danger" id="cover" name="cover" alt=""
                       style="position:absolute; height:92px; width: 287px; opacity: 0">

                <span id="cover-span" class="material-icons mx-4"
                      style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;
                      align-items: center;justify-content: center; color: white">
                    camera
                </span>

                <div class="d-flex flex-column">
                    <label class="label-text-form mb-0">Subir imagen</label>
                    <label class="label-text-form mb-0" style="font-size: 11px;">1000 x 300
                        píxeles
                    </label>
                </div>

            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 2rem; margin-bottom: 0">
        <label class="label-primary-form" for="categories">Clasificacion</label>
        <div style="width: 47%; height: 67px; margin-top: 1rem">
            <select id="categories" name="categories[]" multiple required>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="label-primary-form">Detalles</label>
        <div style="display: flex; flex-wrap: wrap;">
            <div style="width: 47%; margin-top: 0.5rem">
                <input type="text" class="form-control rounded-0 input-out" id="long_name" name="long_name" placeholder="Nombre completo" required>
            </div>

            <div style="width: 47%; margin-left: 6%; margin-top: 0.5rem">
                <input type="text" class="form-control rounded-0 input-out" id="short_name" name="short_name" placeholder="Nombre corto" required>
            </div>

            <div style="width: 100%; margin-top: 2rem">
                <textarea rows="3" class="form-control rounded-0 input-out" id="description" name="description" placeholder="Descripcion" required></textarea>
            </div>
        </div>
    </div>
</div>
