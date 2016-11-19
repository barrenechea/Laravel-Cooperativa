<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('logics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('firstoverdue');
            $table->integer('secondoverdue');
            $table->integer('ssd_warning')->default(0);
            $table->integer('endbill_notificationdays')->default(60);
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
        Schema::dropIfExists('logics');
    }
}