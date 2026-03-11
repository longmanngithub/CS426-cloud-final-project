<?php

// This migration has been consolidated into 2024_01_01_000001_create_all_tables.php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // remember_token columns are now in the base create_all_tables migration
    }

    public function down(): void
    {
        // no-op
    }
};
