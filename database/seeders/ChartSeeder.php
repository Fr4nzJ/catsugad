<?php

namespace Database\Seeders;

use App\Models\Chart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chart::truncate();

        $charts = [
            [
                'name' => 'Student Enrollment by Gender',
                'type' => 'distribution',
                'labels' => json_encode(['Female', 'Male', 'Other']),
                'data' => json_encode([4500, 3800, 150]),
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Staff Distribution by College',
                'type' => 'distribution',
                'labels' => json_encode(['CAS', 'CBA', 'COEd', 'CHUMSS', 'COS']),
                'data' => json_encode([280, 220, 300, 150, 200]),
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Program Participation Trend',
                'type' => 'growth',
                'labels' => json_encode(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']),
                'data' => json_encode([450, 520, 580, 640, 720, 850]),
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Gender Composition - Faculty',
                'type' => 'distribution',
                'labels' => json_encode(['Women', 'Men']),
                'data' => json_encode([580, 650]),
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Accomplishment Reports by College',
                'type' => 'growth',
                'labels' => json_encode(['CAS', 'CBA', 'COEd', 'CHUMSS', 'COS', 'CIT']),
                'data' => json_encode([85, 72, 95, 48, 67, 60]),
                'order' => 5,
                'is_active' => false,
            ],
        ];

        foreach ($charts as $chart) {
            Chart::create($chart);
        }
    }
}
