<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logic extends Model
{
	public $timestamps = false;
	protected $table = 'logics';

    protected $fillable = [
    	'firstoverdue', 'secondoverdue'
    ];
}
