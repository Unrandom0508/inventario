<?php
session_start();
if (!isset($_SESSION["cedula"])) {
    header("Location: index.php");
    exit();
}
require "db.php";
$articulos = $conexion->query("SELECT * FROM articulos");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Artículos</title>
</head>
<body>
    <h2>Gestión de Artículos</h2>
    <a href="agregar_articulo.php">➕ Agregar Artículo</a> |
    <a href="logout.php">Cerrar sesión</a>
    <br><br>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Unidades</th>
            <th>Tipo</th>
            <th>Bodega</th>
            <th>Acciones</th>
        </tr>
        <?php while($fila = $articulos->fetch_assoc()): ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= $fila['nombre'] ?></td>
            <td><?= $fila['unidades'] ?></td>
            <td><?= $fila['tipo'] ?></td>
            <td><?= $fila['bodega'] ?></td>
            <td>
                <a href="editar_articulo.php?id=<?= $fila['id'] ?>">Editar</a> |
                <a href="eliminar_articulo.php?id=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar este artículo?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
