<?php
// setup.php - ejecutar una vez desde navegador o CLI para crear la DB y tablas
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Crear DB
    $pdo->exec("CREATE DATABASE IF NOT EXISTS inventario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Base de datos creada o ya existe.<br>";

    // Usar DB
    $pdo->exec("USE inventario_db");

    // Crear tabla usuarios
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        cedula VARCHAR(50) PRIMARY KEY,
        nombre VARCHAR(150) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Crear tabla articulos
    $pdo->exec("CREATE TABLE IF NOT EXISTS articulos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) NOT NULL,
        unidades INT NOT NULL DEFAULT 0,
        tipo ENUM('PC','teclado','disco duro','mouse') NOT NULL,
        bodega ENUM('norte','sur','oriente','occidente') NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    echo "Tablas creadas o ya existían.<br>";

    // Insertar usuario admin (cedula 1111, contraseña 1234)
    $cedula = '1111';
    $nombre = 'Administrador';
    $password_plain = '1234';
    $hash = password_hash($password_plain, PASSWORD_DEFAULT);

    // comprobar si existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE cedula = ?");
    $stmt->execute([$cedula]);
    if ($stmt->fetchColumn() == 0) {
        $ins = $pdo->prepare("INSERT INTO usuarios (cedula, nombre, password) VALUES (?, ?, ?)");
        $ins->execute([$cedula, $nombre, $hash]);
        echo "Usuario admin insertado (cédula 1111 / contraseña 1234).<br>";
    } else {
        echo "Usuario admin ya existe.<br>";
    }

    echo "<br>Setup completado. Borra o protege setup.php después de usarlo.";
} catch (PDOException $e) {
    die("Error en setup: " . $e->getMessage());
}
