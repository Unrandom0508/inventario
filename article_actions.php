<?php
// article_actions.php
session_start();
require_once 'db.php';

// Debe haber sesión (cualquier usuario autenticado puede gestionar artículos)
if (!isset($_SESSION['user_cedula'])) {
    http_response_code(403);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');
$action = $_GET['action'] ?? 'list';

if ($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM articulos ORDER BY id DESC");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($input['nombre']) || !isset($input['unidades']) || empty($input['tipo']) || empty($input['bodega'])) {
        http_response_code(400);
        echo json_encode(['error'=>'Datos incompletos']);
        exit;
    }
    $stmt = $pdo->prepare("INSERT INTO articulos (nombre, unidades, tipo, bodega) VALUES (?, ?, ?, ?)");
    $stmt->execute([$input['nombre'], (int)$input['unidades'], $input['tipo'], $input['bodega']]);
    echo json_encode(['ok'=>true]);
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($input['id']) || empty($input['nombre']) || !isset($input['unidades']) || empty($input['tipo']) || empty($input['bodega'])) {
        http_response_code(400);
        echo json_encode(['error'=>'Datos incompletos']);
        exit;
    }
    $stmt = $pdo->prepare("UPDATE articulos SET nombre=?, unidades=?, tipo=?, bodega=? WHERE id=?");
    $stmt->execute([$input['nombre'], (int)$input['unidades'], $input['tipo'], $input['bodega'], (int)$input['id']]);
    echo json_encode(['ok'=>true]);
    exit;
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $input['id'] ?? null;
    if (!$id) { http_response_code(400); echo json_encode(['error'=>'id requerido']); exit; }
    $stmt = $pdo->prepare("DELETE FROM articulos WHERE id = ?");
    $stmt->execute([(int)$id]);
    echo json_encode(['ok'=>true]);
    exit;
}

http_response_code(400);
echo json_encode(['error'=>'Acción no soportada']);
