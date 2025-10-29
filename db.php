<?php
$conexion = new mysqli("localhost:mysql-flaw.alwaysdata.net", "flaw", "", "flaw_inventario", "password:misifu123+");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
