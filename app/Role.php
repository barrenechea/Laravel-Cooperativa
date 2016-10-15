<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'roles';

    protected $casts = [
        'enabled'                   => 'boolean',
        'can_handle_admins'         => 'boolean',
        'can_sync_users'            => 'boolean',
        'can_view_data'             => 'boolean',
        'can_view_overdue'          => 'boolean',
        'can_send_messages'         => 'boolean',
        'can_upload'                => 'boolean',
        'can_external_accounting'   => 'boolean',
    ];

    protected $fillable = [
    	'enabled',
        'can_handle_admins',
        'can_sync_users',
        'can_view_data',
        'can_view_overdue',
        'can_send_messages',
        'can_upload',
        'can_external_accounting'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}