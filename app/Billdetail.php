<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billdetail extends Model
{
    use SoftDeletes;
    
	protected $table = 'billdetails';
    protected $dates = ['overdue_date', 'deleted_at'];
    protected $casts = [ 'overdue_billed' => 'boolean', ];
    protected $fillable = [
    	'bill_id', 'location_id', 'partner_id', 'amount', 'overdue_date', 'overdue_billed', 'created_at'
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

    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }
}
