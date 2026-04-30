<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Enrollment;
use App\Helpers\EnrollmentAggregator;

class VerifyEnrollments extends Command
{
    protected $signature = 'enrollment:verify';
    protected $description = 'Verify enrollment data';

    public function handle()
    {
        $this->info('=== ENROLLMENT DATA VERIFICATION ===');
        $this->newLine();

        $this->info('Total Enrollments: ' . Enrollment::count());
        $this->info('Total Students: ' . Enrollment::sum('total_count'));
        $this->info('Total Males: ' . Enrollment::sum('male_count'));
        $this->info('Total Females: ' . Enrollment::sum('female_count'));
        $this->newLine();

        $this->info('=== BY COLLEGE ===');
        $enrollments = Enrollment::collegeLevelOnly()->with('college')->orderBy('total_count', 'desc')->get();
        
        foreach ($enrollments as $enrollment) {
            $this->line(
                $enrollment->college->name . ': ' .
                'M=' . $enrollment->male_count . ', ' .
                'F=' . $enrollment->female_count . ', ' .
                'Total=' . $enrollment->total_count
            );
        }
        $this->newLine();

        $this->info('=== UNIVERSITY-WIDE STATS ===');
        $stats = EnrollmentAggregator::getUniversityStats('2025-2026', 'Second Semester');
        $this->line('Total Males: ' . $stats['total_male']);
        $this->line('Total Females: ' . $stats['total_female']);
        $this->line('Total Students: ' . $stats['total_students']);
        $this->line('Male %: ' . $stats['male_percentage'] . '%');
        $this->line('Female %: ' . $stats['female_percentage'] . '%');
        $this->line('Colleges: ' . $stats['colleges_count']);
        $this->newLine();

        $this->info('✓ Verification complete!');
    }
}
