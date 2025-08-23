<?php
include("conexion.php");

if (!isset($_GET['id'])) {
    die("❌ ID de contacto no especificado.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM contactos WHERE id_contacto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$contacto = $resultado->fetch_assoc();

if (!$contacto) die("❌ Contacto no encontrado.");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre']; $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono']; $email = $_POST['email'];
    $empresa = $_POST['empresa']; $puesto = $_POST['puesto'];
    $direccion = $_POST['direccion']; $notas = $_POST['notas'];

    $foto = $contacto['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $foto = "uploads/fotos/" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
    }

    $cv = $contacto['cv_pdf'];
    if (!empty($_FILES['cv']['name'])) {
        $cv = "uploads/cv/" . basename($_FILES['cv']['name']);
        move_uploaded_file($_FILES['cv']['tmp_name'], $cv);
    }

    $sql = "UPDATE contactos SET nombre=?, apellido=?, telefono=?, email=?, empresa=?, puesto=?, direccion=?, notas=?, foto=?, cv_pdf=? WHERE id_contacto=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $nombre, $apellido, $telefono, $email, $empresa, $puesto, $direccion, $notas, $foto, $cv, $id);
    $stmt->execute();

    echo "<p style='color:#00FF00;text-align:center;'>✅ Contacto actualizado correctamente</p>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Editar Contacto</title>
<style>body{background:black;color:#00FF00;font-family:'Courier New',monospace;}form{max-width:600px;margin:auto;padding:20px;border:1px solid #00FF00;border-radius:10px;}input,textarea{width:100%;padding:8px;margin:5px 0;background:black;color:#00FF00;border:1px solid #00FF00;}button{background:#00FF00;color:black;padding:10px;width:100%;font-weight:bold;border:none;cursor:pointer;}button:hover{background:#00cc00;}img{max-width:100px;margin-top:10px;border-radius:5px;}a{color:#00FF00;text-decoration:none;}a:hover{color:#00cc00;}</style>
</head>
<body>
<h2 align="center">✏️ Editar Contacto</h2>
<form method="post" enctype="multipart/form-data">
<input type="text" name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($contacto['nombre']) ?>" required>
<input type="text" name="apellido" placeholder="Apellido" value="<?= htmlspecialchars($contacto['apellido']) ?>" required>
<input type="text" name="telefono" placeholder="Teléfono" value="<?= htmlspecialchars($contacto['telefono']) ?>">
<input type="email" name="email" placeholder="Correo" value="<?= htmlspecialchars($contacto['email']) ?>">
<input type="text" name="empresa" placeholder="Empresa" value="<?= htmlspecialchars($contacto['empresa']) ?>">
<input type="text" name="puesto" placeholder="Puesto" value="<?= htmlspecialchars($contacto['puesto']) ?>">
<textarea name="direccion" placeholder="Dirección"><?= htmlspecialchars($contacto['direccion']) ?></textarea>
<textarea name="notas" placeholder="Notas adicionales"><?= htmlspecialchars($contacto['notas']) ?></textarea>
<label>Foto actual:</label><br>
<?php if($contacto['foto']): ?><img src="<?= htmlspecialchars($contacto['foto']) ?>" alt="Foto"><br><?php else: ?><p>Sin foto</p><?php endif; ?>
<input type="file" name="foto" accept="image/*"><br><br>
<label>CV actual:</label><br>
<?php if($contacto['cv_pdf']): ?><a href="<?= htmlspecialchars($contacto['cv_pdf']) ?>" target="_blank">📄 Ver CV</a><br><?php else: ?><p>Sin CV</p><?php endif; ?>
<input type="file" name="cv" accept="application/pdf"><br><br>
<button type="submit">💾 Guardar Cambios</button>
</form>
<br><div style="text-align:center;"><a href="busqueda_contactos.php">⬅️ Volver a búsqueda</a></div>
</body></html>
