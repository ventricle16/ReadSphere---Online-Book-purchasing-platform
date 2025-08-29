<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
   public function up(): void
   {
       Schema::table('books', function (Blueprint $table) {
           $table->string('preview_file_path')->nullable();
           $table->integer('preview_pages')->default(2);
       });
   }


   public function down(): void
   {
       Schema::table('books', function (Blueprint $table) {
           $table->dropColumn(['preview_file_path', 'preview_pages']);
       });
   }
};


