<div class="mt-4" id="generalGroup">
    <div class="form-group" style="margin-top: 2rem; display: flex; flex-wrap: wrap;">
        <div>
            <label class="label-primary-form" for="photo">Fotografia</label>
            <div class="d-flex align-items-center border rounded" style="width: 264px; height: 92px;">

                <input type="file" class="d-block border-danger" id="photo" name="photo" alt=""
                       style="position:absolute; height:92px; width: 264px; opacity: 0">

                <span id="img-span" class="material-icons material-icons mx-4"
                      style="background: rgba(229, 229, 229, 1); width: 64px; height: 64px; border-radius: 50%; font-size: 28px; display: flex;
                                      align-items: center;justify-content: center; color: white">
                                    cloud_upload
                                </span>

                <div class="d-flex flex-column mt-1">
                    <label class="label-text-form">Subir imagen</label>
                    <label class="label-text-form" style="font-size: 11px; line-height: 18px;">JPG - JPEG - PNG</label>
                </div>

            </div>
        </div>

        <div style="width: 47%;height: 67px;margin-left: 10%;" id="userStatusLbl">
            <label class="label-primary-form">Estado</label>
            <div style="width: 100%; min-height: 67px;">
                <select id="status" name="status" required>
                </select>
            </div>
        </div>

    </div>

    <div class="form-group" style="margin-top: 2rem;">
        <div style="display: flex; flex-wrap: wrap;">
            <div style="width: 47%; height: 67px;">
                <label class="label-primary-form" for="name">Nombre</label>
                <input type="text" class="form-control rounded-0 input-out" id="name" name="name"
                       placeholder="Nombre completo" required>
            </div>

            <div style="width: 47%; height: 67px; margin-left: 6%">
                <label class="label-primary-form" for="username">Usuario</label>
                <input type="text" class="form-control rounded-0 input-out" id="username" name="username"
                       placeholder="Nombre de usuario" required>
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 2rem;">
        <div style="display: flex; flex-wrap: wrap;">
            <div style="width: 47%; height: 67px;">
                <label class="label-primary-form" for="phone">Telefono</label>
                <input type="text" class="form-control rounded-0 input-out" id="phone" name="phone"
                       placeholder="Telefono">
            </div>

            <div style="width: 47%; height: 67px; margin-left: 6%">
                <label class="label-primary-form" for="email">E-mail</label>
                <input type="text" class="form-control rounded-0 input-out" id="email" name="email" placeholder="E-mail"
                       required>
            </div>
        </div>
    </div>
</div>
