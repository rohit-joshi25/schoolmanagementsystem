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
            // Add the school_id column after the 'id' column
            // It's nullable because the Super Admin doesn't belong to any single school
            $table->foreignId('school_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // This will safely drop the column and its foreign key constraint
            $table->dropForeign(['school_id']);
            $table->dropColumn('school_id');
        });
    }
};
