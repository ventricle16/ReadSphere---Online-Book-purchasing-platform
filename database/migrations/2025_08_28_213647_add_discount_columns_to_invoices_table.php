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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('discount_code')->nullable()->after('total_amount');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('discount_code');
            $table->string('payment_method')->nullable()->after('discount_amount');
            $table->text('shipping_address')->nullable()->after('payment_method');
            $table->text('billing_address')->nullable()->after('shipping_address');
            $table->string('status')->default('pending')->after('billing_address');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'discount_code',
                'discount_amount',
                'payment_method',
                'shipping_address',
                'billing_address',
                'status'
            ]);
        });
    }
};



