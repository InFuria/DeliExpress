
<hr style="position: initial;">

<form id="deliveryForm" method="post" action="{{ route('delivery.update', ['delivery' => $user->delivery->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div style="display: inline-flex; width: 100%">
        <div class="mt-4" id="generalGroup" style="width: 98%;margin-right: 2%">
            <label class="label-primary">Perfil de delivery</label>

            <div class="form-group" style="margin-top: 2rem;">
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="width: 30%; height: 67px;">
                        <label class="label-primary-form" for="identity_number">Identificacion</label>
                        <input type="text" class="form-control rounded-0 input-out" id="identity_number"
                               name="identity_number" value="{{ $user->delivery->identity_number }}" placeholder="Numero de identificacion nacional" required>
                    </div>

                    <div style="width: 30%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="birth">Nacimiento</label>
                        <input type="text" class="form-control rounded-0 input-out" id="birth"
                               name="birth" value="{{ $user->delivery->birth }}" placeholder="Fecha de Nacimiento" required>
                    </div>

                    <div style="width: 30%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="patent">Patente</label>
                        <input type="text" class="form-control rounded-0 input-out" id="patent"
                               name="patent" value="{{ $user->delivery->patent }}" placeholder="Codigo de patente" required>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top: 5rem;">
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="width: 30%; height: 67px;">
                        <label class="label-primary-form" for="code">Codigo de Delivery</label>
                        <input type="text" class="form-control rounded-0 input-out" id="code"
                               name="code" value="{{ $user->delivery->code }}" placeholder="Identificador de delivery en el sistema" required>
                    </div>

                    <div style="width: 30%; height: 67px;margin-left: 3%">
                        <label class="label-primary-form" for="lat">Latitud</label>
                        <input type="text" class="form-control rounded-0 input-out" id="lat"
                               name="lat" value="{{ $user->delivery->lat }}" placeholder="Latitud" required>
                    </div>

                    <div style="width: 30%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="lng">Longitud</label>
                        <input type="text" class="form-control rounded-0 input-out" id="lng"
                               name="lng" value="{{ $user->delivery->lng }}" placeholder="Longitud" required>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-top: 5rem;">
                <div style="display: flex; flex-wrap: wrap;">
                    <div style="width: 30%; height: 67px;">
                        <label class="label-primary-form" for="enabled">Habilitado</label>
                        <select class="rounded-0" id="enabled"
                                name="enabled" value="{{ $user->delivery->enabled }}" placeholder="Estado del delivery" required>
                        </select>
                    </div>

                    <div style="width: 30%; height: 67px; margin-left: 3%">
                        <label class="label-primary-form" for="available">Disponible</label>
                        <select class="rounded-0" id="available"
                                name="available" value="{{ $user->delivery->available }}" placeholder="Disponibilidad del delivery" required>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer" style="border-top: #979797;">
        <button type="submit" class="btn-out-compl btn-out-extra border-0 bg-purple text-white">Actualizar delivery</button>
    </div>
</form>

