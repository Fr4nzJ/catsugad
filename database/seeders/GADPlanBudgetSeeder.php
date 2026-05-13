<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\GADPlanBudget;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GADPlanBudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GADPlanBudget::truncate();

        // Get existing colleges or create if none exist
        $colleges = College::take(3)->get();
        
        // If not enough colleges exist, create them
        if ($colleges->count() < 3) {
            $collegeNames = [
                ['name' => 'College of Arts and Sciences', 'abbreviation' => 'CAS'],
                ['name' => 'College of Business Administration', 'abbreviation' => 'CBA'],
                ['name' => 'College of Education', 'abbreviation' => 'COEd'],
            ];
            
            $colleges = collect();
            foreach ($collegeNames as $collegeData) {
                $college = College::where('name', $collegeData['name'])->first();
                if (!$college) {
                    $college = College::create($collegeData);
                }
                $colleges->push($college);
            }
        }

        // Ensure we have at least 3 colleges
        if ($colleges->count() < 3) {
            return;
        }

        $budgets = [
            [
                'college_id' => $colleges[0]->id,
                'title' => 'Women Leadership Development Program',
                'program_project' => 'Leadership training and mentorship for women faculty',
                'description' => 'A comprehensive program to develop leadership skills among women faculty members and prepare them for academic management positions.',
                'target_beneficiaries' => 'Women Faculty (50-60 participants)',
                'budget_amount' => 150000.00,
                'timeline' => '6 months (Jan-Jun 2026)',
                'status' => 'approved',
            ],
            [
                'college_id' => $colleges[1]->id,
                'title' => 'Gender-Sensitive Business Curriculum Enhancement',
                'program_project' => 'Integration of gender perspectives in business courses',
                'description' => 'Development and integration of gender-sensitive case studies and modules in business courses to promote inclusive business practices.',
                'target_beneficiaries' => 'Students (200+), Faculty (15)',
                'budget_amount' => 120000.00,
                'timeline' => '8 months (Mar-Oct 2026)',
                'status' => 'approved',
            ],
            [
                'college_id' => $colleges[2]->id,
                'title' => 'Teacher Education on Gender-Responsive Pedagogy',
                'program_project' => 'Training teachers on gender-responsive teaching methods',
                'description' => 'Workshop and training sessions to equip educators with gender-responsive teaching strategies and inclusive classroom management.',
                'target_beneficiaries' => 'Teachers (80-100 participants)',
                'budget_amount' => 180000.00,
                'timeline' => '4 months (Feb-May 2026)',
                'status' => 'submitted',
            ],
            [
                'college_id' => $colleges[0]->id,
                'title' => 'Women in STEM Mentorship Program',
                'program_project' => 'Promoting women in Science, Technology, Engineering, and Mathematics',
                'description' => 'Mentorship and networking program to encourage more women to pursue and excel in STEM fields.',
                'target_beneficiaries' => 'Female STEM students (50-75 participants)',
                'budget_amount' => 200000.00,
                'timeline' => '12 months (Jan-Dec 2026)',
                'status' => 'draft',
            ],
        ];

        foreach ($budgets as $budget) {
            GADPlanBudget::create($budget);
        }
    }
}
