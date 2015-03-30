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
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="wrap">
		<div class="header">
			<div class="menu">
				<a href="index.php"><div>Proyectos</div></a>
				<a href="#"><div>Actividades</div></a>
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
			<table>
				<thead>
					<tr>
						<th>ID Proyecto</th>
						<th>Nombre</th>
						<th>Inicio</th>
						<th>Fin</th>
						<th>Encargado</th>
						<th>Detalle</th>
						<th>Progreso</th>
					</tr>
				</thead>
				<tbody>
<?php
				//echo "<script type='text/javascript'>alert('".$_SESSION["usuario"][0]."');</script>";
				$link = $conexion->open();
				$result = $controlProyecto->obtenerProyectos($link, $idUsuario);
				while($row = pg_fetch_row($result)){
?>
				<tr>
					<td><?php $row[0]; ?></td>
					<td><?php $row[1]; ?></td>
					<td><?php $row[2]; ?></td>
					<td><?php $row[3]; ?></td>
					<td><?php $row[5]; ?></td>
					<td><?php $row[4]; ?></td>
					<td>###PROGRESO###</td>
				</tr>
<?php
				}
?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>