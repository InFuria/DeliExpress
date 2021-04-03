<nav>
    <div class="d-flex justify-content-center my-4">
        <img src="{{ Asset('assets/img/image6.png') }}" width="91">
    </div>

    <a href="{{ route('home') }}" class="menu-option menu-inactive d-flex justify-content-left align-items-center">
        <span class="material-icons icon-sidebar">donut_large</span>
        Resumen
    </a>

    @role('admin')

    <div class="menu-option menu-inactive d-flex justify-content-left align-items-center dropdown" style="cursor: default;">
        <span class="material-icons icon-sidebar">admin_panel_settings</span>
        <a class="text-sidebar d-flex align-items-center" type="button" style="width: 100%"
           id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Administracion
            <span class="material-icons ml-auto">navigate_before</span>
        </a>

        <div class="dropdown-menu bg-black p-0" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-sidebar" href="{{ route('users.index') }}">
                <span class="material-icons icon-sidebar mr-2">manage_accounts</span>
                Usuarios
            </a>
            <a class="dropdown-sidebar" href="{{ route('roles.index') }}">
                <span class="material-icons icon-sidebar mr-2">room_preferences</span>
                Roles
            </a>
            <a class="dropdown-sidebar" href="{{ route('permissions.index') }}">
                <span class="material-icons icon-sidebar mr-2">description</span>
                Permisos
            </a>
        </div>
    </div>

    @endrole

    <a class="menu-option menu-inactive d-flex justify-content-left align-items-center">
        <span class="material-icons icon-sidebar">add_shopping_cart</span>
        Pedidos
    </a>

    <a class="menu-option menu-inactive d-flex justify-content-left align-items-center">
        <span class="material-icons icon-sidebar">people</span>
        Clientes
    </a>

    <a class="menu-option menu-inactive d-flex justify-content-left align-items-center">
        <span class="material-icons icon-sidebar">store</span>
        Negocios
    </a>

    <a class="menu-option menu-inactive d-flex justify-content-left align-items-center">
        <span class="material-icons icon-sidebar">delivery_dining</span>
        Repartidores
    </a>

    <a class="menu-option menu-inactive d-flex justify-content-left align-items-center">
        <span class="material-icons icon-sidebar">local_offer</span>
        Cupones
    </a>

    <div class="menu-option menu-inactive d-flex justify-content-left align-items-center">
        <span class="material-icons icon-sidebar">list</span>
        Registros
    </div>

    <div class="menu-option menu-inactive d-flex justify-content-left align-items-center">
        <span class="material-icons icon-sidebar">announcement</span>
        Soporte
    </div>

    <div class="menu-inactive d-flex justify-content-left align-items-center"
         style="bottom: 0; border-top: 1px solid rgba(255, 255, 255, 0.1); position: absolute; height: 53px;
     width: 200px !important; left: 1.2%; padding-left: 0">
        <span class="material-icons icon-sidebar" style="color: #979797">help_outline</span>
        <a class="text-sidebar d-flex align-items-center" type="button" style="width: 100%">Ayuda<span class="material-icons ml-auto">navigate_before</span>
        </a>
    </div>
</nav>
