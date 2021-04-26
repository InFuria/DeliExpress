<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = "coupons";
    protected $fillable = ['code', 'discount', 'expired_date', 'status'];

    /** Relationships **/
    public function stores(){
        return $this->belongsToMany(Store::class, 'coupon_store');
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'coupon_order');
    }
}
