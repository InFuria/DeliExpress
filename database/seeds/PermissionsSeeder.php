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
        $permission = new Permission;
        $permission->name = "Gestionar Usuarios";
        $permission->slug = "manage.users";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Ver Usuarios";
        $permission->slug = "show.users";
        $permission->save();

        $permission = new Permission;
        $permission->name = "Ver Clientes";
        $permission->slug = "show.clients";
        $permission->save();
    }
}
