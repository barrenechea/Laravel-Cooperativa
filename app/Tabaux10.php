<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabaux10 extends Model
{
    use SoftDeletes;

	protected $table = 'vfptabaux10';
    protected $casts = [ 'concredito' => 'boolean' ];
    protected $dates = ['fecha', 'deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'vfptable', 'tipo', 'kod', 'sucur', 'desc', 'orden_patr',
    	'estado', 'giro', 'tipo_calle', 'direccion', 'num',
    	'depto', 'sector', 'edificio', 'num_piso', 'entre_call',
    	'codcom', 'comuna', 'nom_region', 'region', 'codciu',
    	'ciudad', 'cod_postal', 'mail', 'telefono', 'anexo',
    	'fax', 'telefono_c', 'fax_c', 'internet', 'cod_area',
    	'celular', 'casilla', 'fecha', 'fpago', 'contacto',
    	'telconta', 'vendedor', 'observ', 'saldoau', 'exporta',
    	'credito', 'zona', 'direccions', 'telefonos', 'mails',
    	'contactos', 'codcoms', 'comunas', 'codcius', 'ciudads',
    	'concredito', 'codpais', 'pais', 'segmento'
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