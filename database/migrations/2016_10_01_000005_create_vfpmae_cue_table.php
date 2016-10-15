<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVfpmaeCueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vfp_mae_cue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vfptable');
            $table->string('codigo')->nullable();
            $table->string('codigofecu')->nullable();
            $table->string('clase')->nullable();
            $table->string('nivel')->nullable();
            $table->string('subcta')->nullable();
            $table->string('ctacte')->nullable();
            $table->string('ctacte2')->nullable();
            $table->string('ctacte3')->nullable();
            $table->string('ctacte4')->nullable();
            $table->string('estado')->nullable();
            $table->string('estado2')->nullable();
            $table->string('nombre')->nullable();
            $table->integer('codi')->nullable();
            $table->integer('debe0')->nullable();
            $table->integer('haber0')->nullable();
            $table->integer('debe1')->nullable();
            $table->integer('haber1')->nullable();
            $table->integer('debe2')->nullable();
            $table->integer('haber2')->nullable();
            $table->integer('debe3')->nullable();
            $table->integer('haber3')->nullable();
            $table->integer('debe4')->nullable();
            $table->integer('haber4')->nullable();
            $table->integer('debe5')->nullable();
            $table->integer('haber5')->nullable();
            $table->integer('debe6')->nullable();
            $table->integer('haber6')->nullable();
            $table->integer('debe7')->nullable();
            $table->integer('haber7')->nullable();
            $table->integer('debe8')->nullable();
            $table->integer('haber8')->nullable();
            $table->integer('debe9')->nullable();
            $table->integer('haber9')->nullable();
            $table->integer('debe10')->nullable();
            $table->integer('haber10')->nullable();
            $table->integer('debe11')->nullable();
            $table->integer('haber11')->nullable();
            $table->integer('debe12')->nullable();
            $table->integer('haber12')->nullable();
            $table->integer('debep0')->nullable();
            $table->integer('haberp0')->nullable();
            $table->integer('debep1')->nullable();
            $table->integer('haberp1')->nullable();
            $table->integer('debep2')->nullable();
            $table->integer('haberp2')->nullable();
            $table->integer('debep3')->nullable();
            $table->integer('haberp3')->nullable();
            $table->integer('debep4')->nullable();
            $table->integer('haberp4')->nullable();
            $table->integer('debep5')->nullable();
            $table->integer('haberp5')->nullable();
            $table->integer('debep6')->nullable();
            $table->integer('haberp6')->nullable();
            $table->integer('debep7')->nullable();
            $table->integer('haberp7')->nullable();
            $table->integer('debep8')->nullable();
            $table->integer('haberp8')->nullable();
            $table->integer('debep9')->nullable();
            $table->integer('haberp9')->nullable();
            $table->integer('debep10')->nullable();
            $table->integer('haberp10')->nullable();
            $table->integer('debep11')->nullable();
            $table->integer('haberp11')->nullable();
            $table->integer('debep12')->nullable();
            $table->integer('haberp12')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vfp_mae_cue');
    }
}
