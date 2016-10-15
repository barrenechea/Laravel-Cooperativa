<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tabanco extends Model
{
	protected $table = 'vfp_tabanco';

    protected $casts = [
        'estado' => 'boolean',
        'flg_ing' => 'boolean',
    ];

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
        'vfptable', 'created_at', 'updated_at',
    ];
}