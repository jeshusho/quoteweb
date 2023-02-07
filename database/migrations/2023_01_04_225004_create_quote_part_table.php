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
        Schema::create('quote_part', function (Blueprint $table) {
            $table->foreignId('quote_id')->constrained();
            $table->foreignId('part_id')->constrained();
            $table->string('description')->nullable();
            $table->string('measure')->nullable();
            $table->integer('measure_code_ref')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('unit_price', 8, 2)->nullable();
            $table->float('subtotal', 8, 2)->nullable();
            $table->float('igv', 8, 2)->nullable();
            $table->float('total', 8, 2)->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_part');
    }
};
