<?php

namespace App;

use App\Http\Traits\HasPermissionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyEmail;

class User extends Authenticatable
{
    use Notifiable, HasPermissionsTrait;

    protected $fillable = ['name', 'username', 'phone','img', 'status', 'is_store', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    /** Boot */
    public static function boot() {
        parent::boot();
        static::creating(function (User $user) {
            $user->status = 1;
        });
    }


    /** Roles Manage */
    /*public function authorizeRoles($roles)
    {
        abort_unless($this->hasAnyRole($roles), 401);
        return true;
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }*/


    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

}
