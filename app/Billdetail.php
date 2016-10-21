<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billdetail extends Model
{
	protected $table = 'billdetails';

    protected $fillable = [
    	'bill_id', 'location_id', 'amount'
    ];

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function bill()
    {
        return $this->belongsTo('App\Bill');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
