<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;
    
	protected $table = 'bills';
    protected $casts = [ 'is_uf' => 'boolean', 'active' => 'boolean', 'overdue_is_uf' => 'boolean' ];
    protected $dates = ['end_bill', 'deleted_at'];

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
        'overdue_is_uf',
        'overdue_vfpcode',
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
