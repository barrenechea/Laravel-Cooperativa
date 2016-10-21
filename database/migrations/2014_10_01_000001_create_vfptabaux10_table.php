<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVFPTabaux10Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vfptabaux10', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vfptable');
            $table->string('tipo')->nullable();
            $table->string('kod')->nullable();
            $table->string('sucur')->nullable();
            $table->string('desc')->nullable();
            $table->integer('orden_patr')->nullable();
            $table->string('estado')->nullable();
            $table->string('giro')->nullable();
            $table->integer('tipo_calle')->nullable();
            $table->string('direccion')->nullable();
            $table->string('num')->nullable();
            $table->string('depto')->nullable();
            $table->string('sector')->nullable();
            $table->string('edificio')->nullable();
            $table->integer('num_piso')->nullable();
            $table->string('entre_call')->nullable();
            $table->string('codcom')->nullable();
            $table->string('comuna')->nullable();
            $table->string('nom_region')->nullable();
            $table->integer('region')->nullable();
            $table->string('codciu')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('cod_postal')->nullable();
            $table->string('mail')->nullable();
            $table->string('telefono')->nullable();
            $table->string('anexo')->nullable();
            $table->string('fax')->nullable();
            $table->string('telefono_c')->nullable();
            $table->string('fax_c')->nullable();
            $table->string('internet')->nullable();
            $table->string('cod_area')->nullable();
            $table->string('celular')->nullable();
            $table->string('casilla')->nullable();
            $table->date('fecha')->nullable();
            $table->string('fpago')->nullable();
            $table->string('contacto')->nullable();
            $table->string('telconta')->nullable();
            $table->string('vendedor')->nullable();
            $table->string('observ')->nullable();
            $table->integer('saldoau')->nullable();
            $table->string('exporta')->nullable();
            $table->integer('credito')->nullable();
            $table->string('zona')->nullable();
            $table->string('direccions')->nullable();
            $table->string('telefonos')->nullable();
            $table->string('mails')->nullable();
            $table->string('contactos')->nullable();
            $table->string('codcoms')->nullable();
            $table->string('comunas')->nullable();
            $table->string('codcius')->nullable();
            $table->string('ciudads')->nullable();
            $table->boolean('concredito')->nullable();
            $table->string('codpais')->nullable();
            $table->string('pais')->nullable();
            $table->string('segmento')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('vfptabaux10');
    }
}
