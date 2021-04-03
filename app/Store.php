<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmail;

class Store extends Authenticatable
{
    use Notifiable;

    protected $guard = 'store';
    protected $table = 'stores';

    private $username;
    private $password;

    protected $fillable = ['email', 'password'];
}
