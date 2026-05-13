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
        Schema::create('gfps_members', function (Blueprint $table) {
            $table->id();
            $table->string('section');           // e.g. "Top Level", "Members Level", "Technical Working Group"
            $table->integer('sort_order');       // controls display order within section
            $table->string('gfps_position');     // e.g. "SUC President"
            $table->string('gfps_role');         // e.g. "Head of Agency", "Chair", "Member", "Focal Person"
            $table->string('name')->nullable();  // null = vacant
            $table->string('designation')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('is_vacant')->default(false);
            $table->timestamps();

            // Add indexes for better query performance
            $table->index('section');
            $table->index('is_vacant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gfps_members');
    }
};
