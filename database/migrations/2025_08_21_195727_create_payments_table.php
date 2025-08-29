<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('provider')->default('stripe'); // stripe
            $table->string('status')->default('requires_payment'); // requires_payment, processing, succeeded, failed
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 5)->default('usd');
            $table->string('stripe_payment_intent')->nullable();
            $table->string('stripe_payment_method')->nullable(); // card, bkash, etc.
            $table->json('raw_response')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('payments');
    }
};