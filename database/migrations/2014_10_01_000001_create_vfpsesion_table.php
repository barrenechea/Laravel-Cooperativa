<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVfpsesionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vfp_sesion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vfptable');
            $table->char('tipo', 1)->nullable();
            $table->integer('numero')->nullable();
            $table->integer('correl')->nullable();
            $table->integer('va_ifrs')->nullable();
            $table->integer('canbco')->nullable();
            $table->string('banco')->nullable();
            $table->string('cuenta')->nullable();
            $table->integer('cheque')->nullable();
            $table->date('fecha')->nullable();
            $table->string('glosa')->nullable();
            $table->string('benefi')->nullable();
            $table->date('fechach')->nullable();
            $table->string('area')->nullable();
            $table->integer('linea')->nullable();
            $table->string('codigo')->nullable();
            $table->string('tipdoc')->nullable();
            $table->date('fechafac')->nullable();
            $table->integer('fac')->nullable();
            $table->integer('corrfac')->nullable();
            $table->string('detalle1')->nullable();
            $table->string('detalle2')->nullable();
            $table->string('detalle3')->nullable();
            $table->string('detalle4')->nullable();
            $table->char('imp', 1)->nullable();
            $table->integer('debe')->nullable();
            $table->integer('haber')->nullable();
            $table->char('estado', 1)->nullable();
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
        Schema::dropIfExists('vfp_sesion');
    }
}
