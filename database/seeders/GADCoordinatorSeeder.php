<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GADCoordinator;
use App\Models\College;

class GADCoordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing coordinators
        GADCoordinator::truncate();

        // Define the GAD Coordinators with their full college names
        $coordinators = [
            ['name' => 'Vincent T. Bernal Jr.', 'college' => 'College of Information and Communications Technology'],
            ['name' => 'Dr. Maria Isabel L. De La Hostria', 'college' => 'College of Business and Accountancy'],
            ['name' => 'Edmarie S. Buerano', 'college' => 'College of Industrial Technology'],
            ['name' => 'Berna Marie G. Bautista', 'college' => 'College of Education'],
            ['name' => 'Charlene S. Uchi', 'college' => 'College of Health Sciences'],
            ['name' => 'Engr. Mekaela Louise B. Taroy', 'college' => 'College of Engineering and Architecture'],
            ['name' => 'Fe M. Valledor', 'college' => 'College of Agriculture and Fisheries'],
            ['name' => 'Crismelia Ann P. Aviles', 'college' => 'College of Humanities and Social Sciences'],
            ['name' => 'Maribel T. Ralla', 'college' => 'College of Sciences'],
            ['name' => 'Engr. Maria Johanna U. Socito', 'college' => 'Panganiban Campus'],
        ];

        // Create coordinators and associate with colleges
        foreach ($coordinators as $coordinatorData) {
            // Find or create the college by full name
            $college = College::where('name', $coordinatorData['college'])->first();

            // If college doesn't exist, create it
            if (!$college) {
                $college = College::create([
                    'name' => $coordinatorData['college'],
                    'abbreviation' => $this->getAbbreviation($coordinatorData['college']),
                    'campus' => 'Main Campus',
                    'category' => 'higher_education',
                ]);
            }

            // Create the coordinator
            GADCoordinator::create([
                'college_id' => $college->id,
                'name' => $coordinatorData['name'],
                'email' => null,
                'contact_number' => null,
                'photo' => null,
            ]);
        }

        $this->command->info('GAD Coordinators seeded successfully! ' . count($coordinators) . ' coordinators created.');
    }

    /**
     * Get abbreviation from college name
     */
    private function getAbbreviation($collegeName)
    {
        $abbreviations = [
            'College of Information and Communications Technology' => 'CICT',
            'College of Business and Accountancy' => 'CBA',
            'College of Industrial Technology' => 'CIT',
            'College of Education' => 'COED',
            'College of Health Sciences' => 'CHS',
            'College of Engineering and Architecture' => 'CEA',
            'College of Agriculture and Fisheries' => 'CAF',
            'College of Humanities and Social Sciences' => 'CHUMSS',
            'College of Sciences' => 'COS',
            'Panganiban Campus' => 'Panganiban Campus',
        ];

        return $abbreviations[$collegeName] ?? $collegeName;
    }
}

