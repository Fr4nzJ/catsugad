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
        Schema::table('announcements', function (Blueprint $table) {
            // Add slug if not exists
            if (!Schema::hasColumn('announcements', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('title');
            }
            
            // Add excerpt if not exists
            if (!Schema::hasColumn('announcements', 'excerpt')) {
                $table->text('excerpt')->nullable()->after('slug');
            }
            
            // Add status if not exists
            if (!Schema::hasColumn('announcements', 'status')) {
                $table->enum('status', ['draft', 'published'])->default('draft')->after('image_path');
            }
            
            // Update published_at to be nullable
            // No need to modify if already nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            if (Schema::hasColumn('announcements', 'slug')) {
                $table->dropUnique(['slug']);
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('announcements', 'excerpt')) {
                $table->dropColumn('excerpt');
            }
            if (Schema::hasColumn('announcements', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
