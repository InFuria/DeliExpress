<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role;
        $role->name = "Usuario Nuevo";
        $role->slug = "new";
        $role->save();

        $role = new Role;
        $role->name = "Administrador General";
        $role->slug = "admin";
        $role->save();

        $role = new Role;
        $role->name = "Personal de Negocio";
        $role->slug = "staff";
        $role->save();

        $role = new Role;
        $role->name = "Personal de Delivery";
        $role->slug = "delivery";
        $role->save();

        $role = new Role;
        $role->name = "Negocio";
        $role->slug = "store";
        $role->save();

        $role = new Role;
        $role->name = "Personal de Deli-Express";
        $role->slug = "express-staff";
        $role->save();
    }
}
