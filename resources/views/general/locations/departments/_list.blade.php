<main class="container bg-white shadow-e-sm border-0 mt-3 ml-3" id="departments-list">
    <div>
        <div style="height: 20%">
            <label class="label-primary mt-2" for="search">Buscar</label>
            <div class="form-group" style="margin-top: 1.5rem;">
                <input type="text" class="form-control search rounded-0 input-out" id="department-search" name="department-search" placeholder="Ingrese un departamento">
            </div>
        </div>

        <div>
            <label class="label-primary">Departamentos recientes</label>
            <div style="margin-top: 1rem" id="recent-departments" class="locations-container">
                @foreach($departments->slice(0, 6) as $department)
                    <button id="departmentBtn" class="item-list d-flex align-items-center justify-content-between border-0 bg-white rounded" value="{{ $department->id }}"
                            onmouseover="mouseOver(this)" onmouseout="mouseOut(this)" onclick="loadMunicipalities($(this).val())">

                        <div class="d-flex align-items-center justify-content-start">
                            <span id="logo-span" class="material-icons icon-span material-icons ml-1 mr-3">
                        public
                        </span>

                            <div class="d-flex flex-column justify-content-center">
                                <label id="nameLbl" class="label-text-form label-extra">
                                    {{ $department->name }}
                                </label>
                                <label class="label-text-form searchBottomLbl">
                                    {{ $department->municipalities_count }} municipios asignados
                                </label>
                            </div>
                        </div>


                        <div class="locations-buttons-container" data-id="{{ $department->id }}">
                            <a type="button" class="locations-button create-location" title="Añadir municipio" data-type="municipality">
                                <span class="material-icons">add</span>
                            </a>

                            <a type="button" class="locations-button edit-location" title="Editar departamento" data-type="department">
                                <span class="material-icons">drive_file_rename_outline</span>
                            </a>

                            <a type="button" class="locations-button delete-location" title="Eliminar departamento" data-type="department">
                                <span class="material-icons">close</span>
                            </a>
                        </div>

                    </button>
                @endforeach
            </div>
        </div>
    </div>
</main>
