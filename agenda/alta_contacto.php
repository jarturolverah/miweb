<?php
include("conexion.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $empresa = $_POST['empresa'];
    $puesto = $_POST['puesto'];
    $notas = $_POST['notas'];

    $foto = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto = "uploads/fotos/" . basename($_FILES['foto']['name']);
        @mkdir("uploads/fotos", 0777, true);
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
    }

    $cv = "";
    if (!empty($_FILES['cv']['name'])) {
        $cv = "uploads/cv/" . basename($_FILES['cv']['name']);
        @mkdir("uploads/cv", 0777, true);
        move_uploaded_file($_FILES['cv']['tmp_name'], $cv);
    }

    $sql = "INSERT INTO contactos (nombre, apellido, telefono, email, direccion, empresa, puesto, notas, foto, cv_pdf)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $nombre, $apellido, $telefono, $email, $direccion, $empresa, $puesto, $notas, $foto, $cv);
    $stmt->execute();
    echo "<p style='color:#00FF00;text-align:center;'>✅ Contacto agregado correctamente</p>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Alta de Contacto</title>
<style>
body { background-color: black; color: #00FF00; font-family: "Courier New", monospace; }
form { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #00FF00; border-radius: 10px; }
input, textarea { width: 100%; padding: 8px; margin: 5px 0; background: black; color: #00FF00; border: 1px solid #00FF00; }
button { background: #00FF00; color: black; padding: 10px; width: 100%; font-weight: bold; border: none; cursor: pointer; }
button:hover { background: #00cc00; }
</style>
</head>
<body>
<h2 align="center">Alta de Contacto</h2>
<form method="post" enctype="multipart/form-data">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellido" placeholder="Apellido" required>
    <input type="text" name="telefono" placeholder="Teléfono">
    <input type="email" name="email" placeholder="Correo">
    <input type="text" name="empresa" placeholder="Empresa">
    <input type="text" name="puesto" placeholder="Puesto">
    <textarea name="direccion" placeholder="Dirección"></textarea>
    <textarea name="notas" placeholder="Notas adicionales"></textarea>
    <label>Foto: <input type="file" name="foto" accept="image/*"></label><br><br>
    <label>CV en PDF: <input type="file" name="cv" accept="application/pdf"></label><br><br>
    <button type="submit">Guardar</button>
</form>
</body>
</html>