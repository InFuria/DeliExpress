<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = ['name', 'department_id'];

    /** Relationships **/
    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function zones(){
        return $this->hasMany(Zone::class);
    }
}
