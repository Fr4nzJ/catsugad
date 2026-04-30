<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\College;
use App\Models\Enrollment;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = '2025-2026';
        $semester = 'Second Semester';

        // Data to insert - college-level enrollments
        $enrollmentData = [
            [
                'name' => 'Advanced Education',
                'male' => 166,
                'female' => 295,
            ],
            [
                'name' => 'College of Law',
                'male' => 26,
                'female' => 26,
            ],
            [
                'name' => 'College of Science',
                'male' => 330,
                'female' => 775,
            ],
            [
                'name' => 'College of Humanities and Social Sciences',
                'male' => 233,
                'female' => 363,
            ],
            [
                'name' => 'College of Education',
                'male' => 351,
                'female' => 895,
            ],
            [
                'name' => 'College of Business and Accountancy',
                'male' => 494,
                'female' => 1512,
            ],
            [
                'name' => 'College of Agriculture and Fisheries',
                'male' => 560,
                'female' => 519,
            ],
            [
                'name' => 'College of Engineering and Architecture',
                'male' => 775,
                'female' => 558,
            ],
            [
                'name' => 'College of Information and Communications Technology',
                'male' => 974,
                'female' => 733,
            ],
            [
                'name' => 'College of Health Sciences',
                'male' => 261,
                'female' => 1197,
            ],
            [
                'name' => 'College of Industrial Technology',
                'male' => 2151,
                'female' => 707,
            ],
            [
                'name' => 'Panganiban Campus',
                'male' => 305,
                'female' => 354,
            ],
        ];

        foreach ($enrollmentData as $data) {
            // Find or create the college (prevents duplicate entry errors)
            $college = College::firstOrCreate(
                ['name' => $data['name']],
                ['abbreviation' => $this->generateAbbreviation($data['name'])]
            );

            $this->command->info("College available: {$data['name']}");

            // Calculate totals
            $total = $data['male'] + $data['female'];

            // Check if enrollment already exists (to prevent duplicates)
            $existingEnrollment = Enrollment::where('college_id', $college->id)
                ->where('academic_year', $academicYear)
                ->where('semester', $semester)
                ->whereNull('program_id')
                ->first();

            if (!$existingEnrollment) {
                // Create enrollment record
                Enrollment::create([
                    'college_id' => $college->id,
                    'program_id' => null, // College-level data
                    'academic_year' => $academicYear,
                    'semester' => $semester,
                    'male_count' => $data['male'],
                    'female_count' => $data['female'],
                    'total_count' => $total,
                ]);

                $this->command->info("✓ Enrollment created for {$data['name']}: M={$data['male']}, F={$data['female']}, Total={$total}");
            } else {
                $this->command->warn("⚠ Enrollment already exists for {$data['name']} in {$academicYear} {$semester}");
            }
        }

        $this->command->info("\n✓ Enrollment data seeding completed!");
        $this->command->info("Academic Year: {$academicYear}");
        $this->command->info("Semester: {$semester}");
    }

    /**
     * Generate abbreviation from college name
     */
    private function generateAbbreviation(string $name): string
    {
        // Extract first letters from each word, max 10 characters
        $words = explode(' ', $name);
        $abbreviation = '';

        foreach ($words as $word) {
            if (strlen($abbreviation) < 10) {
                $abbreviation .= strtoupper(substr($word, 0, 1));
            }
        }

        return $abbreviation;
    }
}
