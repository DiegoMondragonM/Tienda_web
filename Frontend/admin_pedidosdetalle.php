<?php require __DIR__ . '/admin_guard.php'; ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Admin | Detalle pedido</title>
  <style>
    body{font-family:system-ui,Arial;margin:24px;background:#0b1220;color:#e8f0ff}
    a{color:#4aa3ff;text-decoration:none}
    .card{border:1px solid rgba(255,255,255,.12);border-radius:16px;background:rgba(255,255,255,.04);padding:14px;margin-bottom:12px}
    table{width:100%;border-collapse:collapse;margin-top:12px}
    th,td{border:1px solid rgba(255,255,255,.12);padding:10px}
    th{background:rgba(255,255,255,.06);text-align:left}
    select,button{padding:10px 12px;border-radius:10px;border:1px solid rgba(255,255,255,.15);background:rgba(255,255,255,.04);color:#e8f0ff}
    .muted{color:#93a4bd;font-size:13px}
  </style>
</head>
<body>
  <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:12px">
    <a href="admin_pedidos.php">← Volver</a>
    <div class="muted">Detalle de venta</div>
  </div>

  <div id="head" class="card">Cargando…</div>

  <div class="card">
    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between">
      <b>Productos</b>
      <div style="display:flex;gap:10px;flex-wrap:wrap">
        <select id="estado">
          <option value="PENDIENTE">PENDIENTE</option>
          <option value="SURTIENDO">SURTIENDO</option>
          <option value="LISTO">LISTO</option>
          <option value="PAGADO">PAGADO</option>
          <option value="CANCELADO">CANCELADO</option>
        </select>
        <button id="save">Guardar estado</button>
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>ProductoID</th>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody id="tb">
        <tr><td colspan="5">Cargando…</td></tr>
      </tbody>
    </table>
    <div id="msg" class="muted" style="margin-top:10px"></div>
  </div>

<script>
  const ventaID = new URLSearchParams(location.search).get("ventaID");
  const head = document.querySelector("#head");
  const tb = document.querySelector("#tb");
  const estadoSel = document.querySelector("#estado");
  const saveBtn = document.querySelector("#save");
  const msg = document.querySelector("#msg");

  async function load(){
    const r = await fetch(`/api/venta_detalle.php?ventaID=${encodeURIComponent(ventaID)}`, { cache:"no-store" });
    const data = await r.json();
    if(!data.ok){
      head.textContent = "Error: " + (data.error || "no se pudo cargar");
      tb.innerHTML = `<tr><td colspan="5">Error</td></tr>`;
      return;
    }

    const v = data.venta;
    head.innerHTML = `
      <b>Venta #${v.ventaID}</b><br/>
      <span class="muted">ClienteID:</span> ${v.clienteID} &nbsp; | &nbsp;
      <span class="muted">Fecha:</span> ${v.fechaVenta ?? ''} &nbsp; | &nbsp;
      <span class="muted">Total:</span> $${Number(v.total||0).toFixed(2)}
    `;
    estadoSel.value = v.estado;

    if(!data.items || data.items.length===0){
      tb.innerHTML = `<tr><td colspan="5">Sin detalles.</td></tr>`;
      return;
    }

    tb.innerHTML = data.items.map(it => `
      <tr>
        <td>${it.productoID}</td>
        <td>${it.nombre ?? ''}</td>
        <td>${it.cantidad}</td>
        <td>$${Number(it.preciounitario||0).toFixed(2)}</td>
        <td>$${Number(it.subtotal||0).toFixed(2)}</td>
      </tr>
    `).join("");
  }

  saveBtn.addEventListener("click", async () => {
    msg.textContent = "Guardando…";
    const fd = new FormData();
    fd.append("ventaID", ventaID);
    fd.append("estado", estadoSel.value);

    const r = await fetch("/api/ventas_set_estado.php", { method:"POST", body: fd });
    const data = await r.json();
    if(!data.ok){
      msg.textContent = "Error: " + (data.error || "no se pudo guardar");
      return;
    }
    msg.textContent = "Estado actualizado ✅";
    load();
  });

  load();
</script>
</body>
</html>