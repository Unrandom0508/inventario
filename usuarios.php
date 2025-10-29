<?php
session_start();
if (!isset($_SESSION["cedula"]) || $_SESSION["cedula"] !== "1111") {
    header("Location: index.php");
    exit();
}
require "db.php";
$usuarios = $conexion->query("SELECT * FROM usuarios");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Usuarios</title>
</head>
<body>
    <h2>Gestión de Usuarios</h2>
    <a href="agregar_usuario.php">➕ Agregar Usuario</a> |
    <a href="admin.php">Volver</a> |
    <a href="logout.php">Cerrar sesión</a>
    <br><br>
    <table border="1" cellpadding="5">
        <tr><th>Cédula</th><th>Nombre</th><th>Contraseña</th><th>Acciones</th></tr>
        <?php while($u = $usuarios->fetch_assoc()): ?>
        <tr>
            <td><?= $u['cedula'] ?></td>
            <td><?= $u['nombre'] ?></td>
            <td><?= $u['contrasena'] ?></td>
            <td><a href="editar_usuario.php?cedula=<?= $u['cedula'] ?>">Editar</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
