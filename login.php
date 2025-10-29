<?php
// login.php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'] ?? '';
    $pass = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT cedula, nombre, password FROM usuarios WHERE cedula = ?");
    $stmt->execute([$cedula]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['password'])) {
        // login ok
        $_SESSION['user_cedula'] = $user['cedula'];
        $_SESSION['user_nombre'] = $user['nombre'];
        // determinar si admin
        $_SESSION['is_admin'] = ($user['cedula'] === '1111') ? true : false;
        header("Location: index.php");
        exit;
    } else {
        $error = "Cédula o contraseña incorrecta.";
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login - Inventario</title>
</head>
<body>
<h2>Iniciar sesión</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post" action="login.php">
    <label>Cédula: <input type="text" name="cedula" required></label><br><br>
    <label>Contraseña: <input type="password" name="password" required></label><br><br>
    <button type="submit">Entrar</button>
</form>
</body>
</html>
