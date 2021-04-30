<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['name', 'municipality_id'];

    /** Relationships **/
    public function municipality(){
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }
}
