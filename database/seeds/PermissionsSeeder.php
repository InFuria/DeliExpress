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
        \Eloquent::unguard();

        $path = 'storage/querys/permissions.sql';
        \DB::unprepared(file_get_contents($path));
        $this->command->info('Permissions table seeded!');
    }
}
