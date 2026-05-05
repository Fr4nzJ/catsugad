<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        // Only seed if table is empty
        if (Program::count() > 0) {
            return;
        }

        $programs = [
            [
                'program_name' => 'Gender Sensitivity Training',
                'description' => 'Comprehensive training program designed to enhance awareness about gender issues and promote inclusive attitudes in the workplace and community. Participants learn about gender stereotypes, unconscious bias, and strategies for creating gender-inclusive environments.',
                'target_beneficiaries' => 'Faculty, staff, and student leaders',
                'category' => 'Training & Capacity Building',
                'image_path' => 'images/programs/training.jpg',
            ],
            [
                'program_name' => 'Women Leadership Development',
                'description' => 'An intensive program aimed at developing leadership skills among women faculty and administrators. Through mentorship, workshops, and networking opportunities, participants are equipped to take on leadership roles and influence organizational policies.',
                'target_beneficiaries' => 'Women faculty and administrators',
                'category' => 'Leadership Development',
                'image_path' => 'images/programs/leadership.jpg',
            ],
            [
                'program_name' => 'Career Mentoring for Women Students',
                'description' => 'This program connects female students with successful professionals who provide guidance on career planning, skill development, and work-life balance. Mentors share their experiences and help mentees navigate challenges in their chosen fields.',
                'target_beneficiaries' => 'Female undergraduate and graduate students',
                'category' => 'Mentoring',
                'image_path' => null,
            ],
            [
                'program_name' => 'Anti-Gender-Based Violence Campaign',
                'description' => 'A comprehensive awareness and prevention campaign addressing gender-based violence in all its forms. The program includes workshops, community events, and support services for survivors, working towards a safer and more respectful community.',
                'target_beneficiaries' => 'All community members',
                'category' => 'Awareness & Prevention',
                'image_path' => null,
            ],
            [
                'program_name' => 'Girls in STEM Initiative',
                'description' => 'Focused on encouraging girls to pursue careers in Science, Technology, Engineering, and Mathematics. The program offers scholarships, workshops, internships, and role model mentoring to increase female representation in STEM fields.',
                'target_beneficiaries' => 'High school and college girls',
                'category' => 'Education & Empowerment',
                'image_path' => 'images/programs/stem.jpg',
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
