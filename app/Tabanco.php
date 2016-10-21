<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabanco extends Model
{
    use SoftDeletes;

	protected $table = 'vfptabanco';
    protected $casts = [
        'estado' => 'boolean',
        'flg_ing' => 'boolean',
    ];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'vfptable', 'codempre', 'codbanco', 'nombanco', 'codctacc', 'ctacc',
    	'ctacontab', 'chequeact', 'chequefin', 'ingreact', 'ingrefin',
    	'egreact', 'egrefin', 'trasact', 'trasfin', 'compact',
    	'compfin', 'ventact', 'ventfin', 'uniact', 'estado',
    	'ano', 'flg_ing',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'vfptable', 'created_at', 'updated_at', 'deleted',
    ];
}