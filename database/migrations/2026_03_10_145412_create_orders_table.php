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
    $table->string('payment_method')->default('qr'); // qr, cash, card
    $table->string('payment_token')->unique(); // token for QR payment
    $table->decimal('total', 10, 2);
    $table->boolean('paid')->default(false);
    $table->string('status')->default('pending'); // pending, completed
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
