<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../conexionBD/config.php';

$stmt = $pdo->query("SELECT id AS id, nombre, apellido, domicilio, credito, email AS email, creado_en
                     FROM clientes
                     ORDER BY id DESC");
echo json_encode(['ok'=>true, 'data'=>$stmt->fetchAll()]);
