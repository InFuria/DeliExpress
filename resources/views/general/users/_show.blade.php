<div class="col-12 p-0 shadow-e-sm" style="height: 34%;">
    <button type="button" id="closeBtn" class="pull-right" onclick="closePanel()" title="Cerrar">
        <span class="material-icons">close</span>
    </button>

    <div class="row m-0 p-0">
        <div class="userImg d-flex align-items-center p-0" style="height: 200px; width: 180px; justify-content: center">
            <img id="userImg" style="width: 150px; height: 150px; border-radius: 50%;
                                  align-items: center;justify-content: center;" class="border-0"
                 src="">
        </div>

        <div class="col align-items-start" id="userInfo">

        </div>
    </div>
</div>

<div class="d-flex align-items-start col-12 m-0 p-0" style="max-height: 60%; height: 60%; overflow-y: scroll;overflow-x: hidden;">
    <div class="row mt-3 ml-3 p-0 d-flex align-items-start">
        <label class="col label-primary-form mb-3">Seguridad</label>
        <div class="pl-3 col-12" style="font-family: 'Mulish'; line-height: 20px; color: #979797;">
            <div class="col-12 d-flex align-items-center pl-0">
                <span class="material-icons">assignment_ind</span>
                <span class="p-0">
                    &nbsp;Rol:&nbsp;&nbsp;&nbsp;&nbsp;
                    <span id="roleSpn"></span>
                </span>

            </div>

            <hr class="col-12">

            <div class="col-12 pl-0" style="">
                <div class="d-flex align-items-center">
                    <span class="material-icons">lock_open</span>
                    <span class="p-0">
                    &nbsp;Permisos extra:
                </span>
                </div>
                <br>
                <div class="row" style="display: inline-flex;" id="permissionsSpn">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex d-inline justify-content-end col-12 m-0 p-0" style="max-height: 10%; height: 10%;">
    <a href="" class="btn-out-primary btn-out-extra" id="resend" style="margin-right: 20px;">
        Reenviar verificacion
    </a>

    <button class="btn-out-primary btn-out-extra" id="editUser" data-toggle="modal" data-target="#exampleModal" style="margin-right: 20px;">
        Editar Usuario
    </button>
</div>
