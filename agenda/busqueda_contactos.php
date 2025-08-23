<?php
include("conexion.php");
$resultados=[];
if($_SERVER['REQUEST_METHOD']=='POST'){
    $nombre="%".$_POST['nombre']."%"; $apellido="%".$_POST['apellido']."%";
    $empresa="%".$_POST['empresa']."%"; $telefono="%".$_POST['telefono']."%"; $email="%".$_POST['email']."%";
    $sql="SELECT * FROM contactos WHERE nombre LIKE ? AND apellido LIKE ? AND empresa LIKE ? AND telefono LIKE ? AND email LIKE ? ORDER BY apellido,nombre";
    $stmt=$conn->prepare($sql); $stmt->bind_param("sssss",$nombre,$apellido,$empresa,$telefono,$email); $stmt->execute();
    $resultados=$stmt->get_result();
}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Búsqueda Avanzada</title>
<style>body{background:black;color:#00FF00;font-family:'Courier New',monospace;}form{max-width:700px;margin:auto;padding:20px;border:1px solid #00FF00;border-radius:10px;}input{width:100%;padding:8px;margin:5px 0;background:black;color:#00FF00;border:1px solid #00FF00;}button{background:#00FF00;color:black;padding:10px;width:100%;font-weight:bold;border:none;cursor:pointer;}button:hover{background:#00cc00;}table{width:90%;margin:20px auto;border-collapse:collapse;}table,th,td{border:1px solid #00FF00;}th,td{padding:8px;text-align:left;}th{background:#003300;}img{max-height:60px;border-radius:5px;}a.accion{color:#00FF00;text-decoration:none;font-weight:bold;margin:0 5px;}a.accion:hover{color:#00cc00;}@media(max-width:768px){table,thead,tbody,th,td,tr{display:block;}th{display:none;}td{border:none;position:relative;padding-left:50%;}td::before{position:absolute;left:10px;width:45%;white-space:nowrap;font-weight:bold;}td:nth-of-type(1)::before{content:"Nombre";}td:nth-of-type(2)::before{content:"Teléfono";}td:nth-of-type(3)::before{content:"Correo";}td:nth-of-type(4)::before{content:"Empresa";}td:nth-of-type(5)::before{content:"Foto";}td:nth-of-type(6)::before{content:"CV";}td:nth-of-type(7)::before{content:"Acciones";}}</style>
<script>function confirmarEliminacion(id){if(confirm("¿Seguro que deseas eliminar este contacto?")){window.location.href="eliminar_contacto.php?id="+id;}}</script>
</head><body>
<h2 align="center">🔍 Búsqueda Avanzada de Contactos</h2>
<form method="post">
<input type="text" name="nombre" placeholder="Nombre">
<input type="text" name="apellido" placeholder="Apellido">
<input type="text" name="empresa" placeholder="Empresa">
<input type="text" name="telefono" placeholder="Teléfono">
<input type="text" name="email" placeholder="Correo">
<button type="submit">Buscar</button>
</form>
<?php if(!empty($resultados) && $resultados->num_rows>0): ?>
<table>
<tr><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Empresa</th><th>Foto</th><th>CV</th><th>Acciones</th></tr>
<?php while($row=$resultados->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['nombre']." ".$row['apellido']) ?></td>
<td><?= htmlspecialchars($row['telefono']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= htmlspecialchars($row['empresa']) ?></td>
<td><?php if($row['foto']): ?><img src="<?= htmlspecialchars($row['foto']) ?>" alt="Foto"><?php else: ?>-<?php endif; ?></td>
<td><?php if($row['cv_pdf']): ?><a href="<?= htmlspecialchars($row['cv_pdf']) ?>" target="_blank">📄 Ver CV</a><?php else: ?>-<?php endif; ?></td>
<td><a href="editar_contacto.php?id=<?= $row['id_contacto'] ?>" class="accion">✏️ Editar</a>
<a href="javascript:confirmarEliminacion(<?= $row['id_contacto'] ?>)" class="accion">🗑 Eliminar</a></td>
</tr><?php endwhile; ?></table>
<?php elseif($_SERVER["REQUEST_METHOD"]=="POST"): ?><p align="center">⚠️ No se encontraron resultados</p><?php endif; ?>
</body></html>
