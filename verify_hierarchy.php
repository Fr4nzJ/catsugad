<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

use App\Models\College;

echo "=== COLLEGE HIERARCHY VERIFICATION ===\n\n";

$colleges = College::select('id', 'name', 'campus', 'category')->orderBy('campus')->orderBy('name')->get();

foreach ($colleges as $college) {
    echo sprintf(
        "[%d] %-45s | Campus: %-20s | Category: %s\n",
        $college->id,
        $college->name,
        $college->campus,
        $college->category
    );
}

echo "\n=== SUMMARY ===\n";
echo "Total colleges: " . $colleges->count() . "\n";
echo "Main Campus colleges: " . $colleges->where('campus', 'Main Campus')->count() . "\n";
echo "Panganiban Campus colleges: " . $colleges->where('campus', 'Panganiban Campus')->count() . "\n";
echo "Higher Education: " . $colleges->where('category', 'higher_education')->count() . "\n";
echo "Advanced Education: " . $colleges->where('category', 'advanced_education')->count() . "\n";
?>
