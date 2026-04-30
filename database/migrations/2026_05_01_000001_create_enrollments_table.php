<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('college_id');
            $table->unsignedBigInteger('program_id')->nullable();
            $table->string('academic_year'); // e.g., "2025-2026"
            $table->string('semester'); // e.g., "First Semester", "Second Semester"
            $table->integer('male_count')->default(0);
            $table->integer('female_count')->default(0);
            $table->integer('total_count')->default(0);
            $table->timestamps();

            // Foreign Keys
            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('set null');

            // Unique constraint to prevent duplicates
            $table->unique(['college_id', 'program_id', 'academic_year', 'semester'], 'unique_enrollment');

            // Indexes for performance
            $table->index('college_id');
            $table->index('program_id');
            $table->index(['academic_year', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
