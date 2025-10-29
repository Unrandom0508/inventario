<?php
// api/auth.php
session_start();
require __DIR__ . '/../inc/db.php';


$input = json_decode(file_get_contents('php://input'), true);
$cedula = $input['cedula'] ?? null;
$password = $input['password'] ?? null;


if (!$cedula || !$password) {
http_response_code(400);
echo json_encode(['error' => 'Credenciales incompletas']);
exit;
}


$stmt = $pdo->prepare('SELECT cedula, nombre, password FROM usuarios WHERE cedula = ?');
$stmt->execute([$cedula]);
$user = $stmt->fetch();


if (!$user) {
http_response_code(401);
echo json_encode(['error' => 'Usuario no encontrado']);
exit;
}


// Aquí usamos sha1 por compatibilidad con el SQL de ejemplo. Si guardas con password_hash, usa password_verify.
if ($user['password'] === sha1($password) || password_verify($password, $user['password'])) {
$_SESSION['user'] = ['cedula' => $user['cedula'], 'nombre' => $user['nombre']];
echo json_encode(['ok' => true, 'cedula' => $user['cedula'], 'nombre' => $user['nombre']]);
} else {
http_response_code(401);
echo json_encode(['error' => 'Contraseña incorrecta']);