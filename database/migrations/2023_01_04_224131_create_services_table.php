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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('groups');
            $table->integer('code')->unique();
            $table->string('description')->nullable();
            $table->integer('repo')->nullable();
            $table->string('measure',50)->nullable();
            $table->boolean('have_igv')->default(true);
            $table->float('unit_price', 8, 2)->nullable();
            $table->float('unit_igv', 8, 2)->nullable();
            $table->float('unit_value', 8, 2)->nullable();
            $table->float('unit_price2', 8, 2)->nullable();
            $table->float('unit_igv2', 8, 2)->nullable();
            $table->float('unit_value2', 8, 2)->nullable();
            $table->boolean('have_measures')->default(false);
            $table->boolean('have_parts')->default(false);
            $table->boolean('is_qty')->default(false);
            $table->boolean('is_variable')->default(false);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('services');
    }
};
