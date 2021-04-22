
<hr style="position: initial;">

<form id="storeForm" method="post" action="{{ route('stores.update', ['store' => 1]) }}" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div style="display: inline-flex; width: 100%">
        <div class="mt-4" id="generalGroup" style="width: 98%;margin-right: 2%">
            <label class="label-primary">Perfil de Negocio</label>

            <div class="form-group" style="margin-top: 2rem;">
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="width: 25%; height: 67px;">
                        <label class="label-primary-form" for="logo">Logo</label>
                        <div class="d-flex align-items-center border rounded shadow-e-sm" style="width: 264px; height: 92px;">

                            <input type="file" class="d-block border-danger" id="logo" name="logo" alt=""
                                   style="position:absolute; height:92px; width: 264px; opacity: 0">

                            <img id="logo-span" alt="" class="mx-4" src="https://image.freepik.com/vector-gratis/vector-silueta-gato-negro_23-2147493572.jpg"
                                 style="width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center;justify-content: center;">

                            <div class="d-flex flex-column mt-1">
                                <label class="label-text-form">Subir imagen</label>
                                <label class="label-text-form" style="font-size: 11px; line-height: 18px;">JPG - JPEG - PNG</label>
                            </div>

                        </div>
                    </div>

                    <div style="width: 25%; height: 67px;" id="coverContainer">
                        <label class="label-primary-form" for="cover">Portada</label>
                        <div class="d-flex align-items-center border rounded shadow-e-sm" style="width: 264px; height: 92px;">

                            <input type="file" class="d-block border-danger" id="cover" name="cover" alt="" style="position:absolute; height:92px; width: 264px; opacity: 0">

                            <img id="img-span" alt="" class="mx-4" src="https://i.pinimg.com/originals/79/d1/44/79d14493e27247edf5ee3f6c55dff043.jpg"
                                 style="width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center;justify-content: center;">

                            <div class="d-flex flex-column mt-1">
                                <label class="label-text-form">Subir imagen</label>
                                <label class="label-text-form" style="font-size: 11px; line-height: 18px;">JPG - JPEG - PNG</label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top: 7rem;">
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="width: 22%; height: 67px;">
                        <label class="label-primary-form" for="short_name">Nombre corto</label>
                        <input type="text" class="form-control rounded-0 input-out" id="short_name"
                               name="short_name" value="" placeholder="Nombre corto del negocio" required>
                    </div>

                    <div style="width: 22%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="long_name">Nombre largo</label>
                        <input type="text" class="form-control rounded-0 input-out" id="long_name"
                               name="long_name" value="" placeholder="Nombre largo del negocio" required>
                    </div>

                    <div style="width: 22%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="category">Categoria</label>
                        <select class="rounded-0 py-0" id="category"
                                name="category[]"  placeholder="Tipo de negocio" required>
                        </select>
                    </div>

                    <div style="width: 22%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="description">Descripcion</label>
                        <textarea class="form-control rounded-0 input-out py-0" rows="1" id="description"
                                  name="description" placeholder="Descripcion del negocio" required></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top: 5rem;">
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="width: 22%; height: 67px;">
                        <label class="label-primary-form" for="email">E-mail</label>
                        <input type="text" class="form-control rounded-0 input-out" id="email"
                               name="email" value="" placeholder="E-mail de negocio" required>
                    </div>

                    <div style="width: 22%; height: 67px;margin-left: 3%">
                        <label class="label-primary-form" for="address">Direccion</label>
                        <input type="text" class="form-control rounded-0 input-out" id="address"
                               name="address" value="" placeholder="Direccion del negocio" required>
                    </div>

                    <div style="width: 22%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="phone">Telefono</label>
                        <input type="text" class="form-control rounded-0 input-out" id="phone"
                               name="phone" value="" placeholder="Telefono fijo del negocio">
                    </div>

                    <div style="width: 22%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="mobile">Celular</label>
                        <input type="text" class="form-control rounded-0 input-out" id="mobile"
                               name="mobile" value="" placeholder="Telefono movil del negocio">
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top: 5rem;">
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="width: 22%; height: 67px;">
                        <label class="label-primary-form" for="department_id">Departamento</label>
                        <select id="department" name="department" placeholder="Departamento" required>
                        </select>
                    </div>

                    <div style="width: 22%; height: 67px;margin-left: 3%">
                        <label class="label-primary-form" for="municipality">Municipio</label>
                        <select id="municipality" name="municipality" placeholder="Municipio" required>
                        </select>
                    </div>

                    <div style="width: 22%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="zone_id">Zona</label>
                        <select id="zone" name="zone" placeholder="Zona" required>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer my-4" style="border-top: #979797;">
        <button type="submit" class="btn-out-compl btn-out-extra border-0 bg-darker text-white">Actualizar negocio</button>
    </div>
</form>

