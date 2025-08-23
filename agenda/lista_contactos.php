<?php
include("conexion.php");
$por_pagina=10; $pagina=isset($_GET['pagina'])?(int)$_GET['pagina']:1; if($pagina<1)$pagina=1; $offset=($pagina-1)*$por_pagina;
$sql_total="SELECT COUNT(*) as total FROM contactos"; $res_total=$conn->query($sql_total); $total_filas=$res_total->fetch_assoc()['total']; $total_paginas=ceil($total_filas/$por_pagina);
$sql="SELECT * FROM contactos ORDER BY apellido,nombre LIMIT ?,?"; $stmt=$conn->prepare($sql); $stmt->bind_param("ii",$offset,$por_pagina); $stmt->execute(); $resultados=$stmt->get_result();
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>Lista de Contactos</title>
<style>body{background:black;color:#00FF00;font-family:'Courier New',monospace;}table{width:95%;margin:20px auto;border-collapse:collapse;}table,th,td{border:1px solid #00FF00;}th,td{padding:8px;text-align:left;}th{background:#003300;}img{max-height:60px;border-radius:5px;}a.accion{color:#00FF00;text-decoration:none;font-weight:bold;margin:0 5px;}a.accion:hover{color:#00cc00;}.paginacion{text-align:center;margin:20px;}.paginacion a{color:#00FF00;margin:0 5px;text-decoration:none;font-weight:bold;}.paginacion a:hover{color:#00cc00;}@media(max-width:768px){table,thead,tbody,th,td,tr{display:block;}th{display:none;}td{border:none;position:relative;padding-left:50%;}td::before{position:absolute;left:10px;width:45%;white-space:nowrap;font-weight:bold;}td:nth-of-type(1)::before{content:"Nombre";}td:nth-of-type(2)::before{content:"Teléfono";}td:nth-of-type(3)::before{content:"Correo";}td:nth-of-type(4)::before{content:"Empresa";}td:nth-of-type(5)::before{content:"Foto";}td:nth-of-type(6)::before{content:"Acciones";}}</style>
<script>function confirmarEliminacion(id){if(confirm("¿Seguro que deseas eliminar este contacto?")){window.location.href="eliminar_contacto.php?id="+id;}}</script>
</head><body>
<h2 align="center">📋 Lista de Contactos</h2>
<?php if($resultados->num_rows>0): ?>
<table><tr><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Empresa</th><th>Foto</th><th>Acciones</th></tr>
<?php while($row=$resultados->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($row['nombre']." ".$row['apellido']) ?></td>
<td><?= htmlspecialchars($row['telefono']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= htmlspecialchars($row['empresa']) ?></td>
<td><?php if($row['foto']): ?><img src="<?= htmlspecialchars($row['foto']) ?>" alt="Foto"><?php else: ?>-<?php endif; ?></td>
<td><a href="editar_contacto.php?id=<?= $row['id_contacto'] ?>" class="accion">✏️ Editar</a>
<a href="javascript:confirmarEliminacion(<?= $row['id_contacto'] ?>)" class="accion">🗑 Eliminar</a></td>
</tr><?php endwhile; ?></table>
<div class="paginacion">
<?php if($pagina>1): ?><a href="?pagina=<?= $pagina-1 ?>">⬅️ Anterior</a><?php endif; ?>
<span>Página <?= $pagina ?> de <?= $total_paginas ?></span>
<?php if($pagina<$total_paginas): ?><a href="?pagina=<?= $pagina+1 ?>">Siguiente ➡️</a><?php endif; ?>
</div><?php else: ?><p align="center">⚠️ No hay contactos registrados.</p><?php endif; ?>
<div style="text-align:center;margin-top:20px;"><a href="busqueda_contactos.php">🔍 Ir a búsqueda avanzada</a></div>
</body></html>
