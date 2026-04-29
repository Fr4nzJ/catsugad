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
        Schema::create('gad_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('lgu_name');
            $table->integer('fiscal_year');
            $table->enum('status', ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected'])->default('Draft');
            $table->text('remarks')->nullable();
            $table->string('document_path')->nullable();
            $table->string('document_original_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gad_submissions');
    }
};
