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
	<title>Login - Control de Proyectos</title>
	<link href="Resources/favicon.ico" rel="icon" type="image/x-icon" />
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<?php
include ('conexion.php'); // Se incluye la clase conexion
include ('Controladores/ControlUsuario.php'); // Se incluye la clase controlador de usuario
$loginsucces = true; // Variable que indica si el logueo sucedió con éxito
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	// Instancia de la clase Conexion
	$conexion = new Conexion();

	// Inicializo la conexión
	$link = $conexion->open();

	// Login de usuario
	if($link){
		$usuario = $_POST['txtUsuario'];
		$password = $_POST['txtPassword'];
		$controlUsuario = new ControlUsuario(); // Instancia de clase de control de usuarios
		$loginsucces;

		$result = $controlUsuario->login($link, $usuario, $password);
		$row = pg_fetch_row($result);
		if(!$row){
			$loginsucces = false;
		}else{
			session_start();
			$_SESSION["usuario"] = $row;
			header("Location: index.php");
		}
		
		/*$query = 'select * from "Usuario"';
		$result = pg_query($link, $query);

		while ($row = pg_fetch_row($result)) {
		  echo "idUsuario: ".$row[0]." usuario: ".$row[1]." correo: ".$row[3]." idRol: ".$row[4];
		  echo "<br />";
		}*/
	}
	$conexion->close();
}
?>
<body>

	<div class="wrap">
		<div class="loginView">
			<div id="tituloPrincipal">Control de Proyectos</div>
			<div class="loginForm">
				<div class="loginContent">
					<div class="logo">
						<h1>
		    				<a class="image" href="#" title="Control de Proyectos">.</a>
		    			</h1>
					</div>
					<form method="POST" action="login.php">
						<div class="loginInput"><label for="txtUsuario">Usuario: </label><input type="text" id="txtUsuario" name="txtUsuario" placeholder="Nombre de Usuario" value="<?php echo empty($_POST['txtUsuario']) ? '' : $_POST['txtUsuario']; ?>" required></div>
						<div class="loginInput"><label for="txtPassword">Contraseña: </label><input type="password" id="txtPassword" name="txtPassword" placeholder="Contraseña" required></div>
						<div class="buttonContainer"><button type="submit" class="button">Ingresar</button>
						<a href="registro.php" class="button">Registrar</a></div>
					</form>
					<?php if(!$loginsucces){?><span class="spanError">Credenciales inválidas.</span><?php } ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>