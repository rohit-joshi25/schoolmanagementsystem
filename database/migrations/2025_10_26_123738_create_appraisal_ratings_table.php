<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appraisal_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_appraisal_id')->constrained()->onDelete('cascade');
            $table->foreignId('performance_category_id')->constrained()->onDelete('cascade');
            $table->integer('rating'); // e.g., a score from 1 to 5
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appraisal_ratings');
    }
};