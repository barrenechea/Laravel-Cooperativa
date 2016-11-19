<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('billdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bill_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->integer('partner_id')->unsigned();
            $table->string('vfpcode');
            $table->integer('amount');
            $table->date('overdue_date')->nullable();
            $table->boolean('overdue_billed')->nullable()->default(false);
            $table->boolean('overdue_is_daily')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
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
        Schema::dropIfExists('billdetails');
    }
}