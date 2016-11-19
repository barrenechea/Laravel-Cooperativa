<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billdetail_id')->unsigned();
            $table->integer('vfpsesion_id')->unsigned()->nullable();
            $table->integer('amount');
            $table->string('document_id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('billdetail_id')->references('id')->on('billdetails')->onDelete('cascade');
            $table->foreign('vfpsesion_id')->references('id')->on('vfpsesion')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
}