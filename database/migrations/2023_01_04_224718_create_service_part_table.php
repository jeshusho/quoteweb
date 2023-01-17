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
        Schema::create('service_part', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained();
            $table->foreignId('part_id')->constrained();
            //$table->integer('service_qty')->constrained();
            $table->integer('part_qty')->nullable();
            $table->string('measure',100)->nullable();
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
        Schema::dropIfExists('service_part');
    }
};
