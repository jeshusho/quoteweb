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
        Schema::create('quote_service', function (Blueprint $table) {
            $table->foreignId('quote_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->integer('code')->nullable();
            $table->string('group_name')->nullable();
            $table->string('description')->nullable();
            $table->string('measure')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('unit_original_price', 8, 2)->nullable();
            $table->float('unit_price', 8, 2)->nullable();
            $table->float('subtotal', 8, 2)->nullable();
            $table->float('igv', 8, 2)->nullable();
            $table->float('total', 8, 2)->nullable();
            $table->boolean('have_measures')->default(false);
            $table->boolean('have_parts')->default(false);
            $table->boolean('is_qty')->default(false);
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
        Schema::dropIfExists('quote_service');
    }
};
