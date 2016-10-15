<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected $fillable = [
    	'type_id', 'code', 'user_id'
    ];

    public function type()
    {
        return $this->hasOne('App\Type');
    }

    public function sector()
    {
        return $this->hasOne('App\Sector');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}