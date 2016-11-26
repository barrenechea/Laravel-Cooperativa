<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
	public $timestamps = false;
	protected $table = 'types';

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
