<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('academic_class_id')->constrained()->onDelete('cascade');
            $table->foreignId('fee_type_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_allocations');
    }
};