<div class="mt-4" id="contactGroup" style="display:none">
    <div class="form-group" style="margin-top: 2rem;">
        <label class="label-primary-form mb-3">Ubicacion</label>
        <div class="d-flex justify-content-between w-100">
            <div class="w-100 mr-4">
                <select id="department_id" name="department_id" required>
                </select>
            </div>

            <div class="w-100 mr-4">
                <select id="municipality_id" name="municipality_id" required>
                </select>
            </div>

            <div class="w-100">
                <select id="zone_id" name="zone_id" required>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group" style="margin-top: 2rem; margin-bottom: 2rem">
        <label class="label-primary-form">Contacto</label>
        <div style="display: flex; flex-wrap: wrap;">
            <div class="d-flex justify-content-between w-100">
                <div style="width: 47%; margin-top: 0.5rem">
                    <input type="text" class="form-control rounded-0 input-out" id="address" name="address" placeholder="Direccion" required>
                </div>

                <div style="width: 47%; margin-top: 0.5rem">
                    <input type="text" class="form-control rounded-0 input-out" id="phone" name="phone" placeholder="Teléfono fijo" required>
                </div>
            </div>

            <div class="d-flex justify-content-between w-100 mt-4">
                <div style="width: 47%; margin-top: 0.5rem">
                    <input type="text" class="form-control rounded-0 input-out" id="mobile" name="mobile" placeholder="Teléfono movil" required>
                </div>

                <div style="width: 47%; margin-left: 6%; margin-top: 0.5rem">
                    <input type="text" class="form-control rounded-0 input-out" id="email" name="email" placeholder="E-mail" required>
                </div>
            </div>
        </div>
    </div>
</div>
