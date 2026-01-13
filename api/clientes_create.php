<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../conexionBD/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit(json_encode(['ok'=>false,'error'=>'Método no permitido']));
}

$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$domicilio = trim($_POST['domicilio'] ?? '');
$credito = $_POST['credito'] ?? 0;
$email = trim($_POST['email'] ?? '');
$pass = $_POST['password'] ?? '';

if ($nombre==='' || $apellido==='' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass)<6) {
  http_response_code(400);
  exit(json_encode(['ok'=>false,'error'=>'Datos inválidos']));
}

$stmt = $pdo->prepare("SELECT 1 FROM clientes WHERE email=?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
  http_response_code(409);
  exit(json_encode(['ok'=>false,'error'=>'Email ya registrado']));
}

$hash = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO clientes(nombre,apellido,domicilio,credito,email,password_hash,creado_en)
                       VALUES(?,?,?,?,?,?,NOW())");
$stmt->execute([$nombre,$apellido,$domicilio,$credito,$email,$hash]);

echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);
