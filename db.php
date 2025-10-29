<?php
// inc/db.php
$host = 'mysql-flaw.alwaysdata.net';
$db = 'flaw_inventario';
$user = 'flaw';
$pass = 'misifu123+';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false,
];


try {
$pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
http_response_code(500);
echo "Error de conexión: " . $e->getMessage();
exit;
}