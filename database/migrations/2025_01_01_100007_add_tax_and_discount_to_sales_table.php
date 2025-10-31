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
            $table->decimal('subtotal', 15, 2)->after('total_amount')->default(0);
            $table->decimal('tax_amount', 15, 2)->after('subtotal')->default(0);
            $table->decimal('discount_amount', 15, 2)->after('tax_amount')->default(0);
            $table->foreignId('promotion_id')->nullable()->after('discount_amount')->constrained()->onDelete('set null');
            $table->decimal('cash_paid', 15, 2)->after('promotion_id')->nullable();
            $table->decimal('change_amount', 15, 2)->after('cash_paid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);
            $table->dropColumn([
                'subtotal',
                'tax_amount',
                'discount_amount',
                'promotion_id',
                'cash_paid',
                'change_amount'
            ]);
        });
    }
};
