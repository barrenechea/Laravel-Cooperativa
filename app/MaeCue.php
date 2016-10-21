<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaeCue extends Model
{
    use SoftDeletes;

	protected $table = 'vfpmaecue';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'vfptable', 'codigo', 'codigofecu', 'clase', 'nivel', 'subcta', 'ctacte',
    	'ctacte2', 'ctacte3', 'ctacte4', 'estado', 'estado2', 'nombre', 'codi',
    	'debe0', 'haber0', 'debe1', 'haber1', 'debe2', 'haber2', 'debe3', 'haber3',
    	'debe4', 'haber4', 'debe5', 'haber5', 'debe6', 'haber6',
    	'debe7', 'haber7', 'debe8', 'haber8', 'debe9', 'haber9',
    	'debe10', 'haber10', 'debe11', 'haber11', 'debe12', 'haber12',
    	'debep0', 'haberp0', 'debep1', 'haberp1', 'debep2', 'haberp2', 'debep3', 'haberp3',
    	'debep4', 'haberp4', 'debep5', 'haberp5', 'debep6', 'haberp6',
    	'debep7', 'haberp7', 'debep8', 'haberp8', 'debep9', 'haberp9',
    	'debep10', 'haberp10', 'debep11', 'haberp11', 'debep12', 'haberp12',
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