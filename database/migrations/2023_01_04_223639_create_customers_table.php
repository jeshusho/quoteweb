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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('code')->unique()->collation('utf8mb4_spanish_ci');
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->string('name');
            $table->string('comercial_name')->nullable();
            $table->string('address')->nullable();
            $table->string('departament')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('estatus')->nullable();
            $table->string('condition')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('payday')->default(0);
            $table->string('contact')->nullable();
            $table->string('payment_day')->nullable();
            $table->string('payment_phone')->nullable();
            $table->string('payment_contact')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
