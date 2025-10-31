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
        Schema::table('sales', function (Blueprint $table) {
            $table->string('pickup_code', 50)->nullable()->unique()->after('customer_id');
            $table->enum('order_type', ['pos', 'online'])->default('pos')->after('pickup_code');
            $table->enum('order_status', ['pending', 'ready', 'completed', 'cancelled'])->nullable()->after('order_type');
            $table->timestamp('prepared_at')->nullable()->after('order_status');
            $table->timestamp('completed_at')->nullable()->after('prepared_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['pickup_code', 'order_type', 'order_status', 'prepared_at', 'completed_at']);
        });
    }
};
