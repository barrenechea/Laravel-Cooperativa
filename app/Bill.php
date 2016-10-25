<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
	protected $table = 'bills';
    protected $casts = [ 'is_uf' => 'boolean', 'active' => 'boolean' ];
    protected $dates = ['end_bill'];

    protected $fillable = [
    	'payment_day', 'amount', 'is_uf', 'description', 'vfptable', 'vfpcode', 'active', 'end_bill'
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
