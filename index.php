<?php
session_start();
if (!isset($_SESSION['user_cedula'])) {
    header("Location: login.php");
    exit;
}
$nombre = htmlspecialchars($_SESSION['user_nombre']);
$is_admin = $_SESSION['is_admin'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Inventario - Panel</title>
</head>
<body>
<h2>Bienvenido, <?= $nombre ?></h2>
<?php if ($is_admin): ?>
    <p>Eres admin — verás botones para Usuarios y Artículos.</p>
    <button onclick="location.href='users.php'">Gestión de Usuarios</button>
    <button onclick="location.href='articles.php'">Gestión de Artículos</button>
<?php else: ?>
    <p>Acceso limitado: solo gestión de artículos.</p>
    <button onclick="location.href='articles.php'">Gestión de Artículos</button>
<?php endif; ?>
<br><br>
<a href="logout.php">Cerrar sesión</a>
</body>
</html>
