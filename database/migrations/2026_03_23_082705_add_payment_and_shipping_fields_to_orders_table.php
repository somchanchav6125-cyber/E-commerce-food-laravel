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
            if (!Schema::hasColumn('orders', 'payment_qr')) {
                $table->text('payment_qr')->nullable()->after('payment_token');
            }
            if (!Schema::hasColumn('orders', 'payment_md5')) {
                $table->string('payment_md5')->nullable()->after('payment_qr');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_qr')) {
                $table->dropColumn('payment_qr');
            }
            if (Schema::hasColumn('orders', 'payment_md5')) {
                $table->dropColumn('payment_md5');
            }
        });
    }
};
