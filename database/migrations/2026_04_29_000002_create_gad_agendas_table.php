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
        Schema::create('gad_agendas', function (Blueprint $table) {
            $table->id();
            $table->string('agenda_title');
            $table->string('organization');
            $table->integer('start_year')->default(2026);
            $table->integer('end_year')->default(2031);
            $table->text('objectives');
            $table->text('strategies');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gad_agendas');
    }
};
