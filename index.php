<?php
// public/index.php
session_start();
if (isset($_SESSION['user'])) {
// si es admin redirige al dashboard admin
if ($_SESSION['user']['cedula'] === 'admin') header('Location: dashboard_admin.php');
else header('Location: dashboard_user.php');
exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login - Inventario</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<h2>Ingresar</h2>
<form id="loginForm">
<label>Cédula: <input name="cedula" required></label><br>
<label>Contraseña: <input name="password" type="password" required></label><br>
<button>Entrar</button>
</form>
<div id="msg"></div>
<script>
document.getElementById('loginForm').addEventListener('submit', async e => {
e.preventDefault();
const fd = new FormData(e.target);
const body = { cedula: fd.get('cedula'), password: fd.get('password') };
const res = await fetch('../api/auth.php', { method: 'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(body)});
const data = await res.json();
if (res.ok) {
if (data.cedula === 'admin') location.href = 'dashboard_admin.php';
else location.href = 'dashboard_user.php';
} else {
document.getElementById('msg').innerText = data.error || 'Error';
}
});
</script>
</body>
</html>