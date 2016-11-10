<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    
	protected $table = 'payments';
    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'billdetail_id', 'vfpsesion_id', 'amount', 'user_id'
    ];

    public function billdetail()
    {
        return $this->belongsTo('App\Billdetail');
    }

    public function sesion()
    {
        return $this->belongsTo('App\Sesion');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
