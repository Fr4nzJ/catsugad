<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run()
    {
        if (Staff::count() > 0) {
            return; // Skip if data already exists
        }

        $offices = [
            'Office of the President',
            'Office of the Vice President for Academic Affairs',
            'Office of the Vice President for Administration and Finance',
            'Office of the Vice President for Research, Development and Extension',
            'Gender and Development Office',
            'Student Services',
            'Library Services',
            'Information Technology Services',
            'Human Resources',
            'Finance Office',
        ];

        $genders = ['Male', 'Female', 'Other'];

        $totalStaff = 0;

        foreach ($offices as $office) {
            // Generate 5-15 staff per office
            $staffCount = rand(5, 15);

            for ($i = 0; $i < $staffCount; $i++) {
                $gender = $genders[array_rand($genders)];
                $firstName = $this->getFirstName($gender);
                $lastName = $this->getLastName();
                $position = $this->getPosition();

                Staff::create([
                    'name' => $firstName . ' ' . $lastName,
                    'position' => $position,
                    'office' => $office,
                    'gender' => $gender,
                ]);

                $totalStaff++;
            }
        }

        $this->command->info("Staff data seeded successfully! Total staff: $totalStaff");
    }

    private function getFirstName($gender): string
    {
        if ($gender === 'Male') {
            $names = ['Juan', 'Mark', 'Antonio', 'Ramon', 'Carlos', 'Jose', 'Luis', 'Miguel', 'Pedro', 'Roberto'];
        } elseif ($gender === 'Female') {
            $names = ['Maria', 'Ana', 'Rosa', 'Carmen', 'Julia', 'Isabel', 'Sofia', 'Elena', 'Lucia', 'Patricia'];
        } else {
            $names = ['Alex', 'Jordan', 'Taylor', 'Morgan', 'Casey', 'Riley', 'Quinn', 'Avery', 'Blake', 'Sage'];
        }

        return $names[array_rand($names)];
    }

    private function getLastName(): string
    {
        $names = [
            'Santos', 'Garcia', 'Reyes', 'Morales', 'Fernandez', 'Villanueva',
            'Mendoza', 'Flores', 'Aquino', 'Diaz', 'Castro', 'Lopez', 'Martinez',
            'Ramos', 'Torres', 'Gutierrez', 'Perez', 'Valdez', 'Guzman', 'Montoya'
        ];

        return $names[array_rand($names)];
    }

    private function getPosition(): string
    {
        $positions = [
            'Director',
            'Assistant Director',
            'Coordinator',
            'Administrator',
            'Officer I',
            'Officer II',
            'Officer III',
            'Clerk',
            'Administrative Assistant',
            'Records Officer',
            'Data Entry Specialist',
            'Accountant',
            'Librarian',
            'IT Support Specialist',
            'Maintenance Staff',
            'Security Officer',
            'Counselor',
            'Program Officer',
            'Finance Manager',
            'Research Assistant',
        ];

        return $positions[array_rand($positions)];
    }
}
