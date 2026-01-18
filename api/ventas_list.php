<?php
require __DIR__ . '/admin_guard_api.php';
require __DIR__ . '/../conexionBD/config.php';

$estado = strtoupper(trim($_GET['estado'] ?? 'PENDIENTE'));

try {
  $stmt = $pdo->prepare("
    SELECT v.ventaID, v.clienteID, v.fechaVenta, v.total, v.estado
    FROM ventas v
    WHERE v.estado = ?
    ORDER BY v.ventaID DESC
  ");
  $stmt->execute([$estado]);
  $rows = $stmt->fetchAll();

  echo json_encode(['ok'=>true,'data'=>$rows]);
  exit;
} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
  exit;
}
