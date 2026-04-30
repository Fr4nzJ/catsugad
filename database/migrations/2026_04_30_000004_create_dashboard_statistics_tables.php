<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Students aggregated data by program and college
        Schema::create('student_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('college_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->integer('male_count')->default(0);
            $table->integer('female_count')->default(0);
            $table->integer('academic_year')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            
            // Indexes
            $table->index(['college_id', 'program_id']);
        });
        
        // Employee data
        Schema::create('employee_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('department')->nullable();
            $table->unsignedBigInteger('college_id')->nullable();
            $table->integer('male_count')->default(0);
            $table->integer('female_count')->default(0);
            $table->timestamps();
            
            // Foreign key
            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
            
            // Index
            $table->index('college_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_statistics');
        Schema::dropIfExists('employee_statistics');
    }
};
