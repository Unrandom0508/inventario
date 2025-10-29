<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula = $_POST["cedula"];
    $contrasena = $_POST["contrasena"];

    $sql = "SELECT * FROM usuarios WHERE cedula='$cedula' AND contrasena='$contrasena'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $_SESSION["cedula"] = $cedula;
        $_SESSION["contrasena"] = $contrasena;

        if ($cedula == "1111" && $contrasena == "1234") {
            header("Location: admin.php");
        } else {
            header("Location: articulos.php");
        }
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Inventario</title>
</head>
<body>
    <h2>Ingreso al Sistema</h2>
    <form method="POST">
        <label>Cédula:</label><br>
        <input type="text" name="cedula" required><br><br>
        <label>Contraseña:</label><br>
        <input type="password" name="contrasena" required><br><br>
        <button type="submit">Ingresar</button>
    </form>
    <p style="color:red;"><?= isset($error) ? $error : "" ?></p>
</body>
</html>
