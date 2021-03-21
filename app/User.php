<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class User extends Authenticatable
{
    use CanResetPassword, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function events()
    {
        return $this->hasMany('App\Event', 'user_id', 'id');
    }


     /* Send notificaion */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this->email));
    }

    public function eventName()
      {
        return $this->hasOne('App\Event');
      }

    public function listInivation(){
        return $this->hasOne('App\Inivation');
    }  

    public function inviteelist(){
        return $this->hasMany('App\Inivation');
    }

    public function group(){
        return $this->hasMany('App\Menu_group');
    } 
}


