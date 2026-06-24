<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\TaskStatus;
use App\Enums\TaskPriority;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status', TaskStatus::values())->default(TaskStatus::PENDING->value);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('priority', TaskPriority::values())->default(TaskPriority::LOW->value);
            $table->timestamps();

            // Relationships     
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            // Constraints

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
