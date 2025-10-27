<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The Student
            $table->foreignId('student_fee_id')->constrained()->onDelete('cascade'); // The master invoice
            $table->decimal('amount', 10, 2);
            $table->string('payment_method'); // e.g., 'Cash', 'Card', 'Online'
            $table->text('notes')->nullable();
            $table->date('payment_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_payment_logs');
    }
};