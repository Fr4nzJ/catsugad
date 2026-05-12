<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$staff = \App\Models\Staff::all();
echo "Total Staff Records: " . count($staff) . "\n\n";

// Get all distinct offices
$offices = $staff->pluck('office')->unique()->sort()->values();
echo "=== Distinct Offices in Database ===\n";
foreach ($offices as $office) {
    $count = \App\Models\Staff::where('office', $office)->count();
    echo "- {$office}: {$count} staff\n";
}

echo "\n=== Gender Breakdown by Office ===\n";
foreach ($offices as $office) {
    $male = \App\Models\Staff::where('office', $office)->where('gender', 'Male')->count();
    $female = \App\Models\Staff::where('office', $office)->where('gender', 'Female')->count();
    $other = \App\Models\Staff::where('office', $office)->where('gender', 'Other')->count();
    $total = $male + $female + $other;
    echo "$office: M=$male, F=$female, O=$other, Total=$total\n";
}
