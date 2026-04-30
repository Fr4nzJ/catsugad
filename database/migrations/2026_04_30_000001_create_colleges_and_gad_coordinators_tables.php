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
        // Create colleges table
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('abbreviation')->nullable();
            $table->timestamps();
        });

        // Create gad_coordinators table
        Schema::create('gad_coordinators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')
                  ->unique() // One coordinator per college
                  ->constrained('colleges')
                  ->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            // Index for queries
            $table->index('college_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gad_coordinators');
        Schema::dropIfExists('colleges');
    }
};
