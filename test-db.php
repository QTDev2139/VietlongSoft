<?php
header('Content-Type: text/plain; charset=utf-8');

$server  = getenv('DB_SERVER') ?: '127.0.0.1';
$port    = getenv('DB_PORT') ?: '1433';
$db      = getenv('DB_DATABASE') ?: 'master';
$user    = getenv('DB_USERNAME') ?: 'sa';
$pass    = getenv('DB_PASSWORD') ?: '';
$encrypt = strtolower(getenv('DB_ENCRYPT') ?: 'yes');
$trust   = strtolower(getenv('DB_TRUST_CERT') ?: 'yes');

$dsn = "sqlsrv:Server=$server,$port;Database=$db;Encrypt=" . ($encrypt==='yes'?'Yes':'No') .
       ";TrustServerCertificate=" . ($trust==='yes'?'Yes':'No');

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8,
    ]);
    echo "✅ Connected successfully\n";
    $stmt = $pdo->query("SELECT @@VERSION AS v");
    echo "SQL Server version: " . $stmt->fetch(PDO::FETCH_ASSOC)['v'];
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
