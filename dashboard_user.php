<?php
session_start();
if (!isset($_SESSION['user'])) header('Location: index.php');
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Dashboard Usuario</title></head>
<body>
<h2>Bienvenido, <?=htmlspecialchars($_SESSION['user']['nombre'])?></h2>
<button onclick="location.href='articles.php'">Gestionar Artículos</button>
<button onclick="location.href='logout.php'">Cerrar sesión</button>
</body>
</html>