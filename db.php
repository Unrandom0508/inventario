<?php
// db.php
$DB_HOST = 'mysql-flaw.alwaysdata.net';
$DB_NAME = 'flaw_inventario';
$DB_USER = 'flaw';
$DB_PASS = 'misifu123+'; // cambia si tu MySQL usa contraseña

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    // Si la BD no existe, decirlo al setup
    die("DB connection failed: " . $e->getMessage());
}
