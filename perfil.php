<?php
	// Verifica que exista una sesión de usuario iniciada, de lo contrario, redirige a login.php
	session_start();
	if(!isset($_SESSION["usuario"])){
		header("Location: login.php");
	}

	// Se inicializan las variables de usuario necesarias
	$idUsuario = $_SESSION["usuario"][0];
	$usuario = $_SESSION["usuario"][1];
	$nombre = $_SESSION["usuario"][2];
	$apellido = $_SESSION["usuario"][3];
	$rol = $_SESSION["usuario"][4];
	$correo = $_SESSION["usuario"][5];
	$password = $_SESSION["usuario"][6];

	$permiso = false;

	if($rol != 3){
		$permiso = true;
	}

	include ('conexion.php'); // Incluye la clase conexión
	include ('Controladores/ControlUsuario.php'); // Incluye la clase controlador de usuarios

	$conexion = new Conexion(); // Instancia clase Conexión
	$controlUsuario = new ControlUsuario(); // Instancia clase ControlUsuario

	$link = $conexion->open(); // Se abre la conexión a la base de datos;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Perfil - Control de Proyectos</title>
	<link href="Resources/favicon.ico" rel="icon" type="image/x-icon" />
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
				<a href="index.php"><div><i class="fa fa-bar-chart"></i> Proyectos</div></a>
				<a href="perfil.php"><div><i class="fa fa-user"></i> Perfil</div></a>
				<a href="logout.php"><div><i class="fa fa-user-times"></i> Salir</div></a>
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
			<form method="POST" action="Controladores/ControlUsuario.php">
				<input type="hidden" id="action" name="action" value="mu">
				<input type="hidden" id="txtIdUsuario" name="txtIdUsuario" value="<?=$idUsuario?>">
				<div class="loginInput"><label for="txtNombre">Nombres: </label><input type="text" id="txtNombre" name="txtNombre" placeholder="Nombres" required value="<?=$nombre?>"></div>
				<div class="loginInput"><label for="txtApellido">Apellidos: </label><input type="text" id="txtApellido" name="txtApellido" placeholder="Apellidos" required value="<?=$apellido?>"></div>	
				<div class="loginInput"><label for="txtUsuario">Usuario: </label><input type="text" id="txtUsuario" name="txtUsuario" placeholder="Nombre de Usuario" required value="<?=$usuario?>"></div>
				<div class="loginInput"><label for="txtPassword">Contraseña: </label><input type="password" id="txtPassword" name="txtPassword" placeholder="Contraseña" required value="<?=$password?>"></div>
				<div class="loginInput"><label for="txtCorreo">Correo: </label><input type="email" id="txtCorreo" name="txtCorreo" placeholder="Correo Electrónico" required value="<?=$correo?>"></div>
				<div class="loginInput"><label for="txtRol">Rol: </label><select id="txtRol" name="txtRol">
<?php
				if($permiso){
					$result = $controlUsuario->obtenerRoles($link);
					while ($row = pg_fetch_assoc($result)) {
						if($row['idRol']!=$rol){
							echo '<option value="'.$row['idRol'].'">'.$row['nombre'].'</option>';
						}else{
							echo '<option value="'.$row['idRol'].'" selected="selected">'.$row['nombre'].'</option>';
						}
					}
				}else{
					$result = $controlUsuario->obtenerRol($link, $rol);
					$row = pg_fetch_assoc($result);
					echo '<option value="'.$row['idRol'].'" selected="selected">'.$row['nombre'].'</option>';
				}
?>
				</select></div>
				<div class="buttonContainer"><button type="submit" class="button">Modificar</button>
				<a href="index.php" class="button">Cancelar</a></div>
			</form>
<?php
			$conexion->close(); // Se cierra la conexión a la base de datos.
?>
		</div>
	</div>
</body>
</html>