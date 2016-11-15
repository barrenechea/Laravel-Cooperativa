<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    public $timestamps = false;
	protected $table = 'mailings';

    protected $fillable = [
    	'user_id', 'reason'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
