session_start();
if (!isset($_SESSION['user'])) header('Location: index.php');
if ($_SESSION['user']['cedula'] !== 'admin') header('Location: dashboard_user.php');
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Dashboard</title></head>
<body>
<h2>Bienvenido, <?=htmlspecialchars($_SESSION['user']['nombre'])?></h2>
<button onclick="location.href='users.php'">Gestionar Usuarios</button>
<button onclick="location.href='articles.php'">Gestionar Artículos</button>
<button onclick="location.href='logout.php'">Cerrar sesión</button>
</body>
</html>