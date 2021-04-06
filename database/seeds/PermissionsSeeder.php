<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** USERS */
        $permission = new Permission;
        $permission->name = "Ver Usuarios";
        $permission->slug = "users.index";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Crear Usuarios";
        $permission->slug = "users.store";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Editar Usuarios";
        $permission->slug = "users.edit";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Eliminar Usuarios";
        $permission->slug = "users.destroy";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Ver Usuario";
        $permission->slug = "users.show";
        $permission->save();


        /** CLIENTS */
        $permission = new Permission;
        $permission->name = "Ver Clientes";
        $permission->slug = "clients.index";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Crear Clientes";
        $permission->slug = "clients.store";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Editar Clientes";
        $permission->slug = "clients.edit";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Eliminar Clientes";
        $permission->slug = "clients.destroy";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Ver Cliente";
        $permission->slug = "clients.show";
        $permission->save();
    }
}
