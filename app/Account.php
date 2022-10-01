<?php

namespace App;

use App\Notifications\AccountResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Setting;

class Account extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getEmailAttribute()
    {
        if(Setting::get('demo_mode', 0) == 1) {
            return substr($this->attributes['email'], 0, 3).'****'.substr($this->attributes['email'], strpos($this->attributes['email'], "@"));
        } else {
            return $this->attributes['email'];
        }
    }

    public function getMobileAttribute()
    {
        if(Setting::get('demo_mode', 0) == 1) {
            return substr($this->attributes['mobile'], 0, 5).'****';
        } else {
            return $this->attributes['mobile'];
        }
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AccountResetPassword($token));
    }
}
