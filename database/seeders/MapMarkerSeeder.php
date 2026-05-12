<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MapMarker;

class MapMarkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing markers
        MapMarker::truncate();

        // Create initial marker for Faculty Center, CatSU
        MapMarker::create([
            'name' => 'Faculty Center - CatSU',
            'latitude' => 13.5936,
            'longitude' => 124.3615,
            'description' => 'GAD Office - Gender and Development Services',
            'page' => 'contact',
            'is_active' => true,
        ]);
    }
}

