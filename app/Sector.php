<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    public $timestamps = false;
	protected $table = 'sectors';

    protected $fillable = [
    	'name',
    ];

    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    public function bills()
    {
        return $this->belongsToMany('App\Bill');
    }
}
