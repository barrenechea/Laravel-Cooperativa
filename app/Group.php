<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;
	protected $table = 'groups';

    protected $fillable = [
    	'description'
    ];

    public function percentages()
    {
        return $this->hasMany('App\Percentage');
    }

    public function locations()
    {
        return $this->belongsToMany('App\Location');
    }

    public function bills()
    {
        return $this->belongsToMany('App\Bill');
    }
}
