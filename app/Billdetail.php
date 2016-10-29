<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billdetail extends Model
{
	protected $table = 'billdetails';

    protected $dates = ['overdue_date'];

    protected $fillable = [
    	'bill_id', 'location_id', 'amount', 'overdue_date', 'overdue_amount'
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
