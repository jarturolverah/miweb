<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Principal</title>
<style>
body { background-color: black; color: #00FF00; font-family: "Courier New", monospace; text-align:center; }
a { display:inline-block; margin: 15px; padding: 15px 30px; border: 1px solid #00FF00; border-radius: 10px; text-decoration:none; color:#00FF00; font-weight:bold; }
a:hover { background:#00FF00; color:black; }
</style>
</head>
<body>
<h2>📂 Agenda de Contactos</h2>
<p>Bienvenido, <?= $_SESSION['usuario'] ?> </p>
<a href="alta_contacto.php">➕ Alta de Contacto</a>
<a href="busqueda_contactos.php">🔍 Búsqueda Avanzada</a>
<a href="lista_contactos.php">📋 Lista General</a>
<a href="logout.php">🚪 Cerrar Sesión</a>
</body>
</html>