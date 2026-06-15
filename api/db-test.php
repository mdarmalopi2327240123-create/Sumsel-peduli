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

} catch (\PDOException $e) {
    echo "<p style='color: red;'><strong>Database Connection Failed:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Error Code: " . htmlspecialchars($e->getCode()) . "</p>";
}
