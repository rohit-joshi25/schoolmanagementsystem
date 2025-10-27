<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "Sibling Discount", "Late Fee"
            $table->enum('type', ['discount', 'fine']);
            $table->decimal('amount', 10, 2);
            $table->boolean('is_percentage')->default(false); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_adjustments');
    }
};