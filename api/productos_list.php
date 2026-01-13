<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../conexionBD/config.php';

$stmt = $pdo->query("SELECT id, nombre, descripcion, precio, existencias
                     FROM producto
                     ORDER BY id DESC");
echo json_encode(['ok'=>true,'data'=>$stmt->fetchAll()]);
