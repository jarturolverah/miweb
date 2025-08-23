<?php
include("conexion.php");

if (!isset($_GET['id'])) die("❌ ID de contacto no especificado.");

$id = intval($_GET['id']);
$sql = "SELECT foto, cv_pdf FROM contactos WHERE id_contacto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
$resultado = $stmt->get_result();
$contacto = $resultado->fetch_assoc();

if($contacto['foto'] && file_exists($contacto['foto'])) unlink($contacto['foto']);
if($contacto['cv_pdf'] && file_exists($contacto['cv_pdf'])) unlink($contacto['cv_pdf']);

$sql = "DELETE FROM contactos WHERE id_contacto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Eliminar Contacto</title>
<style>body{background:black;color:#00FF00;font-family:'Courier New',monospace;text-align:center;}a{color:#00FF00;text-decoration:none;}a:hover{color:#00cc00;}</style>
</head>
<body>
<h2>🗑 Contacto eliminado correctamente</h2>
<p><a href="busqueda_contactos.php">⬅️ Volver a búsqueda</a></p>
</body></html>
