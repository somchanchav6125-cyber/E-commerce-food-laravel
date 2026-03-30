<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('payment_method')->default('qr');
            $table->string('payment_token')->unique();
            $table->text('payment_qr')->nullable();
            $table->string('payment_md5')->nullable();
            $table->string('payment_status')->default('pending')->nullable();
            $table->decimal('total', 10, 2);
            $table->boolean('paid')->default(false);
            $table->string('status')->default('pending');

            // Shipping info
            $table->string('shipping_name')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_address')->nullable();

            // Location (Phnom Penh)
            $table->string('location_type')->nullable();
            $table->string('district')->nullable();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();

            // Location (Province)
            $table->string('village')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
