<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MariaDB compatibility, we need to use raw SQL to rename the column
        DB::statement('ALTER TABLE orders CHANGE amount total_amount DECIMAL(10, 2)');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For MariaDB compatibility, we need to use raw SQL to rename the column back
        DB::statement('ALTER TABLE orders CHANGE total_amount amount DECIMAL(10, 2)');
    }
};
