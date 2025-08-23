<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexion.php");
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario'] = $usuario['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login Agenda</title>
<style>
body { background-color: black; color: #00FF00; font-family: "Courier New", monospace; }
.container { max-width: 300px; margin: 100px auto; padding: 20px; border: 1px solid #00FF00; border-radius: 10px; }
input { width: 100%; padding: 8px; margin: 5px 0; background: black; color: #00FF00; border: 1px solid #00FF00; }
button { background: #00FF00; color: black; padding: 10px; width: 100%; font-weight: bold; border: none; cursor: pointer; }
button:hover { background: #00cc00; }
</style>
</head>
<body>
<div class="container">
    <h2>Acceso a la Agenda</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</div>
</body>
</html>