<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

$host = getenv('DB_HOST');
$db   = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$port = getenv('DB_PORT') ?: '3306';
$conn_type = getenv('DB_CONNECTION') ?: 'mysql';

echo "<ul>";
echo "<li><strong>Connection:</strong> " . htmlspecialchars($conn_type) . "</li>";
echo "<li><strong>Host:</strong> " . htmlspecialchars($host) . "</li>";
echo "<li><strong>Port:</strong> " . htmlspecialchars($port) . "</li>";
echo "<li><strong>Database:</strong> " . htmlspecialchars($db) . "</li>";
echo "<li><strong>Username:</strong> " . htmlspecialchars($user) . "</li>";
echo "</ul>";

if (!$host || !$db || !$user) {
    echo "<p style='color: red;'><strong>Error:</strong> Some environment variables are missing! Make sure DB_HOST, DB_DATABASE, and DB_USERNAME are set in Vercel.</p>";
    exit;
}

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    echo "<p>Attempting to connect to database...</p>";
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<p style='color: green;'><strong>Success!</strong> Successfully connected to the database.</p>";
    
    // Try to run a simple query
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<p><strong>Tables in database:</strong> " . implode(', ', $tables) . "</p>";

    echo "<h3>Table Row Counts:</h3><ul>";
    foreach (['users', 'campaigns', 'categories', 'donations', 'campaign_updates'] as $table) {
        if (in_array($table, $tables)) {
            $countStmt = $pdo->query("SELECT COUNT(*) FROM `$table`");
            $count = $countStmt->fetchColumn();
            echo "<li><strong>$table:</strong> $count rows</li>";
        } else {
            echo "<li style='color: red;'><strong>$table:</strong> table not found</li>";
        }
    }
    echo "</ul>";

} catch (\PDOException $e) {
    echo "<p style='color: red;'><strong>Database Connection Failed:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Error Code: " . htmlspecialchars($e->getCode()) . "</p>";
}

if (isset($_GET['migrate']) || isset($_GET['seed'])) {
    try {
        require_once __DIR__.'/../vendor/autoload.php';
        $app = require __DIR__.'/../bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    } catch (\Throwable $e) {
        echo "<p style='color: red;'><strong>Laravel Bootstrap Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        exit;
    }
}

if (isset($_GET['migrate']) && $_GET['migrate'] === 'true') {
    echo "<h2>Running Database Migration...</h2>";
    try {
        $output = new \Symfony\Component\Console\Output\BufferedOutput;
        
        echo "<p>Running: php artisan migrate --force</p>";
        $status = $kernel->call('migrate', ['--force' => true], $output);
        
        echo "<p>Status Code: " . $status . "</p>";
        echo "<h2>Output:</h2>";
        echo "<pre>" . htmlspecialchars($output->fetch()) . "</pre>";
    } catch (\Throwable $e) {
        echo "<p style='color: red;'><strong>Migration Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
}

if (isset($_GET['seed']) && $_GET['seed'] === 'true') {
    echo "<h2>Running Database Seeder...</h2>";
    try {
        $output = new \Symfony\Component\Console\Output\BufferedOutput;
        
        echo "<p>Running: php artisan db:seed --force</p>";
        $status = $kernel->call('db:seed', ['--force' => true], $output);
        
        echo "<p>Status Code: " . $status . "</p>";
        echo "<h2>Output:</h2>";
        echo "<pre>" . htmlspecialchars($output->fetch()) . "</pre>";
    } catch (\Throwable $e) {
        echo "<p style='color: red;'><strong>Seeder Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
}

echo "<h2>Database Actions</h2>";
echo "<ul>";
echo "<li><a href='?migrate=true'>Jalankan Migration (php artisan migrate --force)</a></li>";
echo "<li><a href='?seed=true'>Jalankan Seeder (php artisan db:seed --force)</a></li>";
echo "<li><a href='?migrate=true&seed=true'>Jalankan Migration & Seeder Sekaligus</a></li>";
echo "</ul>";
