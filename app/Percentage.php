<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Percentage extends Model
{
    public $timestamps = false;
	protected $table = 'percentages';

    protected $fillable = [
    	'group_id', 'location_id', 'pct'
    ];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
