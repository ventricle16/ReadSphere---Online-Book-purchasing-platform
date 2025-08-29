<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
   public function up(): void
   {
       Schema::table('books', function (Blueprint $table) {
           $table->string('genre')->nullable();
           $table->text('description')->nullable();
           $table->string('seo_tags')->nullable();
           $table->string('file_path')->nullable();
           $table->string('file_type')->nullable(); // pdf/epub
           $table->integer('file_size')->nullable(); // in bytes
           $table->boolean('is_featured')->default(false);
           $table->boolean('is_active')->default(true);
       });
   }


   public function down(): void
   {
       Schema::table('books', function (Blueprint $table) {
           $table->dropColumn(['genre', 'description', 'seo_tags', 'file_path', 'file_type', 'file_size', 'is_featured', 'is_active']);
       });
   }
};

