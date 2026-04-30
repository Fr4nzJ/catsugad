<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StudentStatistic;
use App\Models\EmployeeStatistic;
use App\Models\College;
use App\Models\Program;

class StatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all colleges
        $colleges = College::all();
        
        // Get all programs
        $programs = Program::all();

        // Only proceed if there are colleges
        if ($colleges->isEmpty()) {
            $this->command->warn('No colleges found. Skipping student statistics seeding.');
        } else {
            // Seed Student Statistics
            foreach ($colleges as $college) {
                // College-level statistics
                StudentStatistic::create([
                    'college_id' => $college->id,
                    'program_id' => null,
                    'male_count' => rand(50, 150),
                    'female_count' => rand(60, 180),
                    'academic_year' => 2024,
                ]);

                // Program-level statistics for this college
                if (!$programs->isEmpty()) {
                    $collegePrograms = $programs->random(min(3, $programs->count()));
                    foreach ($collegePrograms as $program) {
                        StudentStatistic::create([
                            'college_id' => $college->id,
                            'program_id' => $program->id,
                            'male_count' => rand(20, 80),
                            'female_count' => rand(25, 90),
                            'academic_year' => 2024,
                        ]);
                    }
                }
            }

            $this->command->info('Student statistics seeded successfully!');
        }

        // Seed Employee Statistics
        $departments = ['Administrative Services', 'Academic Affairs', 'Finance', 'Student Services', 'Research & Extension'];
        
        // University-wide employee statistics
        EmployeeStatistic::create([
            'department' => 'University-Wide',
            'college_id' => null,
            'male_count' => 120,
            'female_count' => 130,
        ]);

        // Department-specific statistics
        foreach ($departments as $department) {
            $collegeId = $colleges->isNotEmpty() ? $colleges->random()->id : null;
            EmployeeStatistic::create([
                'department' => $department,
                'college_id' => $collegeId,
                'male_count' => rand(15, 50),
                'female_count' => rand(15, 50),
            ]);
        }

        $this->command->info('Employee statistics seeded successfully!');
    }
}
