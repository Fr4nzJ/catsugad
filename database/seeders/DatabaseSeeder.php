<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Only create test user if none exist
        if (User::count() === 0) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Run seeders for placeholder data
        $this->call([
            CollegeSeeder::class,
            EnrollmentSeeder::class,
            StaffSeeder::class,
            AnnouncementSeeder::class,
            ProgramSeeder::class,
            AccomplishmentReportSeeder::class,
            GadKpiSeeder::class,
            GADCoordinatorSeeder::class,
            GADAgendaSeeder::class,
            GADPlanBudgetSeeder::class,
            GfpsMembersSeeder::class,
            ChartSeeder::class,
            AboutMenuSeeder::class,
            AboutPageSeeder::class,
            MapMarkerSeeder::class,
        ]);
    }
}
