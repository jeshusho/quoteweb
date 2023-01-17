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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('ruc');
            $table->string('name');
            $table->string('comercial_name')->nullable();
            $table->string('slogan')->nullable();
            $table->string('address')->nullable();
            $table->string('departament')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('estatus')->nullable();
            $table->string('condition')->nullable();
            $table->string('location')->nullable();
            $table->string('zip_code')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
