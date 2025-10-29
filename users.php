<?php
// api/users.php
session_start();
require __DIR__ . '/../inc/db.php';


// Solo usuarios autenticados pueden usar (en este ejemplo permitimos listar/crear si se llegó aquí tras login)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
$stmt = $pdo->query('SELECT cedula, nombre FROM usuarios ORDER BY nombre');
$rows = $stmt->fetchAll();
echo json_encode($rows);
exit;
}


$input = json_decode(file_get_contents('php://input'), true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// crear
if (!($input['cedula'] && $input['nombre'] && $input['password'])) {
http_response_code(400);
echo json_encode(['error' => 'Datos incompletos']);
exit;
}
$hash = password_hash($input['password'], PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO usuarios (cedula, nombre, password) VALUES (?,?,?)');
try {
$stmt->execute([$input['cedula'], $input['nombre'], $hash]);
echo json_encode(['ok' => true]);
} catch (PDOException $e) {
http_response_code(500);
echo json_encode(['error' => $e->getMessage()]);
}
exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
// modificar usuario (cedula clave para identificar)
if (!($input['cedula'] && $input['nombre'])) {
http_response_code(400);
echo json_encode(['error' => 'Datos incompletos']);
exit;
}
if (!empty($input['password'])) {
$hash = password_hash($input['password'], PASSWORD_DEFAULT);
$stmt = $pdo->prepare('UPDATE usuarios SET nombre = ?, password = ? WHERE cedula = ?');
$stmt->execute([$input['nombre'], $hash, $input['cedula']]);
} else {
$stmt = $pdo->prepare('UPDATE usuarios SET nombre = ? WHERE cedula = ?');
$stmt->execute([$input['nombre'], $input['cedula']]);
}
echo json_encode(['ok' => true]);
exit;
}


http_response_code(405);