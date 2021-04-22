<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = "sub_categories";
    protected $fillable = ['name', 'category_id'];

    /** Relationships */
    public function products(){

        return $this->hasMany(Product::class, 'category_id');
    }

    public function productCategory(){

        return $this->belongsTo(ProductCategory::class);
    }
}
