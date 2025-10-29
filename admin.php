<?php
session_start();
if (!isset($_SESSION["cedula"]) || $_SESSION["cedula"] !== "1111") {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Administrador</title>
</head>
<body>
    <h2>Bienvenido Administrador</h2>
    <button onclick="location.href='usuarios.php'">Gestión de Usuarios</button>
    <button onclick="location.href='articulos.php'">Gestión de Artículos</button>
    <br><br>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
