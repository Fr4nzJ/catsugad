<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('accomplishment_reports', function (Blueprint $table) {
            $table->string('college')->nullable()->after('year');
            $table->enum('gender', ['male', 'female'])->nullable()->after('college');
            $table->integer('participants_count')->default(0)->after('gender');
        });
    }

    public function down()
    {
        Schema::table('accomplishment_reports', function (Blueprint $table) {
            $table->dropColumn(['college', 'gender', 'participants_count']);
        });
    }
};
