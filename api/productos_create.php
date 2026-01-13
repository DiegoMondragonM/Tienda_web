<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../conexionBD/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit(json_encode(['ok'=>false,'error'=>'Método no permitido']));
}

$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio = (float)($_POST['precio'] ?? 0);
$existencias = (int)($_POST['existencias'] ?? 0);

if ($nombre==='' || $precio<=0) {
  http_response_code(400);
  exit(json_encode(['ok'=>false,'error'=>'Nombre y precio requeridos']));
}

$stmt = $pdo->prepare("INSERT INTO producto(nombre,descripcion,precio,existencias) VALUES(?,?,?,?)");
$stmt->execute([$nombre,$descripcion,$precio,$existencias]);

echo json_encode(['ok'=>true,'id'=>$pdo->lastInsertId()]);
