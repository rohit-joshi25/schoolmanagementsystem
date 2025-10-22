<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The teacher's ID
            $table->timestamps();

            // Prevent assigning the same teacher to the same subject multiple times
            $table->unique(['subject_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_teacher');
    }
};