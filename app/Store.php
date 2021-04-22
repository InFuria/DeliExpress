<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $table = 'stores';

    protected $fillable = ['user_id', 'long_name', 'short_name', 'description', 'address', 'phone', 'mobile', 'email',
        'logo', 'cover', 'rate_avg', 'department_id', 'municipality_id', 'zone_id'];

    /** Relationships */
    public function user(){

        return $this->belongsTo(Store::class);
    }

    public function categories(){

        return $this->belongsToMany(Category::class, 'category_store', 'store_id', 'category_id')->withTimestamps();
    }

    public function productCategories(){

        return $this->hasMany(ProductCategory::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
