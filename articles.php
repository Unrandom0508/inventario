<?php
session_start();
if (!isset($_SESSION['user_cedula'])) {
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Gestión de Artículos</title>
</head>
<body>
<h2>Gestión de Artículos</h2>
<button onclick="location.href='index.php'">Volver</button>
<button onclick="loadArticles()">Refrescar lista</button>
<hr>

<h3>Agregar artículo</h3>
<form id="formCreate" onsubmit="createArticle(event)">
    <label>Nombre: <input name="nombre" required></label><br>
    <label>Unidades: <input name="unidades" type="number" min="0" value="0" required></label><br>
    <label>Tipo:
        <select name="tipo" required>
            <option value="PC">PC</option>
            <option value="teclado">teclado</option>
            <option value="disco duro">disco duro</option>
            <option value="mouse">mouse</option>
        </select>
    </label><br>
    <label>Bodega:
        <select name="bodega" required>
            <option value="norte">norte</option>
            <option value="sur">sur</option>
            <option value="oriente">oriente</option>
            <option value="occidente">occidente</option>
        </select>
    </label><br>
    <button>Agregar</button>
</form>

<hr>
<h3>Artículos</h3>
<table id="articlesTable" border="1" style="border-collapse:collapse;">
<thead><tr><th>ID</th><th>Nombre</th><th>Unidades</th><th>Tipo</th><th>Bodega</th><th>Acciones</th></tr></thead>
<tbody></tbody>
</table>

<script>
async function loadArticles(){
    const res = await fetch('article_actions.php?action=list');
    const rows = await res.json();
    const tbody = document.querySelector('#articlesTable tbody');
    tbody.innerHTML = '';
    rows.forEach(r=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${r.id}</td><td>${r.nombre}</td><td>${r.unidades}</td><td>${r.tipo}</td><td>${r.bodega}</td>
            <td>
                <button onclick="openEdit(${r.id}, '${escapeHtml(r.nombre)}', ${r.unidades}, '${r.tipo}', '${r.bodega}')">Editar</button>
                <button onclick="deleteArticle(${r.id})">Eliminar</button>
            </td>`;
        tbody.appendChild(tr);
    });
}
function escapeHtml(s){
    return s.replace(/'/g, "\\'").replace(/"/g, "&quot;");
}

async function createArticle(e){
    e.preventDefault();
    const f = e.target;
    const payload = {
        nombre: f.nombre.value.trim(),
        unidades: parseInt(f.unidades.value),
        tipo: f.tipo.value,
        bodega: f.bodega.value
    };
    const res = await fetch('article_actions.php?action=create', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(payload)
    });
    const j = await res.json();
    if (j.ok) {
        alert('Artículo creado');
        f.reset();
        loadArticles();
    } else alert('Error: ' + (j.error || JSON.stringify(j)));
}

function openEdit(id, nombre, unidades, tipo, bodega){
    const newName = prompt('Nombre', nombre);
    if (newName === null) return;
    const newUnits = prompt('Unidades', unidades);
    if (newUnits === null) return;
    const newTipo = prompt('Tipo (PC,teclado,disco duro,mouse)', tipo);
    if (newTipo === null) return;
    const newBodega = prompt('Bodega (norte,sur,oriente,occidente)', bodega);
    if (newBodega === null) return;
    const payload = {id, nombre: newName, unidades: parseInt(newUnits), tipo: newTipo, bodega: newBodega};
    fetch('article_actions.php?action=update', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(payload)
    }).then(r=>r.json()).then(j=>{
        if (j.ok) { alert('Actualizado'); loadArticles(); }
        else alert('Error: '+(j.error||JSON.stringify(j)));
    });
}

function deleteArticle(id){
    if (!confirm('¿Eliminar artículo #' + id + '?')) return;
    fetch('article_actions.php?action=delete', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify({id})
    }).then(r=>r.json()).then(j=>{
        if (j.ok) { alert('Eliminado'); loadArticles(); }
        else alert('Error: '+(j.error||JSON.stringify(j)));
    });
}

window.onload = loadArticles;
</script>
</body>
</html>
