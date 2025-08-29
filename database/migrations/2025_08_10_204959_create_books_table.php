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
       Schema::create('books', function (Blueprint $table) {
           $table->id(); // This creates unsigned BIGINT
           $table->string('title');
           $table->string('author')->nullable();
           $table->string('cover_url')->nullable();   // external or /storage path
           $table->decimal('price', 8, 2)->nullable();
           $table->timestamps();
       });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
