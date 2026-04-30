<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('gad_plan_budgets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('college_id');
            $table->string('program_project');
            $table->text('description')->nullable();
            $table->string('target_beneficiaries')->nullable();
            $table->decimal('budget_amount', 15, 2);
            $table->string('timeline')->nullable();
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->timestamps();
            
            // Foreign key
            $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
            
            // Indexes
            $table->index('college_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gad_plan_budgets');
    }
};
