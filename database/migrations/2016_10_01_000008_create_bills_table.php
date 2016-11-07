<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_day');
            $table->decimal('amount', 9, 2);
            $table->boolean('is_uf')->default(false);
            $table->string('description');
            $table->string('vfpcode');
            $table->integer('overdue_day')->nullable();
            $table->decimal('overdue_amount', 9, 2)->nullable();
            $table->boolean('overdue_is_uf')->nullable()->default(false);
            $table->string('overdue_vfpcode')->nullable();

            $table->boolean('active')->default(true);
            $table->date('end_bill')->nullable();
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
        Schema::dropIfExists('bills');
    }
}