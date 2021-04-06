<?php

namespace App\Http\Traits;

use App\Permission;
use App\Role;

trait HasPermissionsTrait
{

    public function roles()
    {

        return $this->belongsToMany(Role::class, 'role_user');

    }

    public function permissions()
    {

        return $this->belongsToMany(Permission::class, 'permission_user');

    }

    public function givePermissionsTo($permissions)
    {

        $permissions = $this->getAllPermissions($permissions);

        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function withdrawPermissionsTo($permissions)
    {

        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;

    }

    public function refreshPermissions($permissions)
    {

        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    public function hasPermissionTo($permission)
    {
        if ($this->hasPermissionThroughRole($permission) || $this->hasPermission($permission))
            return true;

        return false;
    }

    public function hasPermissionThroughRole($permission)
    {

        foreach ($this->roles as $role) {
            if ($role->permissions->contains('slug', $permission)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {

        if ($this->roles->contains('slug', $role)) {
            return true;
        }

        return false;
    }

    public function hasRoles($roles)
    {

        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermission($permission)
    {
        if ($this->permissions->contains('slug', $permission)) {
            return true;
        }

        return false;
    }

    public function hasPermissions($permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->permissions->contains('slug', $permission)) {
                return true;
            }
        }
        return false;
    }
}
