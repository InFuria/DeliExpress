<main class="container bg-white shadow-e-sm border-0 mt-3 ml-3" id="municipalities-list">
    <div class="active-panel" style="display: none">
        <div style="height: 20%">
            <label class="label-primary mt-2" for="search">Buscar</label>
            <div class="form-group" style="margin-top: 1.5rem;">
                <input type="text" class="form-control search rounded-0 input-out" data-id="" id="municipality-search" name="municipality-search" placeholder="Ingrese un municipio">
            </div>
        </div>

        <div>
            <label class="label-primary">Municipios asociados</label>
            <div style="margin-top: 1rem" id="recent-municipalities" class="locations-container">

            </div>
        </div>
    </div>

    <div class="rounded d-flex right-panel-empty inactive-panel">
        <div style="max-width: 220px; text-align: center; transform: translateZ(50px)">
            <span class="material-icons" style="font-size: 70px; color: #E5E5E5">chrome_reader_mode</span>
            <label style="color: #979797; font-size: 16px; text-align: center; width: 170px">
                Selecciona un departamento para ver mas detalles
            </label>
        </div>
    </div>
</main>
