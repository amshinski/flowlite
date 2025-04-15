<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('uuid_generate_v4()'))->primary();
            $table->foreignUuid('team_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('creator_id')->constrained('users')->noActionOnDelete();
            $table->string('name');
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['planned', 'in_work', 'testing', 'finished'])->default('planned');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->boolean('is_archived')->default(false);
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('is_archived');

            $table->unique(['name', 'team_id']);
        });

        DB::statement("ALTER TABLE tasks ADD CONSTRAINT tasks_name_check CHECK (name ~ '^[A-Za-z0-9\\-\\./]+$')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
