<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	public $timestamps = false;
	protected $table = 'files';

    protected $fillable = [
    	'message_id', 'url'
    ];

    public function message()
    {
        return $this->belongsTo('App\Message');
    }
}
