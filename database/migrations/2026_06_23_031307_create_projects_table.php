<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ProjectPriority;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('type')->default('saas')->comment('saas, web, mobile, desktop, other');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('deadline')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'on_hold', 'cancelled', 'completed'])->default('pending');
            $table->text('description')->nullable();
            $table->enum('priority', ProjectPriority::values())->default(ProjectPriority::MEDIUM->value);
            $table->integer('progress_percentage')->default(0);
            $table->timestamps();


            // Relationships
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
