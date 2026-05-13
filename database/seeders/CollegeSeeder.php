<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get unique colleges from accomplishment reports
        $colleges = DB::table('accomplishment_reports')
            ->distinct()
            ->whereNotNull('college')
            ->where('college', '!=', '')
            ->pluck('college')
            ->sort()
            ->values();

        foreach ($colleges as $collegeName) {
            // Use findOrCreateByName to avoid duplicate key errors
            College::findOrCreateByName($collegeName);
        }

        $this->command->info('Colleges seeded successfully!');
    }
}
