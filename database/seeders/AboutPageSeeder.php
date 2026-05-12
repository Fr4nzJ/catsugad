<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutPage::truncate();

        $sections = [
            [
                'section_name' => 'mission',
                'title' => 'Our Mission',
                'content' => 'The Gender and Development Services at Catanduanes State University is committed to promoting gender equality and fostering the development of all members of the university community. We work to create an inclusive environment where all individuals are valued and empowered to reach their full potential.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'section_name' => 'vision',
                'title' => 'Our Vision',
                'content' => 'A university community free from gender-based discrimination where every individual, regardless of gender, is provided equal opportunities for personal and professional growth.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'section_name' => 'values',
                'title' => 'Our Core Values',
                'content' => 'Equality, Inclusivity, Respect, Accountability, and Excellence guide our work in promoting gender and development initiatives across the university.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'section_name' => 'history',
                'title' => 'Our History',
                'content' => 'The Gender and Development Services was established to address gender-related concerns and promote sustainable development within the university. Since its inception, it has been dedicated to supporting students, faculty, and staff in their personal and professional development.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'section_name' => 'team',
                'title' => 'Our Team',
                'content' => 'Our dedicated team of professionals works tirelessly to ensure that gender and development initiatives are implemented effectively across all departments of the university.',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            AboutPage::create($section);
        }
    }
}

