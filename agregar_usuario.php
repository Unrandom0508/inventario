<?php
require "db.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula = $_POST["cedula"];
    $nombre = $_POST["nombre"];
    $contrasena = $_POST["contrasena"];
    $conexion->query("INSERT INTO usuarios VALUES ('$cedula','$nombre','$contrasena')");
    header("Location: usuarios.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Agregar Usuario</title></head>
<body>
<h2>Agregar Usuario</h2>
<form method="POST">
    Cédula: <input type="text" name="cedula" required><br><br>
    Nombre: <input type="text" name="nombre" required><br><br>
    Contraseña: <input type="password" name="contrasena" required><br><br>
    <button type="submit">Guardar</button>
</form>
</body>
</html>
