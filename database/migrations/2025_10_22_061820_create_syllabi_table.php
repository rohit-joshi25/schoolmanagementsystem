<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('syllabi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            // Optional: Link to a specific class if syllabus varies by class
            // $table->foreignId('academic_class_id')->nullable()->constrained()->onDelete('set null'); 
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); // Store path to uploaded syllabus file
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('syllabi');
    }
};