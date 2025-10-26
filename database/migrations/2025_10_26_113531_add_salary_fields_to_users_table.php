<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('salary_grade_id')->nullable()->after('section_id')->constrained()->onDelete('set null');
            $table->decimal('basic_salary', 10, 2)->nullable()->after('salary_grade_id'); // Stores salary, e.g., 50000.00
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['salary_grade_id']);
            $table->dropColumn('salary_grade_id');
            $table->dropColumn('basic_salary');
        });
    }
};
