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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->date('date');
            //$table->foreign('user_id')->nullable()->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('customer_id')->nullable()->references('id')->on('customers');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers');
            // $table->unsignedBigInteger('contact_id')->nullable()->nullable();
            // $table->foreign('contact_id')->references('id')->on('contacts');
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('brand')->nullable();
            $table->string('motor')->nullable();
            $table->string('factor1',10)->nullable();
            $table->string('factor2',10)->nullable();
            $table->integer('factor3')->nullable();
            $table->integer('factor4')->nullable();
            $table->string('reference')->nullable();
            $table->string('currency',3)->default('PEN');
            $table->float('subtotal', 8, 2)->nullable();
            $table->float('igv', 8, 2)->nullable();
            $table->float('total', 8, 2)->nullable();
            //$table->foreign('technician_id')->nullable()->references('id')->on('users');
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->foreign('technician_id')->nullable()->references('id')->on('users');
            $table->dateTime('scheduled_date')->nullable();
            $table->integer('scheduled_minutes')->nullable();
            $table->dateTime('executed_date')->nullable();
            $table->integer('executed_minutes')->nullable();
            $table->text('observations')->nullable();
            $table->string('status')->default('new');
            $table->boolean('is_paid')->default(false);
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
        Schema::dropIfExists('quotes');
    }
};
