<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class ProductCategory extends Model
{
    protected $table = 'product_categories';

    protected $fillable = ['name', 'store_id', 'status'];

    /** Boot */
    public static function boot() {
        parent::boot();
        static::creating(function (ProductCategory $category) {
            $category->status = 1;
        });
    }

    /** Relationships */
    public function stores()
    {
        return $this->belongsTo(Store::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCategory::class);
    }
}
