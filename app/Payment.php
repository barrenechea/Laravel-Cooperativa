<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $table = 'payments';

    protected $fillable = [
    	'billdetail_id', 'vfp_sesion_id', 'amount'
    ];

    public function billdetail()
    {
        return $this->belongsTo('App\Billdetail');
    }

    public function sesion()
    {
        return $this->belongsTo('App\Sesion');
    }
}
