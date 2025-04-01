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
        Schema::create('holdings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_no');
            $table->string('symbol');
            $table->string('stock_name');
            $table->unsignedBigInteger('no_of_shares');
            $table->double('unit_price');
            $table->date('trade_date');
            $table->double('purchase');
            $table->double('current');
            $table->double('sell')->default(0);
            $table->double('commission')->default(0);
            $table->double('profit_loss')->default(0);
            $table->double('sell_after_commission')->default(0);
            $table->double('debit')->default(0);
            $table->double('total')->default(0);
            $table->string('status');
            $table->string('type');
            $table->double('remaining')->default(0);
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
        Schema::dropIfExists('holdings');
    }
};
