<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require __DIR__ . '/../conexionBD/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit(json_encode(['ok'=>false,'error'=>'Método no permitido']));
}

$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';

if ($usuario === '' || $password === '') {
  http_response_code(400);
  exit(json_encode(['ok'=>false,'error'=>'Faltan datos']));
}

$stmt = $pdo->prepare("SELECT id, password_hash FROM admins WHERE usuario = ? LIMIT 1");
$stmt->execute([$usuario]);
$admin = $stmt->fetch();

if (!$admin || !password_verify($password, $admin['password_hash'])) {
  http_response_code(401);
  exit(json_encode(['ok'=>false,'error'=>'Usuario o contraseña incorrectos']));
}

$_SESSION['admin_id'] = (int)$admin['id'];
$_SESSION['admin_user'] = $usuario;

echo json_encode(['ok'=>true]);
