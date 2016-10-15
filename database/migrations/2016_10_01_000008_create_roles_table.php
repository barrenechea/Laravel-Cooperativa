<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->boolean('enabled')->default(true);
            $table->boolean('can_handle_admins')->default(false);
            $table->boolean('can_sync_users')->default(false);
            $table->boolean('can_view_data')->default(false);
            $table->boolean('can_view_overdue')->default(false);
            $table->boolean('can_send_messages')->default(false);
            $table->boolean('can_upload')->default(false);
            $table->boolean('can_external_accounting')->default(false);

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
        Schema::dropIfExists('roles');
    }
}