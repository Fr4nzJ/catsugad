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
        // Add columns to about_pages table
        Schema::table('about_pages', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('about_pages', 'section_name')) {
                $table->string('section_name')->after('id')->nullable();
            }
            if (!Schema::hasColumn('about_pages', 'title')) {
                $table->string('title')->after('section_name')->nullable();
            }
            if (!Schema::hasColumn('about_pages', 'content')) {
                $table->longText('content')->after('title')->nullable();
            }
            if (!Schema::hasColumn('about_pages', 'order')) {
                $table->integer('order')->after('content')->default(0);
            }
            if (!Schema::hasColumn('about_pages', 'is_active')) {
                $table->boolean('is_active')->after('order')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_pages', function (Blueprint $table) {
            if (Schema::hasColumn('about_pages', 'section_name')) {
                $table->dropColumn('section_name');
            }
            if (Schema::hasColumn('about_pages', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('about_pages', 'content')) {
                $table->dropColumn('content');
            }
            if (Schema::hasColumn('about_pages', 'order')) {
                $table->dropColumn('order');
            }
            if (Schema::hasColumn('about_pages', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
