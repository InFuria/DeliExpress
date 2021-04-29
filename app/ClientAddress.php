<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    protected $table = "client_addresses";

    protected $fillable = ["client_id", "direction", "phone", "mobile"];

    /** Relationships **/
    public function client(){
        return $this->belongsTo(Client::class, 'client_id')->withTimestamps();
    }
}
