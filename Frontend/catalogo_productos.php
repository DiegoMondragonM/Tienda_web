<?php require __DIR__ . '/admin_guard.php'; ?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <title>Catálogo de Productos</title>

    <style>
        :root {

            --bg: #0b1220;
            --card: #0f1b2d;
            --muted: #93a4bd;
            --text: #e8f0ff;

            --accent: #4aa3ff;
            --ok: #28d17c;
            --line: rgba(255, 255, 255, .08);

            --shadow: 0 14px 40px rgba(0, 0, 0, .35);

            --radius: 18px;

        }

        * {
            box-sizing: border-box
        }

        body {

            margin: 0;
            background: radial-gradient(1200px 700px at 18% 8%, rgba(74, 163, 255, .18), transparent 60%),

                radial-gradient(1000px 600px at 82% 18%, rgba(255, 184, 74, .14), transparent 60%),

                var(--bg);

            color: var(--text);
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;

        }

        .wrap {
            max-width: 1100px;
            margin: 36px auto;
            padding: 0 16px;
        }

        .top {
            display: flex;
            gap: 14px;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .brand {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .logo {

            width: 44px;
            height: 44px;
            border-radius: 14px;

            background: linear-gradient(135deg, rgba(74, 163, 255, .95), rgba(255, 184, 74, .9));

            box-shadow: var(--shadow);

        }

        h1 {
            font-size: 22px;
            margin: 0
        }

        .subtitle {
            color: var(--muted);
            font-size: 13px;
            margin-top: 2px
        }

        .pill {

            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 8px 12px;

            display: flex;
            gap: 10px;
            align-items: center;
            background: rgba(255, 255, 255, .03);

        }

        .pill input {
            background: transparent;
            border: 0;
            outline: 0;
            color: var(--text);
            min-width: 240px;
        }

        .grid {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 16px;
        }

        @media (max-width: 980px) {
            .grid {
                grid-template-columns: 1fr
            }

            .pill input {
                min-width: 160px
            }
        }

        .card {

            background: rgba(255, 255, 255, .03);

            border: 1px solid var(--line);

            border-radius: var(--radius);

            box-shadow: var(--shadow);

            overflow: hidden;

        }

        .card-h {

            padding: 14px 16px;
            border-bottom: 1px solid var(--line);

            display: flex;
            align-items: center;
            justify-content: space-between;

            background: linear-gradient(180deg, rgba(255, 255, 255, .05), transparent);

        }

        .card-h b {
            font-size: 14px
        }

        .card-b {
            padding: 16px
        }

        label {
            display: block;
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 6px
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px
        }

        .row-1 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px
        }

        input,
        textarea {

            width: 100%;
            padding: 10px 12px;
            border-radius: 12px;

            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .02);

            color: var(--text);
            outline: 0;

        }

        textarea {
            min-height: 74px;
            resize: vertical
        }

        .btns {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap
        }

        button {

            cursor: pointer;
            border: 1px solid var(--line);

            background: rgba(74, 163, 255, .18);

            color: var(--text);

            padding: 10px 12px;
            border-radius: 12px;
            font-weight: 600;

        }

        button.secondary {
            background: rgba(255, 255, 255, .04)
        }

        button:disabled {
            opacity: .6;
            cursor: not-allowed
        }

        .msg {

            margin-top: 10px;
            padding: 10px 12px;
            border-radius: 12px;

            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .03);

            color: var(--muted);
            font-size: 13px;

        }

        .msg.ok {
            border-color: rgba(40, 209, 124, .35);
            color: rgba(40, 209, 124, .95)
        }

        .msg.err {
            border-color: rgba(255, 74, 106, .35);
            color: rgba(255, 74, 106, .95)
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            padding: 10px 10px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            font-size: 13px
        }

        th {
            color: var(--muted);
            font-weight: 700;
            background: rgba(255, 255, 255, .03);
            position: sticky;
            top: 0
        }

        .table-wrap {
            max-height: 520px;
            overflow: auto
        }

        .kpi {
            display: flex;
            gap: 12px;
            align-items: center;
            color: var(--muted);
            font-size: 13px
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--ok)
        }

        .badge {
            padding: 4px 8px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .03);
            color: var(--muted);
            font-size: 12px
        }
    </style>

</head>

<body>

    <div class="wrap">

        <div class="top">

            <div class="brand">

                <div class="logo"></div>

                <div>

                    <h1>Catálogo de Productos</h1>

                    <div class="subtitle">Alta / listado /</div>

                </div>

            </div>



            <div class="pill">

                🔎 <input id="q" type="search" placeholder="Buscar por nombre o descripción…" />

            </div>

        </div>



        <div class="grid">

            <div class="card">

                <div class="card-h">

                    <b>Registrar producto</b>

                    <div class="kpi"><span class="dot"></span><span id="count">0</span> productos</div>

                </div>

                <div class="card-b">

                    <form id="formProd">

                        <div class="row-1">

                            <div>

                                <label>Nombre</label>

                                <input name="nombre" required maxlength="50" placeholder="Ej. Coca 600ml" />

                            </div>

                        </div>



                        <div class="row-1" style="margin-top:10px">

                            <div>

                                <label>Descripción</label>

                                <textarea name="descripcion" maxlength="200"
                                    placeholder="Ej. Refresco sabor cola…"></textarea>

                            </div>

                        </div>



                        <div class="row" style="margin-top:10px">

                            <div>

                                <label>Precio</label>

                                <input name="precio" type="number" step="0.01" min="0.01" required
                                    placeholder="18.00" />

                            </div>

                            <div>

                                <label>Existencias</label>

                                <input name="existencias" type="number" step="1" min="0" value="0" />

                            </div>

                        </div>



                        <div class="btns">

                            <button id="btnGuardar" type="submit">Guardar producto</button>

                            <button class="secondary" type="button" id="btnLimpiar">Limpiar</button>

                            <button class="secondary" type="button" id="btnRecargar">Recargar lista</button>

                        </div>



                        <div id="msg" class="msg" style="display:none"></div>

                    </form>

                </div>

            </div>



            <div class="card">

                <div class="card-h">

                    <b>Listado</b>

                    <div class="kpi"><span class="badge">Tip: filtra con búsqueda</span></div>

                </div>



                <div class="table-wrap">

                    <table>

                        <thead>

                            <tr>

                                <th style="width:70px">ID</th>

                                <th>Nombre</th>

                                <th>Descripción</th>

                                <th style="width:110px">Precio</th>

                                <th style="width:120px">Existencias</th>

                            </tr>

                        </thead>

                        <tbody id="tbody">

                            <tr>
                                <td colspan="5">Cargando…</td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>



        </div>

    </div>



    <script>

        const API = "/api"; // Asegúrate que esta ruta sea correcta en tu servidor

        const $ = (s) => document.querySelector(s);



        // Referencias al DOM

        const tbody = $("#tbody");

        const msg = $("#msg");

        const count = $("#count");

        const q = $("#q");

        const form = $("#formProd");

        const btnGuardar = $("#btnGuardar");



        let all = []; // Almacén local de productos



        // Utilidades de Mensajes

        function showMsg(text, type = "") {

            msg.style.display = "block";

            msg.className = "msg " + type;

            msg.textContent = text;

            // Ocultar mensaje automáticamente después de 3 seg

            setTimeout(() => { if (type === 'ok') hideMsg() }, 3000);

        }

        function hideMsg() { msg.style.display = "none"; }



        // Escapar HTML para evitar XSS

        function esc(s) {

            return String(s ?? "").replace(/[&<>"']/g, m => ({

                "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;"

            }[m]));

        }



        // --- FUNCIÓN 1: CARGAR PRODUCTOS (GET) ---

        async function loadProductos() {

            hideMsg();

            // Solo mostramos "Cargando" si la tabla está vacía para no parpadear en recargas

            if (all.length === 0) tbody.innerHTML = `<tr><td colspan="5" style="text-align:center">Cargando datos...</td></tr>`;



            try {

                // Llama a productos_list.php (El archivo del Paso 1)

                const r = await fetch(`${API}/productos_list.php`, { cache: "no-store" });

                if (!r.ok) throw new Error("Error en la red o ruta incorrecta");



                const data = await r.json();



                if (!data.ok) throw new Error(data.error || "Error desconocido al obtener datos");



                all = data.data || [];

                count.textContent = all.length;

                render(); // Dibuja la tabla

            } catch (e) {

                console.error(e);

                tbody.innerHTML = `<tr><td colspan="5" style="color:salmon; text-align:center">Error: ${esc(e.message)}</td></tr>`;

            }

        }



        // --- FUNCIÓN 2: DIBUJAR TABLA (RENDER) ---

        function render() {

            const term = q.value.trim().toLowerCase();

            // Filtramos en memoria

            const rows = all.filter(r => {

                const hay = `${r.nombre || ""} ${r.descripcion || ""}`.toLowerCase();

                return !term || hay.includes(term);

            });



            if (rows.length === 0) {

                tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; color:#93a4bd">Sin resultados.</td></tr>`;

                return;

            }



            tbody.innerHTML = rows.map(r => `

        <tr>

          <td>${Number(r.id || 0)}</td>

          <td><b>${esc(r.nombre)}</b></td>

          <td>${esc(r.descripcion)}</td>

          <td>$${Number(r.precio || 0).toFixed(2)}</td>

          <td>${Number(r.existencias || 0)} u.</td>

        </tr>

      `).join("");

        }



        // --- FUNCIÓN 3: GUARDAR PRODUCTO (POST) ---

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            btnGuardar.disabled = true;

            btnGuardar.textContent = "Guardando...";

            hideMsg();



            try {

                const formData = new FormData(form);

                // Llama a productos_create.php (El archivo del Paso 2)

                const r = await fetch(`${API}/productos_create.php`, {

                    method: 'POST',

                    body: formData

                });



                const data = await r.json();



                if (!data.ok) throw new Error(data.error || "No se pudo guardar");



                showMsg("Producto guardado correctamente", "ok");

                form.reset();

                loadProductos(); // Recargar la lista automáticamente



            } catch (e) {

                showMsg("Error: " + e.message, "err");

            } finally {

                btnGuardar.disabled = false;

                btnGuardar.textContent = "Guardar producto";

            }

        });



        // Eventos de UI

        q.addEventListener("input", render);

        $("#btnRecargar").addEventListener("click", loadProductos);

        $("#btnLimpiar").addEventListener("click", () => {

            form.reset();

            hideMsg();

        });



        // Iniciar carga al abrir

        loadProductos();



    </script>