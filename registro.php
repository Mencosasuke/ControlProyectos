<?php
	// Verifica que exista una sesión de usuario iniciada y lo redirige a index.php
	session_start();
	if(isset($_SESSION["usuario"])){
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Registro - Control de Proyectos</title>
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<?php

include ('conexion.php'); // Se incluye la clase conexion
include ('Controladores/ControlUsuario.php'); // Se incluye la clase controlador de usuario

// Instancia de la clase Conexion
$conexion = new Conexion();

// Instancia de clase de control de usuarios
$controlUsuario = new ControlUsuario();

$loginsucces = true; // Variable que indica si el registro sucedió con éxito

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	// Inicializo la conexión
	$link = $conexion->open();

	// Registro de usuario
	if($link){
		$usuario = $_POST['txtUsuario'];
		$password = $_POST['txtPassword'];
		$correo = $_POST['txtCorreo'];
		$idRol = $_POST['txtRol'];
		$nombre = $_POST['txtNombre'];
		$apellido = $_POST['txtApellido'];

		$loginsucces = !!$controlUsuario->registrar($link, $usuario, $password, $correo, $idRol, $nombre, $apellido);
		
		if($loginsucces){
			header("Location: login.php");
		}
	}
	$conexion->close();
}
?>
<body>

	<div class="wrap">
		<div class="loginView" style="height:550px; margin-top:-275px;">
			<div id="tituloPrincipal">Control de Proyectos</div>
			<div class="loginForm" style="height:493px;">
				<div class="loginContent" style="height:493px;">
					<div class="logo">
						<h1>
		    				<a class="image" href="#" title="Control de Proyectos">.</a>
		    			</h1>d
					</div>
					<form method="POST" action="registro.php">
						<div class="loginInput"><label for="txtNombre">Nombres: </label><input type="text" id="txtNombre" name="txtNombre" placeholder="Nombres" required></div>
						<div class="loginInput"><label for="txtApellido">Apellidos: </label><input type="text" id="txtApellido" name="txtApellido" placeholder="Apellidos" required></div>	
						<div class="loginInput"><label for="txtUsuario">Usuario: </label><input type="text" id="txtUsuario" name="txtUsuario" placeholder="Nombre de Usuario" required></div>
						<div class="loginInput"><label for="txtPassword">Contraseña: </label><input type="password" id="txtPassword" name="txtPassword" placeholder="Contraseña" required></div>
						<div class="loginInput"><label for="txtCorreo">Correo: </label><input type="email" id="txtCorreo" name="txtCorreo" placeholder="Correo Electrónico" required></div>
						<div class="loginInput"><label for="txtRol">Rol: </label><select id="txtRol" name="txtRol">
<?php
						$link = $conexion->open();
						$result = $controlUsuario->obtenerRoles($link);

						while ($row = pg_fetch_row($result)) {
							echo '<option value="'.$row[0].'">'.$row[1].'</option>';
						}
						$conexion->close();
?>
						</select></div>
						<div class="buttonContainer"><button type="submit" class="button">Registrar</button>
						<a href="login.php" class="button">Iniciar Sesión</a></div>
					</form>
					<?php if(!$loginsucces){?><span class="spanError">El usuario ya existe. Intente de nuevo.</span><?php } ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>