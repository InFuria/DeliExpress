<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "clients";

    protected $fillable = ["first_name", "second_name", "first_lastname", "second_lastname", "status", "phone", "mobile", "email"];

    /** Boot */
    public static function boot() {
        parent::boot();
        static::creating(function (Client $client) {
            $client->status = 1;
        });
    }

    /** Relationships **/
    public function addresses() {
        return $this->hasMany(ClientAddress::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
