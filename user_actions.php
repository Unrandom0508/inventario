<?php
// user_actions.php
session_start();
require_once 'db.php';

// Solo admin puede crear/editar usuarios y listar (según reglas del enunciado
// el listado y edicion de usuarios solo debe estar disponible al admin que es 1111)
if (!isset($_SESSION['user_cedula']) || $_SESSION['user_cedula'] !== '1111') {
    http_response_code(403);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');

$action = $_GET['action'] ?? 'list';

if ($action === 'list') {
    $stmt = $pdo->query("SELECT cedula, nombre, created_at FROM usuarios ORDER BY nombre");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
    exit;
}

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data['cedula']) || empty($data['nombre']) || empty($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Datos incompletos']);
        exit;
    }
    $hash = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (cedula, nombre, password) VALUES (?, ?, ?)");
    try {
        $stmt->execute([$data['cedula'], $data['nombre'], $hash]);
        echo json_encode(['ok' => true]);
    } catch (PDOException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data['cedula']) || empty($data['nombre'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Datos incompletos']);
        exit;
    }
    if (!empty($data['password'])) {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, password = ? WHERE cedula = ?");
        $stmt->execute([$data['nombre'], $hash, $data['cedula']]);
    } else {
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ? WHERE cedula = ?");
        $stmt->execute([$data['nombre'], $data['cedula']]);
    }
    echo json_encode(['ok' => true]);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Acción no soportada']);
