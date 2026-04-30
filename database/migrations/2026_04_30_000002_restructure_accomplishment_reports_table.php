<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Check if columns already exist to avoid errors on re-runs
        if (!Schema::hasColumn('accomplishment_reports', 'college_id')) {
            Schema::table('accomplishment_reports', function (Blueprint $table) {
                $table->unsignedBigInteger('college_id')->nullable()->after('year');
                $table->unsignedBigInteger('program_id')->nullable()->after('college_id');
                $table->integer('male_count')->default(0)->after('content');
                $table->integer('female_count')->default(0)->after('male_count');
                $table->date('date_conducted')->nullable()->after('female_count');
                $table->text('activity_description')->nullable()->after('date_conducted');
                
                // Foreign keys
                $table->foreign('college_id')->references('id')->on('colleges')->onDelete('cascade');
                $table->foreign('program_id')->references('id')->on('programs')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('accomplishment_reports', 'college_id')) {
            Schema::table('accomplishment_reports', function (Blueprint $table) {
                $table->dropForeign(['college_id']);
                $table->dropForeign(['program_id']);
                $table->dropColumn(['college_id', 'program_id', 'male_count', 'female_count', 'date_conducted']);
            });
        }
    }
};
