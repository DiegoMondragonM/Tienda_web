<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require __DIR__ . '/../conexionBD/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok'=>false,'error'=>'Método no permitido']);
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$email = trim($data['email'] ?? '');
$pass  = (string)($data['password'] ?? '');

if ($email === '' || $pass === '') {
  http_response_code(400);
  echo json_encode(['ok'=>false,'error'=>'Email y password requeridos']);
  exit;
}

try {
  // OJO: tus nombres raros van entre backticks
  $stmt = $pdo->prepare("SELECT `id`, `nombre`, `apellido`, `email`, `password_hash`
                         FROM `clientes`
                         WHERE `email` = ?
                         LIMIT 1");
  $stmt->execute([$email]);
  $u = $stmt->fetch();

$ok = $u && (
  password_verify($pass, $u['password_hash']) ||
  hash_equals((string)$u['password_hash'], (string)$pass) // fallback texto plano
);

if (!$ok) {
  http_response_code(401);
  echo json_encode(['ok'=>false,'error'=>'Credenciales incorrectas']);
  exit;
}


  // Guardar sesión cliente
  $_SESSION['cliente_id'] = (int)$u['id'];
  $_SESSION['cliente_email'] = (string)$u['email'];
  $_SESSION['cliente_nombre'] = trim(($u['nombre'] ?? '') . ' ' . ($u['apellido'] ?? ''));

  echo json_encode([
    'ok'=>true,
    'cliente' => [
      'id' => (int)$u['id'],
      'nombre' => $_SESSION['cliente_nombre'],
      'email' => $_SESSION['cliente_email']
    ]
  ]);
  exit;

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
  exit;
}