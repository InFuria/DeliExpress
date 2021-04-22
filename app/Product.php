<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'img', 'price', 'cost', 'store_id', 'category_id'];


    /** Relationships */
    public function store(){

        return $this->belongsTo(Store::class);
    }

    public function category(){

        return $this->belongsTo(SubCategory::class);
    }
}
