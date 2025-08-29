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
    Schema::create('booklist', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('author');
        $table->year('publication_year')->nullable();
        $table->decimal('price', 8, 2)->nullable();
        $table->text('description')->nullable();
        $table->string('cover_image')->nullable();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booklist');
    }
};
