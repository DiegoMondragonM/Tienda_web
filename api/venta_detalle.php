<?php
require __DIR__ . '/admin_guard_api.php';
require __DIR__ . '/../conexionBD/config.php';

$ventaID = (int)($_GET['ventaID'] ?? 0);
if ($ventaID <= 0) {
  http_response_code(400);
  echo json_encode(['ok'=>false,'error'=>'ventaID inválido']);
  exit;
}

try {
  // Cabecera venta
  $stmt = $pdo->prepare("
    SELECT ventaID, clienteID, fechaVenta, total, estado
    FROM ventas
    WHERE ventaID = ?
    LIMIT 1
  ");
  $stmt->execute([$ventaID]);
  $venta = $stmt->fetch();
  if (!$venta) {
    http_response_code(404);
    echo json_encode(['ok'=>false,'error'=>'Venta no encontrada']);
    exit;
  }

  // Detalles + nombre producto
  $stmt2 = $pdo->prepare("
    SELECT d.detalleID, d.productoID, p.nombre, d.cantidad, d.preciounitario, d.subtotal
    FROM detallesventa d
    LEFT JOIN producto p ON p.id = d.productoID
    WHERE d.ventaID = ?
    ORDER BY d.detalleID ASC
  ");
  $stmt2->execute([$ventaID]);
  $items = $stmt2->fetchAll();

  echo json_encode(['ok'=>true,'venta'=>$venta,'items'=>$items]);
  exit;

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
  exit;
}
