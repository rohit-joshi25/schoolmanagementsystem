<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The Student who owes
            $table->foreignId('book_issue_id')->constrained()->onDelete('cascade'); // The overdue book
            $table->integer('days_overdue');
            $table->decimal('fine_rate', 10, 2); // The fine amount per day
            $table->decimal('total_amount', 10, 2); // days_overdue * fine_rate
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_fines');
    }
};
