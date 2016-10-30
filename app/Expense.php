<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
	public $timestamps = false;
	protected $table = 'expenses';

    protected $fillable = [
    	'vfpcode',
    ];
}
