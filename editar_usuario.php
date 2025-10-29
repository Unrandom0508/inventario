<?php
require "db.php";
$cedula = $_GET["cedula"];
$usuario = $conexion->query("SELECT * FROM usuarios WHERE cedula='$cedula'")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $contrasena = $_POST["contrasena"];
    $conexion->query("UPDATE usuarios SET nombre='$nombre', contrasena='$contrasena' WHERE cedula='$cedula'");
    header("Location: usuarios.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Editar Usuario</title></head>
<body>
<h2>Editar Usuario</h2>
<form method="POST">
    Nombre: <input type="text" name="nombre" value="<?= $usuario['nombre'] ?>"><br><br>
    Contraseña: <input type="text" name="contrasena" value="<?= $usuario['contrasena'] ?>"><br><br>
    <button type="submit">Actualizar</button>
</form>
</body>
</html>
