<?php
session_start();
if (!isset($_SESSION['user_cedula']) || $_SESSION['user_cedula'] !== '1111') {
    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Gestión de Usuarios</title>
</head>
<body>
<h2>Gestión de Usuarios (Admin)</h2>
<button onclick="location.href='index.php'">Volver</button>
<button onclick="loadUsers()">Refrescar lista</button>
<hr>

<h3>Agregar usuario</h3>
<form id="formCreate" onsubmit="createUser(event)">
    <label>Cédula: <input name="cedula" required></label><br>
    <label>Nombre: <input name="nombre" required></label><br>
    <label>Contraseña: <input name="password" type="password" required></label><br>
    <button>Agregar</button>
</form>

<hr>
<h3>Usuarios</h3>
<table id="usersTable" border="1" style="border-collapse:collapse;">
<thead><tr><th>Cédula</th><th>Nombre</th><th>Creado</th><th>Acciones</th></tr></thead>
<tbody></tbody>
</table>

<script>
async function loadUsers() {
    const res = await fetch('user_actions.php?action=list');
    const users = await res.json();
    const tbody = document.querySelector('#usersTable tbody');
    tbody.innerHTML = '';
    users.forEach(u => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${u.cedula}</td><td>${u.nombre}</td><td>${u.created_at}</td>
            <td>
                <button onclick="editUser('${u.cedula}','${u.nombre}')">Editar</button>
            </td>`;
        tbody.appendChild(tr);
    });
}
async function createUser(e){
    e.preventDefault();
    const f = e.target;
    const payload = {
        cedula: f.cedula.value.trim(),
        nombre: f.nombre.value.trim(),
        password: f.password.value
    };
    const res = await fetch('user_actions.php?action=create', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify(payload)
    });
    const r = await res.json();
    if (r.ok) {
        alert('Usuario creado');
        f.reset();
        loadUsers();
    } else {
        alert('Error: ' + (r.error || JSON.stringify(r)));
    }
}
function editUser(cedula, nombre){
    const nuevoNombre = prompt('Nuevo nombre para ' + cedula, nombre);
    if (nuevoNombre === null) return;
    const nuevaPass = prompt('Nueva contraseña (dejar vacío para no cambiarla)');
    const payload = {cedula, nombre: nuevoNombre};
    if (nuevaPass) payload.password = nuevaPass;
    fetch('user_actions.php?action=update', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify(payload)
    }).then(r=>r.json()).then(j=>{
        if (j.ok) { alert('Usuario actualizado'); loadUsers(); }
        else alert('Error: '+(j.error||JSON.stringify(j)));
    });
}

window.onload = loadUsers;
</script>
</body>
</html>
