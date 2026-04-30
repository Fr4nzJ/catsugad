<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add college_id to programs table if it doesn't exist
        if (!Schema::hasColumn('programs', 'college_id')) {
            Schema::table('programs', function (Blueprint $table) {
                $table->unsignedBigInteger('college_id')->nullable()->after('id');
                $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('programs', 'college_id')) {
            Schema::table('programs', function (Blueprint $table) {
                $table->dropForeign(['college_id']);
                $table->dropColumn('college_id');
            });
        }
    }
};
