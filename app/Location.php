<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $timestamps = false;
    protected $table = 'locations';

    protected $fillable = [
    	'type_id', 'sector_id', 'partner_id', 'code'
    ];

    public function percentages()
    {
        return $this->hasMany('App\Percentage');
    }

    public function billdetails()
    {
        return $this->hasMany('App\Billdetail');
    }

    public function type()
    {
        return $this->belongsTo('App\Type');
    }

    public function sector()
    {
        return $this->belongsTo('App\Sector');
    }

    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }

    public function bills()
    {
        return $this->belongsToMany('App\Bill');
    }
}