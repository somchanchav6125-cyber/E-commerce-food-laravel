<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Location type (phnom_penh or province)
            $table->string('location_type')->nullable()->after('shipping_address');

            // For Phnom Penh
            $table->string('district')->nullable()->after('location_type');
            $table->string('street')->nullable()->after('district');
            $table->string('house_number')->nullable()->after('street');

            // For other provinces
            $table->string('village')->nullable()->after('house_number');
            $table->string('city')->nullable()->after('village');
            $table->string('province')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['location_type', 'district', 'street', 'house_number', 'village', 'city', 'province']);
        });
    }
};
