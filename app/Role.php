<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    /** Relationships */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions() {

        return $this->belongsToMany(Permission::class,'permission_role');

    }
}
