<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

	protected $table = 'messages';
    protected $dates = ['deleted_at'];
    protected $casts = [ 'has_file' => 'boolean', ];

    protected $fillable = [
    	'user_id', 'message', 'has_file'
    ];

    public function fileentry()
    {
        return $this->hasOne('App\Fileentry');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
