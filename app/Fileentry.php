<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fileentry extends Model
{
	public $timestamps = false;
	protected $table = 'fileentries';

    protected $fillable = [
    	'message_id', 'filename', 'mime', 'original_filename'
    ];

    public function message()
    {
        return $this->belongsTo('App\Message');
    }
}
