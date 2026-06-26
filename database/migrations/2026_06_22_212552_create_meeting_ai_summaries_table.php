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
        Schema::create('meeting_ai_summaries', function (Blueprint $table) {
            $table->id();

            // ربط الملخص بالاجتماع بتاعه (كل اجتماع ليه ملخص ذكاء اصطناعي واحد أو أكتر)
            $table->foreignId('meeting_id')->constrained()->onDelete('cascade');

        // النص العام للملخص (AI Summary)
            $table->text('summary')->nullable();

        // النقط الأساسية (Key Points) هنيخزنها بنوع json عشان تشيل Array من النقط
            $table->json('key_points')->nullable();

        // القرارات المتخذة (Decisions Made) بردو بتخزن كـ Array في الـ json
            $table->json('decisions')->nullable();

        // المهام المطلوبة (Action Items) 
            $table->json('action_items')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_ai_summaries');
    }
};
