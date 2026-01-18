<?php require __DIR__ . '/admin_guard.php'; ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Catálogo de Clientes</title>
  <style>
    :root{
      --bg:#0b1220; --card:#0f1b2d; --muted:#93a4bd; --text:#e8f0ff;
      --accent:#4aa3ff; --danger:#ff4a6a; --ok:#28d17c; --line:rgba(255,255,255,.08);
      --shadow: 0 14px 40px rgba(0,0,0,.35);
      --radius: 18px;
    }
    *{box-sizing:border-box}
    body{
      margin:0; background: radial-gradient(1200px 700px at 15% 10%, rgba(74,163,255,.18), transparent 60%),
                          radial-gradient(1000px 600px at 85% 20%, rgba(40,209,124,.14), transparent 60%),
                          var(--bg);
      color:var(--text); font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }
    .wrap{max-width:1100px; margin:36px auto; padding:0 16px;}
    .top{
      display:flex; gap:14px; align-items:center; justify-content:space-between; flex-wrap:wrap;
      margin-bottom:18px;
    }
    .brand{
      display:flex; gap:12px; align-items:center;
    }
    .logo{
      width:44px; height:44px; border-radius:14px;
      background: linear-gradient(135deg, rgba(74,163,255,.95), rgba(40,209,124,.9));
      box-shadow: var(--shadow);
    }
    h1{font-size:22px; margin:0}
    .subtitle{color:var(--muted); font-size:13px; margin-top:2px}
    .pill{
      border:1px solid var(--line); border-radius:999px; padding:8px 12px;
      display:flex; gap:10px; align-items:center; background: rgba(255,255,255,.03);
    }
    .pill input{
      background: transparent; border:0; outline:0; color:var(--text); min-width:240px;
    }
    .grid{
      display:grid; grid-template-columns: 380px 1fr; gap:16px;
    }
    @media (max-width: 980px){ .grid{grid-template-columns:1fr} .pill input{min-width:160px} }
    .card{
      background: rgba(255,255,255,.03);
      border:1px solid var(--line);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow:hidden;
    }
    .card-h{
      padding:14px 16px; border-bottom:1px solid var(--line);
      display:flex; align-items:center; justify-content:space-between;
      background: linear-gradient(180deg, rgba(255,255,255,.05), transparent);
    }
    .card-h b{font-size:14px}
    .card-b{padding:16px}
    label{display:block; font-size:12px; color:var(--muted); margin-bottom:6px}
    .row{display:grid; grid-template-columns:1fr 1fr; gap:10px}
    .row-1{display:grid; grid-template-columns:1fr; gap:10px}
    input, textarea{
      width:100%; padding:10px 12px; border-radius:12px;
      border:1px solid var(--line); background: rgba(255,255,255,.02);
      color:var(--text); outline:0;
    }
    textarea{min-height:74px; resize: vertical}
    .btns{display:flex; gap:10px; margin-top:10px; flex-wrap:wrap}
    button{
      cursor:pointer; border:1px solid var(--line);
      background: rgba(74,163,255,.18);
      color: var(--text);
      padding:10px 12px; border-radius:12px; font-weight:600;
    }
    button.secondary{background: rgba(255,255,255,.04)}
    button.danger{background: rgba(255,74,106,.18)}
    button:disabled{opacity:.6; cursor:not-allowed}
    .msg{
      margin-top:10px; padding:10px 12px; border-radius:12px;
      border:1px solid var(--line); background: rgba(255,255,255,.03);
      color: var(--muted); font-size:13px;
    }
    .msg.ok{border-color: rgba(40,209,124,.35); color: rgba(40,209,124,.95)}
    .msg.err{border-color: rgba(255,74,106,.35); color: rgba(255,74,106,.95)}
    table{width:100%; border-collapse:collapse}
    th, td{padding:10px 10px; border-bottom:1px solid var(--line); text-align:left; font-size:13px}
    th{color: var(--muted); font-weight:700; background: rgba(255,255,255,.03); position:sticky; top:0}
    .table-wrap{max-height:520px; overflow:auto}
    .actions{display:flex; gap:10px; align-items:center}
    a.action{
      color: var(--accent); text-decoration:none; font-weight:700; font-size:13px;
    }
    a.action.d{color: var(--danger)}
    .kpi{
      display:flex; gap:12px; align-items:center; color:var(--muted); font-size:13px;
    }
    .dot{width:8px; height:8px; border-radius:999px; background: var(--ok)}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="top">
      <div class="brand">
        <div class="logo"></div>
        <div>
          <h1>Catálogo de Clientes</h1>
          <div class="subtitle">Alta / listado / búsqueda</div>
        </div>
      </div>

      <div class="pill">
        🔎 <input id="q" type="search" placeholder="Buscar por nombre, apellido o email…" />
      </div>
    </div>

    <div class="grid">
      <!-- Form -->
      <div class="card">
        <div class="card-h">
          <b>Registrar cliente</b>
          <div class="kpi"><span class="dot"></span><span id="count">0</span> clientes</div>
        </div>
        <div class="card-b">
          <form id="formCliente">
            <div class="row">
              <div>
                <label>Nombre</label>
                <input name="nombre" required maxlength="80" placeholder="Ej. Juan" />
              </div>
              <div>
                <label>Apellido</label>
                <input name="apellido" required maxlength="100" placeholder="Ej. Pérez" />
              </div>
            </div>

            <div class="row-1" style="margin-top:10px">
              <div>
                <label>Domicilio</label>
                <textarea name="domicilio" required maxlength="150" placeholder="Calle, número, colonia…"></textarea>
              </div>
            </div>

            <div class="row" style="margin-top:10px">
              <div>
                <label>Crédito</label>
                <input name="credito" type="number" step="0.01" value="0" />
              </div>
              <div>
                <label>Email</label>
                <input name="email" type="email" required maxlength="120" placeholder="correo@algo.com" />
              </div>
            </div>

            <div class="row-1" style="margin-top:10px">
              <div>
                <label>Password</label>
                <input name="password" type="password" required minlength="6" maxlength="80" placeholder="mínimo 6 caracteres" />
              </div>
            </div>

            <div class="btns">
              <button id="btnGuardar" type="submit">Guardar cliente</button>
              <button class="secondary" type="button" id="btnLimpiar">Limpiar</button>
              <button class="secondary" type="button" id="btnRecargar">Recargar lista</button>
            </div>

            <div id="msg" class="msg" style="display:none"></div>
          </form>
        </div>
      </div>

      <!-- Table -->
      <div class="card">
        <div class="card-h">
          <b>Listado</b>
          <div class="kpi">Borrado y actualizado al momento</div>
        </div>

        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th style="width:70px">ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Domicilio</th>
                <th style="width:110px">Crédito</th>
                <th>Email</th>
                <th style="width:160px">Creado</th>
                <th style="width:90px">Acción</th>
              </tr>
            </thead>
            <tbody id="tbody">
              <tr><td colspan="8">Cargando…</td></tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <script>
    // Ajusta si tu /api está en otra ruta:
    const API = "/api";

    const $ = (s) => document.querySelector(s);
    const tbody = $("#tbody");
    const msg = $("#msg");
    const count = $("#count");
    const q = $("#q");
    const form = $("#formCliente");
    const btnGuardar = $("#btnGuardar");

    let all = [];

    function showMsg(text, type="") {
      msg.style.display = "block";
      msg.className = "msg " + type;
      msg.textContent = text;
    }
    function hideMsg(){ msg.style.display = "none"; }

    function esc(s){
      return String(s ?? "").replace(/[&<>"']/g, m => ({
        "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
      }[m]));
    }

    async function loadClientes(){
      hideMsg();
      tbody.innerHTML = `<tr><td colspan="8">Cargando…</td></tr>`;
      try{
        const r = await fetch(`${API}/clientes_list.php`, { cache: "no-store" });
        const data = await r.json();
        if(!data.ok) throw new Error(data.error || "Respuesta no OK");
        all = data.data || [];
        count.textContent = all.length;
        render();
      }catch(e){
        tbody.innerHTML = `<tr><td colspan="8">Error cargando clientes: ${esc(e.message)}</td></tr>`;
        showMsg("No pude cargar clientes. Revisa que /api/clientes_list.php funcione.", "err");
      }
    }

    function render(){
      const term = q.value.trim().toLowerCase();
      const rows = all.filter(r => {
        const hay = `${r.nombre||""} ${r.apellido||""} ${r.email||""}`.toLowerCase();
        return !term || hay.includes(term);
      });

      if(rows.length === 0){
        tbody.innerHTML = `<tr><td colspan="8">Sin resultados.</td></tr>`;
        return;
      }

      tbody.innerHTML = rows.map(r => `
        <tr>
          <td>${Number(r.id||0)}</td>
          <td>${esc(r.nombre)}</td>
          <td>${esc(r.apellido)}</td>
          <td>${esc(r.domicilio)}</td>
          <td>${Number(r.credito||0).toFixed(2)}</td>
          <td>${esc(r.email)}</td>
          <td>${esc(r.creado_en)}</td>
          <td class="actions">
            <a class="action d" href="#" data-del="${Number(r.id||0)}">Borrar</a>
          </td>
        </tr>
      `).join("");
    }

    q.addEventListener("input", render);

    $("#btnRecargar").addEventListener("click", loadClientes);
    $("#btnLimpiar").addEventListener("click", () => { form.reset(); hideMsg(); });

    form.addEventListener("submit", async (ev) => {
      ev.preventDefault();
      hideMsg();
      btnGuardar.disabled = true;

      try{
        const fd = new FormData(form);
        const r = await fetch(`${API}/clientes_create.php`, { method:"POST", body: fd });
        const data = await r.json();
        if(!data.ok) throw new Error(data.error || "No se pudo guardar");

        showMsg("Cliente guardado ✅", "ok");
        form.reset();
        await loadClientes();
      }catch(e){
        showMsg("Error: " + e.message, "err");
      }finally{
        btnGuardar.disabled = false;
      }
    });

    // Delete (usa tu endpoint clientes_delete.php?id=)
    tbody.addEventListener("click", async (ev) => {
      const a = ev.target.closest("a[data-del]");
      if(!a) return;
      ev.preventDefault();

      const id = a.getAttribute("data-del");
      if(!confirm(`¿Borrar cliente ID ${id}?`)) return;

      try{
        // Algunos delete scripts redirigen y no regresan JSON.
        // Igual funciona: si regresa JSON ok, lo leemos; si regresa HTML, solo recargamos.
        const r = await fetch(`${API}/clientes_delete.php?id=${encodeURIComponent(id)}`, { method:"GET" });
        let text = await r.text();
        // Intento parsear JSON:
        try{
          const j = JSON.parse(text);
          if(j.ok === false) throw new Error(j.error || "No se pudo borrar");
        }catch(_){
          // No era JSON -> probablemente HTML/redirect; lo tomamos como OK si status 200
          if(!r.ok) throw new Error("No se pudo borrar (HTTP " + r.status + ")");
        }

        showMsg("Cliente eliminado ✅", "ok");
        await loadClientes();
      }catch(e){
        showMsg("Error al borrar: " + e.message, "err");
      }
    });

    loadClientes();
  </script>
</body>
</html>
