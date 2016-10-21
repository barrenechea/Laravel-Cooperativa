<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $casts = [ 'is_admin' => 'boolean', ];
    protected $fillable = [
        'name', 'username', 'password', 'email', 'is_admin'
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function partner()
    {
        return $this->hasOne('App\Partner');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}