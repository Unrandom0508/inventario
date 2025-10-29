<?php
require "db.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $unidades = $_POST["unidades"];
    $tipo = $_POST["tipo"];
    $bodega = $_POST["bodega"];

    $conexion->query("INSERT INTO articulos (nombre, unidades, tipo, bodega) VALUES ('$nombre','$unidades','$tipo','$bodega')");
    header("Location: articulos.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Agregar Artículo</title></head>
<body>
<h2>Agregar Artículo</h2>
<form method="POST">
    Nombre: <input type="text" name="nombre" required><br><br>
    Unidades: <input type="number" name="unidades" required><br><br>
    Tipo:
    <select name="tipo">
        <option>PC</option>
        <option>teclado</option>
        <option>disco duro</option>
        <option>mouse</option>
    </select><br><br>
    Bodega:
    <select name="bodega">
        <option>norte</option>
        <option>sur</option>
        <option>oriente</option>
        <option>occidente</option>
    </select><br><br>
    <button type="submit">Guardar</button>
</form>
</body>
</html>
