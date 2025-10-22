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
            // Add these columns after 'branch_id'. They are nullable.
            $table->foreignId('academic_class_id')->nullable()->after('branch_id')->constrained()->onDelete('set null');
            $table->foreignId('section_id')->nullable()->after('academic_class_id')->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['academic_class_id']);
            $table->dropColumn('academic_class_id');
            $table->dropForeign(['section_id']);
            $table->dropColumn('section_id');
        });
    }
};
