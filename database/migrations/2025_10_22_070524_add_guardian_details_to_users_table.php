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
            // Add new columns for guardian details after 'section_id'
            $table->string('guardian_name')->nullable()->after('section_id');
            $table->string('guardian_relation')->nullable()->after('guardian_name');
            $table->string('guardian_phone')->nullable()->after('guardian_relation');
            $table->string('guardian_email')->nullable()->after('guardian_phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['guardian_name', 'guardian_relation', 'guardian_phone', 'guardian_email']);
        });
    }
};
