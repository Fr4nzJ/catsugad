<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Test the controller method
$controller = new \App\Http\Controllers\AccomplishmentReportController();

// Use reflection to access the private method
$method = new ReflectionMethod($controller, 'getStaffByOfficeAndGender');
$method->setAccessible(true);
$result = $method->invoke($controller);

echo "=== Staff by Office and Gender (from controller method) ===\n";
echo "Total offices returned: " . count($result) . "\n\n";

foreach ($result as $office => $data) {
    echo "$office: M=" . $data['Male'] . ", F=" . $data['Female'] . ", O=" . $data['Other'] . ", Total=" . $data['Total'] . "\n";
}
