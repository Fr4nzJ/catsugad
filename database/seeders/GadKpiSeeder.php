<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Statistic;

class GadKpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing statistics
        Statistic::truncate();

        $kpis = [
            [
                'value' => '156+',
                'label' => 'Gender & Development Programs',
                'description' => 'Programs and initiatives launched across all colleges in 2024',
                'icon' => 'fas fa-graduation-cap',
                'color' => 'blue',
            ],
            [
                'value' => '8,932',
                'label' => 'Women Participants',
                'description' => 'Female students and staff engaged in GAD activities',
                'icon' => 'fas fa-venus',
                'color' => 'pink',
            ],
            [
                'value' => '6,154',
                'label' => 'Men Participants',
                'description' => 'Male students and staff engaged in GAD initiatives',
                'icon' => 'fas fa-mars',
                'color' => 'indigo',
            ],
            [
                'value' => '87%',
                'label' => 'Institutional Coverage',
                'description' => 'Percentage of colleges with active GAD programs',
                'icon' => 'fas fa-chart-pie',
                'color' => 'green',
            ],
            [
                'value' => '234',
                'label' => 'Capacity Building Sessions',
                'description' => 'Training and awareness programs conducted in 2024',
                'icon' => 'fas fa-chalkboard-user',
                'color' => 'orange',
            ],
            [
                'value' => '45+',
                'label' => 'Policy Recommendations',
                'description' => 'Institutional policies developed or improved for gender equality',
                'icon' => 'fas fa-file-contract',
                'color' => 'purple',
            ],
            [
                'value' => '12',
                'label' => 'GAD Coordinators',
                'description' => 'Dedicated coordinators across colleges and units',
                'icon' => 'fas fa-users',
                'color' => 'cyan',
            ],
            [
                'value' => '92%',
                'label' => 'Satisfaction Rate',
                'description' => 'Participant satisfaction with GAD programs and services',
                'icon' => 'fas fa-thumbs-up',
                'color' => 'lime',
            ],
        ];

        foreach ($kpis as $kpi) {
            Statistic::create($kpi);
            $this->command->info("✓ Created KPI: {$kpi['label']}");
        }

        $this->command->info('✓ GAD KPI Statistics seeding completed!');
    }
}
