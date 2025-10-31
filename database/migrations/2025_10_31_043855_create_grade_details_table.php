<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_system_id')->constrained()->onDelete('cascade');
            $table->string('grade_name'); // e.g., "A+", "B", "Pass"
            $table->float('mark_from'); // e.g., 90
            $table->float('mark_to');   // e.g., 100
            $table->string('comments')->nullable(); // e.g., "Excellent", "Good"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_details');
    }
};
