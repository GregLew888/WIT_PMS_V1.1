<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holding_status_history', function (Blueprint $table) {
            $table->id();
            $table->integer('holding_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('old_status');
            $table->string('new_status');
            $table->timestamps();

            $table->index('holding_id', 'idx_holdings_id')->foreign('holding_id')->references('id')->on('holdings');
            $table->index('user_id', 'idx_users_id')->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holding_status_history');
    }
};
