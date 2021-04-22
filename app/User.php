<?php

namespace App;

use App\Http\Traits\HasPermissionsTrait;
use App\Notifications\CustomResetPassword;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    use Notifiable, HasPermissionsTrait;

    protected $fillable = ['name', 'username', 'phone','photo', 'status', 'is_store', 'role_id', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

    /** Boot */
    /*public static function boot() {
        parent::boot();
        static::creating(function (User $user) {
            $user->status = 1;
        });
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

    /**
     * Send the reset email notification.
     *
     * @param $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }


    /** Relationships */
    public function store(){

        return $this->hasOne(Store::class);
    }

    public function delivery(){

        return $this->hasOne(Delivery::class,'user_id');
    }
}
