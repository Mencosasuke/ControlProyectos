<?php
	// Verifica que exista una sesión de usuario iniciada, de lo contrario, redirige a login.php
	session_start();
	if(!isset($_SESSION["usuario"])){
		header("Location: login.php");
	}
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
				<a href="#"><div>Proyectos</div></a>
				<a href="#"><div>Actividades</div></a>
				<a href=""><div>Perfil</div></a>
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
		</div>
	</div>
</body>
</html>