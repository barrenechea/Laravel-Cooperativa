<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVFPTabancoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vfptabanco', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vfptable');
            $table->string('codempre')->nullable();
            $table->string('codbanco')->nullable();
            $table->string('nombanco')->nullable();
            $table->string('codctacc')->nullable();
            $table->string('ctacc')->nullable();
            $table->string('ctacontab')->nullable();
            $table->integer('chequeact')->nullable();
            $table->integer('chequefin')->nullable();
            $table->integer('ingreact')->nullable();
            $table->integer('ingrefin')->nullable();
            $table->integer('egreact')->nullable();
            $table->integer('egrefin')->nullable();
            $table->integer('trasact')->nullable();
            $table->integer('trasfin')->nullable();
            $table->integer('compact')->nullable();
            $table->integer('compfin')->nullable();
            $table->integer('ventact')->nullable();
            $table->integer('ventfin')->nullable();
            $table->integer('uniact')->nullable();
            $table->boolean('estado')->nullable();
            $table->integer('ano')->nullable();
            $table->boolean('flg_ing')->nullable();
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
        Schema::dropIfExists('vfptabanco');
    }
}
