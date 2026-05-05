<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            // Add hierarchy columns if they don't exist
            if (!Schema::hasColumn('colleges', 'campus')) {
                $table->string('campus')->default('Main Campus')->after('name');
            }
            
            if (!Schema::hasColumn('colleges', 'category')) {
                $table->enum('category', ['higher_education', 'advanced_education'])->default('higher_education')->after('campus');
            }

            // Add index for better query performance
            $table->index(['campus', 'category']);
        });
    }

    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->dropIndex(['campus', 'category']);
            if (Schema::hasColumn('colleges', 'campus')) {
                $table->dropColumn('campus');
            }
            if (Schema::hasColumn('colleges', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
