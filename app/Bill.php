<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
	protected $table = 'bills';
    protected $casts = [ 'is_uf' => 'boolean', 'active' => 'boolean', 'overdue_is_uf' => 'boolean' ];
    protected $dates = ['end_bill'];

    protected $fillable = [
    	'payment_day',
        'amount',
        'is_uf',
        'description',
        'vfpcode',
        'active',
        'end_bill',
        'overdue_day',
        'overdue_amount',
        'overdue_is_uf'
    ];

    public function billdetails()
    {
        return $this->hasMany('App\Billdetail');
    }

    public function sectors()
    {
        return $this->belongsToMany('App\Sector');
    }

    public function locations()
    {
        return $this->belongsToMany('App\Location');
    }

    public function groups()
    {
        return $this->belongsToMany('App\Group');
    }
}
