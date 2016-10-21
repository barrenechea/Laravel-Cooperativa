<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $table = 'messages';
    protected $casts = [ 'has_file' => 'boolean', ];

    protected $fillable = [
    	'user_id', 'message', 'has_file'
    ];

    public function file()
    {
        return $this->hasOne('App\File');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
