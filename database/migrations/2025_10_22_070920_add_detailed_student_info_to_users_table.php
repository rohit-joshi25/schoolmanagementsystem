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
            // Adding new student detail columns after 'section_id'
            $table->string('admission_no')->nullable()->after('section_id');
            $table->string('roll_number')->nullable()->after('admission_no');
            $table->string('first_name')->after('name'); // Add first_name
            $table->string('last_name')->nullable()->after('first_name'); // Add last_name
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable()->after('last_name');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->string('category')->nullable()->after('date_of_birth');
            $table->string('religion')->nullable()->after('category');
            $table->string('caste')->nullable()->after('religion');
            $table->string('mobile_number')->nullable()->after('caste');
            $table->date('admission_date')->nullable()->after('mobile_number');
            $table->string('student_photo_path')->nullable()->after('admission_date');
            $table->string('blood_group')->nullable()->after('student_photo_path');
            $table->string('house')->nullable()->after('blood_group');
            $table->string('height')->nullable()->after('house');
            $table->string('weight')->nullable()->after('height');
            $table->date('measurement_date')->nullable()->after('weight');
            $table->text('medical_history')->nullable()->after('measurement_date');

            // We will also rename the 'name' column to 'full_name' for clarity
            $table->renameColumn('name', 'full_name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'admission_no', 'roll_number', 'first_name', 'last_name', 'gender', 
                'date_of_birth', 'category', 'religion', 'caste', 'mobile_number', 
                'admission_date', 'student_photo_path', 'blood_group', 'house', 
                'height', 'weight', 'measurement_date', 'medical_history'
            ]);
            $table->renameColumn('full_name', 'name');
        });
    }
    
};
