<?php
require "db.php";
$id = $_GET["id"];
$articulo = $conexion->query("SELECT * FROM articulos WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $unidades = $_POST["unidades"];
    $tipo = $_POST["tipo"];
    $bodega = $_POST["bodega"];
    $conexion->query("UPDATE articulos SET nombre='$nombre', unidades='$unidades', tipo='$tipo', bodega='$bodega' WHERE id=$id");
    header("Location: articulos.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Editar Artículo</title></head>
<body>
<h2>Editar Artículo</h2>
<form method="POST">
    Nombre: <input type="text" name="nombre" value="<?= $articulo['nombre'] ?>"><br><br>
    Unidades: <input type="number" name="unidades" value="<?= $articulo['unidades'] ?>"><br><br>
    Tipo:
    <select name="tipo">
        <option <?= $articulo['tipo']=='PC'?'selected':'' ?>>PC</option>
        <option <?= $articulo['tipo']=='teclado'?'selected':'' ?>>teclado</option>
        <option <?= $articulo['tipo']=='disco duro'?'selected':'' ?>>disco duro</option>
        <option <?= $articulo['tipo']=='mouse'?'selected':'' ?>>mouse</option>
    </select><br><br>
    Bodega:
    <select name="bodega">
        <option <?= $articulo['bodega']=='norte'?'selected':'' ?>>norte</option>
        <option <?= $articulo['bodega']=='sur'?'selected':'' ?>>sur</option>
        <option <?= $articulo['bodega']=='oriente'?'selected':'' ?>>oriente</option>
        <option <?= $articulo['bodega']=='occidente'?'selected':'' ?>>occidente</option>
    </select><br><br>
    <button type="submit">Actualizar</button>
</form>
</body>
</html>
