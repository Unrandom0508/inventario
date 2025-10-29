<?php
require "db.php";
$id = $_GET["id"];
$conexion->query("DELETE FROM articulos WHERE id=$id");
header("Location: articulos.php");
?>
