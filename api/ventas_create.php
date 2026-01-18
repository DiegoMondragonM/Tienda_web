<?php
header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/../conexionBD/config.php';
require __DIR__ . '/client_guard_api.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit(json_encode(['ok'=>false,'error'=>'Método no permitido']));
}

$data = json_decode(file_get_contents('php://input'), true);

$items = $data['items'] ?? [];
$clienteID = (int)$_SESSION['cliente_id'];

if (!is_array($items) || count($items) === 0) {
  http_response_code(400);
  exit(json_encode(['ok'=>false,'error'=>'Carrito vacío']));
}

try {
  $pdo->beginTransaction();

  // 1) Calcular total desde los items
  $total = 0;
  foreach ($items as $it) {
    $precio = (float)($it['precio'] ?? 0);
    $cant   = (int)($it['cantidad'] ?? 0);
    if ($cant <= 0 || $precio < 0) {
      throw new Exception("Item inválido");
    }
    $total += $precio * $cant;
  }

  // 2) Insertar venta (fechaVenta puede tener DEFAULT en la BD; si no, la ponemos)
  $stmtVenta = $pdo->prepare("INSERT INTO ventas (clienteID, fechaVenta, total) VALUES (?, NOW(), ?)");
  $stmtVenta->execute([$clienteID, $total]);

  $ventaID = (int)$pdo->lastInsertId();

  // 3) Insertar detalles (incluyendo subtotal)
  $stmtDet = $pdo->prepare(
    "INSERT INTO detallesventa (ventaID, productoID, cantidad, preciounitario, subtotal)
     VALUES (?, ?, ?, ?, ?)"
  );

  foreach ($items as $it) {
    $productoID = (int)$it['productoID'];
    $cantidad = (int)$it['cantidad'];
    $precio = (float)$it['precio'];
    $subtotal = $cantidad * $precio;

    $stmtDet->execute([$ventaID, $productoID, $cantidad, $precio, $subtotal]);
  }

  $pdo->commit();

  echo json_encode([
    'ok' => true,
    'ventaID' => $ventaID,
    'total' => (float)$total
  ]);
  exit;

} catch (Throwable $e) {
  if ($pdo->inTransaction()) $pdo->rollBack();
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);
  exit;
}
