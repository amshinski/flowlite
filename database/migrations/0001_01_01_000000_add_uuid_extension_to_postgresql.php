<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddUuidExtensionToPostgresql extends Migration
{
    public function up(): void {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
    }

    public function down(): void {
        DB::statement('DROP EXTENSION IF EXISTS "uuid-ossp";');
    }
}
