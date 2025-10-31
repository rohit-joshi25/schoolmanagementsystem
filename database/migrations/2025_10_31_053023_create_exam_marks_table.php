<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_class_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // The Student

            $table->decimal('total_marks', 8, 2)->default(100);
            $table->decimal('marks_obtained', 8, 2)->default(0);
            $table->text('comments')->nullable();

            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['exam_id', 'subject_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_marks');
    }
};
