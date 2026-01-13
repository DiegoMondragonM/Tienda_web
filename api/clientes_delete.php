<?php
require __DIR__ . '/../conexionBD/config.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: /clientes.php?err=1"); exit; }

$stmt = $pdo->prepare("DELETE FROM clientes WHERE id=?");
$stmt->execute([$id]);

header("Location: /clientes.php?del=1");
exit;
