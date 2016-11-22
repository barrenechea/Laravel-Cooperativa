<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    public $timestamps = false;
	protected $table = 'partners';
    protected $casts = [ 'has_file' => 'boolean', ];

    protected $fillable = [
    	'user_id', 'address', 'phone'
    ];

    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function billdetails()
    {
        return $this->hasMany('App\Billdetail');
    }
}
