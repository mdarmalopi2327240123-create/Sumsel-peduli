<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Running Database Seeder...</h1>";

try {
    // 1. Register autoload
    require __DIR__.'/../vendor/autoload.php';

    // 2. Bootstrap Laravel
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // 3. Resolve Console Kernel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    // 4. Run Artisan Command
    $output = new \Symfony\Component\Console\Output\BufferedOutput;
    
    echo "<p>Running: php artisan migrate --force</p>";
    $statusMigration = $kernel->call('migrate', ['--force' => true], $output);
    echo "<p>Migration Status Code: " . $statusMigration . "</p>";
    
    echo "<p>Running: php artisan db:seed --force</p>";
    $statusSeeder = $kernel->call('db:seed', ['--force' => true], $output);
    echo "<p>Seeder Status Code: " . $statusSeeder . "</p>";

    echo "<h2>Output:</h2>";
    echo "<pre>" . htmlspecialchars($output->fetch()) . "</pre>";

} catch (\Throwable $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
