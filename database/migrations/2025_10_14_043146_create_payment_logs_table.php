<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->string('payment_gateway'); // e.g., 'Manual', 'Stripe'
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['pending', 'success', 'failed']);
            $table->text('notes')->nullable(); // For any extra details
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_logs');
    }
};
