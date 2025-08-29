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
        Schema::table('carts', function (Blueprint $table) {
            $table->string('discount_code')->nullable()->after('item_count');
            $table->decimal('discount_percent', 5, 2)->default(0)->after('discount_code');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('discount_percent');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn(['discount_code', 'discount_percent', 'discount_amount']);
        });
    }
};



