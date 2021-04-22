<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::where('slug', 'like', '%users.%')->orWhere('slug', 'like', '%clients.%')->pluck('id');
        $role = Role::where('slug', 'admin')->first();
        $role->permissions()->sync($permissions);

    }
}
