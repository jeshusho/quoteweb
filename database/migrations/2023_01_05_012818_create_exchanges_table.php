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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('source')->nullable();
            $table->date('date');
            $table->string('currency',3);
            $table->float('real_buy', 5, 3)->nullable();
            $table->float('real_sell', 5, 3)->nullable();
            $table->float('sell', 5, 3)->nullable();
            $table->float('exchange_rate', 7, 5)->nullable();
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
        Schema::dropIfExists('exchanges');
    }
};
