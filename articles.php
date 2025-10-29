<?php
// api/articles.php
session_start();
require __DIR__ . '/../inc/db.php';


$method = $_SERVER['REQUEST_METHOD'];


if ($method === 'GET') {
$stmt = $pdo->query('SELECT * FROM articulos ORDER BY id DESC');
$rows = $stmt->fetchAll();
echo json_encode($rows);
exit;
}


$input = json_decode(file_get_contents('php://input'), true);


if ($method === 'POST') {
// crear
if (!($input['nombre'] && isset($input['unidades']) && $input['tipo'] && $input['bodega'])) {
http_response_code(400);
echo json_encode(['error' => 'Datos incompletos']);
exit;
}
$stmt = $pdo->prepare('INSERT INTO articulos (nombre, unidades, tipo, bodega) VALUES (?,?,?,?)');
$stmt->execute([$input['nombre'], (int)$input['unidades'], $input['tipo'], $input['bodega']]);
echo json_encode(['ok' => true, 'id' => $pdo->lastInsertId()]);
exit;
}


if ($method === 'PUT') {
if (!($input['id'] && $input['nombre'] && isset($input['unidades']) && $input['tipo'] && $input['bodega'])) {
http_response_code(400);
echo json_encode(['error' => 'Datos incompletos']);
exit;
}
$stmt = $pdo->prepare('UPDATE articulos SET nombre = ?, unidades = ?, tipo = ?, bodega = ? WHERE id = ?');
$stmt->execute([$input['nombre'], (int)$input['unidades'], $input['tipo'], $input['bodega'], (int)$input['id']]);
echo json_encode(['ok' => true]);
exit;
}


if ($method === 'DELETE') {
// esperar JSON con id
if (!($input['id'])) { http_response_code(400); echo json_encode(['error'=>'No id']); exit; }
$stmt = $pdo->prepare('DELETE FROM articulos WHERE id = ?');
$stmt->execute([(int)$input['id']]);
echo json_encode(['ok' => true]);
exit;
}


http_response_code(405);