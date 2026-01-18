<?php require __DIR__ . '/admin_guard.php'; ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Admin | Pedidos</title>
  <style>
    body{font-family:system-ui,Arial;margin:24px;background:#0b1220;color:#e8f0ff}
    a{color:#4aa3ff;text-decoration:none}
    .top{display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:12px}
    select,button{padding:10px 12px;border-radius:10px;border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.04);color:#e8f0ff}
    table{width:100%;border-collapse:collapse;margin-top:12px}
    th,td{border:1px solid rgba(255,255,255,.12);padding:10px}
    th{background:rgba(255,255,255,.06);text-align:left}
    .muted{color:#93a4bd;font-size:13px}
  </style>
</head>
<body>
  <div class="top">
    <div>
      <h2 style="margin:0">Pedidos</h2>
      <div class="muted">Lista de ventas por estado.</div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
      <a href="admin_panel.php">← Panel</a>
      <select id="estado">
        <option value="PENDIENTE">PENDIENTE</option>
        <option value="SURTIENDO">SURTIENDO</option>
        <option value="LISTO">LISTO</option>
        <option value="PAGADO">PAGADO</option>
        <option value="CANCELADO">CANCELADO</option>
      </select>
      <button id="reload">Recargar</button>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>VentaID</th>
        <th>ClienteID</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Detalle</th>
      </tr>
    </thead>
    <tbody id="tb">
      <tr><td colspan="6">Cargando…</td></tr>
    </tbody>
  </table>

<script>
  const tb = document.querySelector("#tb");
  const estado = document.querySelector("#estado");
  const reload = document.querySelector("#reload");

  async function load(){
    tb.innerHTML = `<tr><td colspan="6">Cargando…</td></tr>`;
    const r = await fetch(`/api/ventas_list.php?estado=${encodeURIComponent(estado.value)}`, { cache:"no-store" });
    const data = await r.json();
    if(!data.ok){
      tb.innerHTML = `<tr><td colspan="6">Error: ${data.error || 'no se pudo cargar'}</td></tr>`;
      return;
    }
    if(!data.data || data.data.length===0){
      tb.innerHTML = `<tr><td colspan="6">Sin pedidos.</td></tr>`;
      return;
    }
    tb.innerHTML = data.data.map(v => `
      <tr>
        <td>${v.ventaID}</td>
        <td>${v.clienteID}</td>
        <td>${v.fechaVenta ?? ''}</td>
        <td>$${Number(v.total||0).toFixed(2)}</td>
        <td>${v.estado}</td>
        <td><a href="admin_pedido_detalle.php?ventaID=${v.ventaID}">Ver</a></td>
      </tr>
    `).join("");
  }

  reload.addEventListener("click", load);
  estado.addEventListener("change", load);
  load();
</script>
</body>
</html>