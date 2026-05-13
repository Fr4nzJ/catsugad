<?php

namespace Database\Seeders;

use App\Models\GADAgenda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GADAgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GADAgenda::truncate();

        $agendas = [
            [
                'agenda_title' => 'Women Empowerment Program',
                'organization' => 'Gender and Development Services',
                'start_year' => 2023,
                'end_year' => 2026,
                'objectives' => 'Promote economic independence and leadership skills among women in the university community',
                'strategies' => 'Conduct training programs, mentoring sessions, and skills development workshops',
                'status' => 'Active',
            ],
            [
                'agenda_title' => 'Gender Sensitivity and Advocacy Campaign',
                'organization' => 'Gender and Development Services',
                'start_year' => 2024,
                'end_year' => 2026,
                'objectives' => 'Increase awareness about gender equality and eliminate gender-based discrimination',
                'strategies' => 'Educational seminars, awareness campaigns, and community engagements',
                'status' => 'Active',
            ],
            [
                'agenda_title' => 'Support for Gender-Based Violence Survivors',
                'organization' => 'Gender and Development Services',
                'start_year' => 2023,
                'end_year' => 2026,
                'objectives' => 'Provide counseling and support services to survivors of gender-based violence',
                'strategies' => 'Hotline services, counseling programs, and referral networks',
                'status' => 'Active',
            ],
            [
                'agenda_title' => 'Inclusive Education and Scholarship Program',
                'organization' => 'Gender and Development Services',
                'start_year' => 2024,
                'end_year' => 2027,
                'objectives' => 'Ensure equal access to education for marginalized and disadvantaged students',
                'strategies' => 'Scholarship grants, mentoring support, and accessibility services',
                'status' => 'Active',
            ],
            [
                'agenda_title' => 'Work-Life Balance Initiatives',
                'organization' => 'Gender and Development Services',
                'start_year' => 2025,
                'end_year' => 2027,
                'objectives' => 'Promote work-life balance and flexible work arrangements for faculty and staff',
                'strategies' => 'Policy advocacy, wellness programs, and flexible scheduling pilot projects',
                'status' => 'Active',
            ],
        ];

        foreach ($agendas as $agenda) {
            GADAgenda::create($agenda);
        }
    }
}
