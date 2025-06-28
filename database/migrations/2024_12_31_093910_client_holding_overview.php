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
        Schema::create('holding_overview', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('symbol');
            $table->string('qty');
            $table->timestamps();
            $table->index('user_id', 'idx_overview_users_id')->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holding_overview');
    }
};
