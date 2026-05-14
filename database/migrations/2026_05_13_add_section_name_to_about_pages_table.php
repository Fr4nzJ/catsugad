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
        if (!Schema::hasColumn('about_pages', 'section_name')) {
            Schema::table('about_pages', function (Blueprint $table) {
                $table->string('section_name')->after('id')->default('');
                $table->string('title')->after('section_name')->default('');
                $table->longText('content')->after('title')->default('');
                $table->integer('order')->after('content')->default(0);
                $table->boolean('is_active')->after('order')->default(true);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('about_pages', 'section_name')) {
            Schema::table('about_pages', function (Blueprint $table) {
                $table->dropColumn(['section_name', 'title', 'content', 'order', 'is_active']);
            });
        }
    }
};
