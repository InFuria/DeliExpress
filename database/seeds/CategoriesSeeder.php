<?php

use App\Category;
use App\ProductCategory;
use Illuminate\Database\Seeder;

class StoreCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat = new Category;
        $cat->name = 'Restaurante';
        $cat->img = 'https://i.pinimg.com/originals/4e/24/f5/4e24f523182e09376bfe8424d556610a.png';
        $cat->status = 1;
        $cat->save();

        $cat = new Category;
        $cat->name = 'Farmacia';
        $cat->img = 'https://skopelos.com/wp-content/uploads/2020/02/skopelos-pharmacies-farmakeia.png';
        $cat->status = 1;
        $cat->save();

        $cat = new Category;
        $cat->name = 'Supermercado';
        $cat->img = 'https://pics.freeicons.io/uploads/icons/png/8026814321579250998-512.png';
        $cat->status = 1;
        $cat->save();
    }
}
