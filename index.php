<?php
	// Verifica que exista una sesión de usuario iniciada, de lo contrario, redirige a login.php
	session_start();
	if(!isset($_SESSION["usuario"])){
		header("Location: login.php");
	}

	include ('Conexion.php'); // Incluye la clase conexión
	include ('Controladores/ControlProyecto.php'); // Incluye la clase controlador de proyectos

	$conexion = new Conexion(); // Instancia clase Conexión
	$controlProyecto = new ControlProyecto(); // Instancia clase ControlProyecto

	// Se inicializan las variables de usuario necesarias
	$idUsuario = $_SESSION["usuario"][0];
	$usuario = $_SESSION["usuario"][1];
	$nombre = $_SESSION["usuario"][2];
	$apellido = $_SESSION["usuario"][3];
	$rol = $_SESSION["usuario"][4];
	$correo = $_SESSION["usuario"][5];
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Control de Proyectos</title>
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Maven+Pro' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="wrap">
		<div class="header">
			<div class="menu">
				<a href="index.php"><div>Proyectos</div></a>
				<a href="#"><div>Perfil</div></a>
				<a href="logout.php"><div>Salir</div></a>
			</div>
			
			<div class="titulo">
				Control de Proyectos
			</div>
			<div class="logo">
				<h1>
    				<a class="image" href="index.php" title="Control de Proyectos">.</a>
    			</h1>
			</div>
		</div>
		<div class="content">
			<table class="MainTable">
			<caption class="MainCaption">Proyectos Asignados a <?php echo $usuario ?></caption>
				<thead class="MainHead">
					<tr>
						<th>ID Proyecto</th>
						<th>Nombre</th>
						<th>Fecha Inicio</th>
						<th>Fecha Fin</th>
						<th>Encargado</th>
						<th>Detalle</th>
						<th>Progreso</th>
						<th><a class="fa fa-plus-circle" id="btnNuevoProyecto" title="Nuevo Proyecto" href="modificarRegistro.php?action=np"></a></th>
					</tr>
				</thead>
<?php
				$link = $conexion->open();
				$result = $controlProyecto->obtenerProyectos($link, $idUsuario);
				while($row = pg_fetch_assoc($result)){
				//echo "<script type='text/javascript'>alert('".$row[1]."');</script>";
?>
				<tbody class="MainBody">
					<tr>
						<td><?php echo $row['idProyecto']; ?></td>
						<td><?php echo $row['nombre']; ?></td>
						<td><?php echo date_create($row['fechaInicio'])->format('d-m-Y'); ?></td>
						<td><?php echo date_create($row['fechaFin'])->format('d-m-Y'); ?></td>
						<td><?php echo $row['usuario']; ?></td>
						<td><?php echo $row['detalle']; ?></td>
<?php
						$totalDias = date_create($row['fechaInicio'])->diff(date_create($row['fechaFin']));
						$actualDias = date_create($row['fechaInicio'])->diff(date_create('now'));
						$total = $totalDias->days + 1;
						$actual = $actualDias->days + 1;
						if($actual>=$total){
							$porcentaje = 100;
						}else{
							$porcentaje = round(($actual * 100 / $total), 0, PHP_ROUND_HALF_UP);
						}
?>
						<td><progress max="100" value="<?= $porcentaje ?>" title="<?= $porcentaje ?>%"></progress></td>
						<td>
							<a class="fa fa-pencil" id="btnModificar" title="Modificar Proyecto" href="modificarRegistro.php?id=<?= $row['idProyecto'] ?>&action=mp"></a>
							<a class="fa fa-trash-o" id="btnEliminar" title="Eliminar Proyecto" href="modificarRegistro.php?id=<?= $row['idProyecto'] ?>&action=ep"></a>
						</td>
					</tr>
					<tr>
						<td colspan="8">
							<table class="SubTable">
								<thead class="SubHead">
									<tr>
										<th>No. Actividad</th>
										<th>Nombre</th>
										<th>Tipo</th>
										<th>Fecha Inicio</th>
										<th>Fecha Fin</th>
										<th>Encargado</th>
										<th>Detalle</th>
										<th>Progreso</th>
										<th><a class="fa fa-plus-circle" id="btnNuevaTarea" title="Nueva Tarea" href="modificarRegistro.php?id=<?= $row['idProyecto'] ?>&action=nt"></a></th>
									</tr>
								</thead>
								<tbody class="SubBody">
<?php
								$result2 = $controlProyecto->obtenerActividadesProyecto($link, $row['idProyecto']);
								while($row2 = pg_fetch_assoc($result2)){
?>
									<tr>
										<td><?php echo $row2['numero']; ?></td>
										<td><?php echo $row2['nombre']; ?></td>
										<td><?php echo $row2['tipo']; ?></td>
										<td><?php echo date_create($row2['fechaInicio'])->format('d-m-Y'); ?></td>
										<td><?php echo date_create($row2['fechaFin'])->format('d-m-Y'); ?></td>
										<td><?php echo $row2['usuario']; ?></td>
										<td><?php echo $row2['descripcion']; ?></td>
<?php
										$totalDias = date_create($row2['fechaInicio'])->diff(date_create($row2['fechaFin']));
										$total = $totalDias->days + 1;

										if(date_create($row2['fechaInicio'])>date_create('now')){
											$actual = 0;
										}else{
											$actualDias = date_create($row2['fechaInicio'])->diff(date_create('now'));
											$actual = $actualDias->days + 1;
											$porcentaje = 0;
										}
										if($actual>=$total){
											$porcentaje = 100;
										}else{
											$porcentaje = round(($actual * 100 / $total), 0, PHP_ROUND_HALF_UP);
										}
?>
										<td><progress max="100" value="<?= $porcentaje ?>" title="<?= $porcentaje ?>%"></progress></td>
										<td>
											<a class="fa fa-pencil" id="btnModificar" title="Modificar Actividad" href="modificarRegistro.php?id=<?= $row2['idActividad'] ?>&action=ma"></a>
											<a class="fa fa-trash-o" id="btnEliminar" title="Eliminar Actividad" href="modificarRegistro.php?id=<?= $row2['idActividad'] ?>&action=ea"></a>
										</td>
									</tr>
<?php
								}
?>
								</tbody>
							</table>
						</td>
					</tr>
<?php
				}
				$conexion->close();
?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>