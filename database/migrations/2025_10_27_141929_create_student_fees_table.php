<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The Student
            $table->foreignId('fee_allocation_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2); // The total amount for this fee
            $table->decimal('amount_paid', 10, 2)->default(0.00);
            $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->date('due_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_fees');
    }
};