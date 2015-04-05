<?php
	// Verifica que exista una sesión de usuario iniciada, de lo contrario, redirige a login.php
	session_start();
	if(!isset($_SESSION["usuario"])){
		header("Location: login.php");
	}

	if($_SESSION["usuario"][4] == 3){
		header("Location: index.php");
	}

	include('conexion.php'); // Se incluye clase conexión
	include ('Controladores/ControlUsuario.php'); // Se incluye la clase controlador de usuario
	include ('Controladores/ControlProyecto.php'); // Se inclye la clase controlador de proyectos

	$conexion = new Conexion(); // Instancia de la calse conexión
	$controlUsuario = new ControlUsuario(); // Instancia de clase de control de usuarios
	$controlProyecto = new ControlProyecto(); // Instancia de clase de control de proyectos

	$action = $_GET['action']; // Accion a realizar (modificar - eliminar)
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Mantenimiento - Control de Proyectos</title>
	<link href="Resources/favicon.ico" rel="icon" type="image/x-icon" />
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Maven+Pro' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
	<script>
		webshims.setOptions('forms-ext', {types: 'date'});
		webshims.polyfill('forms forms-ext');
	</script>
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
<?php
		$link = $conexion->open(); // Se abre la conexión a la base de datos;
		switch ($action) {
			case 'np':
?>
				<form method="POST" action="Controladores/ControlProyecto.php">
					<input type="hidden" id="action" name="action" value="<?=$action?>">
					<div class="loginInput"><label for="txtNombre">Nombre Proyecto: </label><input type="text" id="txtNombre" name="txtNombre" placeholder="Nombre del proyecto" required></div>
					<div class="loginInput"><label for="txtFechaInicio">Fecha Inicio: </label><input type="date" id="txtFechaInicio" name="txtFechaInicio" placeholder="Fecha inicio" required></div>	
					<div class="loginInput"><label for="txtFechaFin">Fecha Fin: </label><input type="date" id="txtFechaFin" name="txtFechaFin" placeholder="Fecha fin" required></div>
					<div class="loginInput"><label for="txtDetalle">Detalle: </label><textarea id="txtDetalle" name="txtDetalle" placeholder="Detalle" rows="10" required></textarea></div>
					<div class="loginInput"><label for="txtUsuario">Encargado: </label><select id="txtUsuario" name="txtUsuario" required>
<?php
					$result = $controlUsuario->obtenerUsuariosPM($link);

					while ($row = pg_fetch_assoc($result)) {
						echo '<option value="'.$row['idUsuario'].'">'.$row['usuario'].'</option>';
					}
?>
					</select></div>
					<div class="buttonContainer"><button type="submit" class="button" id="btnModificarProyecto">Crear</button>
					<a href="index.php" class="button">Cancelar</a></div>
				</form>
<?php
				break;
			case 'nt':
				$id = $_GET['id']; // Id del proyecto al que se le añadira la tarea
?>
				<form method="POST" action="Controladores/ControlProyecto.php">
					<input type="hidden" id="action" name="action" value="<?=$action?>">
					<input type="hidden" id="txtId" name="txtId" value="<?=$id?>">
					<div class="loginInput"><label for="txtNombre">Nombre Tarea: </label><input type="text" id="txtNombre" name="txtNombre" placeholder="Nombre de tarea" required></div>
					<div class="loginInput"><label for="txtTipo">Tipo: </label><input type="text" id="txtTipo" name="txtTipo" placeholder="Tipo de tarea" required></div>
					<div class="loginInput"><label for="txtFechaInicio">Fecha Inicio: </label><input type="date" id="txtFechaInicio" name="txtFechaInicio" placeholder="Fecha inicio" required></div>	
					<div class="loginInput"><label for="txtFechaFin">Fecha Fin: </label><input type="date" id="txtFechaFin" name="txtFechaFin" placeholder="Fecha fin" required></div>
					<div class="loginInput"><label for="txtDetalle">Detalle: </label><textarea id="txtDetalle" name="txtDetalle" placeholder="Detalle" rows="10" required></textarea></div>
					<div class="loginInput"><label for="txtUsuario">Encargado: </label><select id="txtUsuario" name="txtUsuario" required>
<?php
					$result = $controlUsuario->obtenerUsuariosPE($link);

					while ($row = pg_fetch_assoc($result)){
						echo '<option value="'.$row['idUsuario'].'">'.$row['usuario'].'</option>';
					}
?>
					</select></div>
					<div class="buttonContainer"><button type="submit" class="button" id="btnModificarProyecto">Crear</button>
					<a href="index.php" class="button">Cancelar</a></div>
				</form>				
<?php
				break;
			case 'mp':
				$id = $_GET['id']; // Id del proyecto-actividad a modificar-eliminar
				$proyecto = pg_fetch_assoc($controlProyecto->obtenerProyecto($link, $id));
?>
				<form method="POST" action="Controladores/ControlProyecto.php">
					<input type="hidden" id="action" name="action" value="<?=$action?>">
					<input type="hidden" id="txtId" name="txtId" value="<?=$id?>">
					<div class="loginInput"><label for="txtNombre">Nombre Proyecto: </label><input type="text" id="txtNombre" name="txtNombre" placeholder="Nombre del proyecto" required value="<?= $proyecto['nombre'] ?>"></div>
					<div class="loginInput"><label for="txtFechaInicio">Fecha Inicio: </label><input type="date" id="txtFechaInicio" name="txtFechaInicio" placeholder="Fecha inicio" required value="<?= $proyecto['fechaInicio'] ?>"></div>	
					<div class="loginInput"><label for="txtFechaFin">Fecha Fin: </label><input type="date" id="txtFechaFin" name="txtFechaFin" placeholder="Fecha fin" required value="<?= $proyecto['fechaFin'] ?>"></div>
					<div class="loginInput"><label for="txtDetalle">Detalle: </label><textarea id="txtDetalle" name="txtDetalle" placeholder="Detalle" rows="10" required><?= $proyecto['detalle'] ?></textarea></div>
					<div class="loginInput"><label for="txtUsuario">Encargado: </label><select id="txtUsuario" name="txtUsuario" required>
<?php
					$result = $controlUsuario->obtenerUsuariosPM($link);

					while ($row = pg_fetch_assoc($result)) {
						if($row['idUsuario']==$proyecto['idUsuario']){
							echo '<option value="'.$row['idUsuario'].'" selected="selected">'.$row['usuario'].'</option>';
						}else{
							echo '<option value="'.$row['idUsuario'].'">'.$row['usuario'].'</option>';
						}
					}
?>
					</select></div>
					<div class="buttonContainer"><button type="submit" class="button" id="btnModificarProyecto">Modificar</button>
					<a href="index.php" class="button">Cancelar</a></div>
				</form>
<?php
				break;
			case 'ep':
				$id = $_GET['id']; // Id del proyecto a eliminar
				$controlProyecto->eliminarProyecto($link, $id);
				header("Location: ../index.php");
				break;
			case 'ma':
				$id = $_GET['id']; // Id de la actividad que se va a modificar
				$actividad = pg_fetch_assoc($controlProyecto->obtenerActividad($link, $id));
?>
				<form method="POST" action="Controladores/ControlProyecto.php">
					<input type="hidden" id="action" name="action" value="<?=$action?>">
					<input type="hidden" id="txtId" name="txtId" value="<?=$id?>">
					<div class="loginInput"><label for="txtNombre">Nombre Tarea: </label><input type="text" id="txtNombre" name="txtNombre" placeholder="Nombre de tarea" required value="<?= $actividad['nombre'] ?>"></div>
					<div class="loginInput"><label for="txtTipo">Tipo: </label><input type="text" id="txtTipo" name="txtTipo" placeholder="Tipo de tarea" required value="<?= $actividad['tipo'] ?>"></div>
					<div class="loginInput"><label for="txtFechaInicio">Fecha Inicio: </label><input type="date" id="txtFechaInicio" name="txtFechaInicio" placeholder="Fecha inicio" required value="<?= $actividad['fechaInicio'] ?>"></div>	
					<div class="loginInput"><label for="txtFechaFin">Fecha Fin: </label><input type="date" id="txtFechaFin" name="txtFechaFin" placeholder="Fecha fin" required value="<?= $actividad['fechaFin'] ?>"></div>
					<div class="loginInput"><label for="txtDetalle">Detalle: </label><textarea id="txtDetalle" name="txtDetalle" placeholder="Detalle" rows="10" required><?= $actividad['descripcion'] ?></textarea></div>
					<div class="loginInput"><label for="txtUsuario">Encargado: </label><select id="txtUsuario" name="txtUsuario" required>
<?php
					$result = $controlUsuario->obtenerUsuariosPE($link);

					while ($row = pg_fetch_assoc($result)){
						if($row['idUsuario']==$actividad['idUsuario']){
							echo '<option value="'.$row['idUsuario'].'" selected="selected">'.$row['usuario'].'</option>';
						}else{
							echo '<option value="'.$row['idUsuario'].'">'.$row['usuario'].'</option>';
						}
					}
?>
					</select></div>
					<div class="buttonContainer"><button type="submit" class="button" id="btnModificarProyecto">Modificar</button>
					<a href="index.php" class="button">Cancelar</a></div>
				</form>				
<?php
				break;
			case 'ea':
				$id = $_GET['id']; // Id del proyecto a eliminar
				$controlProyecto->eliminarActividad($link, $id);
				header("Location: ../index.php");
				break;
			default:
				# code...
				break;
		}
		$conexion->close(); // Se cierra la conexión a la base de datos.
?>
		</div>
	</div>
</body>
</html>

<script>/*
	$("#btnModificarProyecto").click(function(e){ 
	    e.preventDefault();
	    var nom = $("#txtNombre").val();
	    var fechaI = $("#txtFechaInicio").val();
	    var fechaF = $("#txtFechaFin").val();
	    var det = $("#txtDetalle").val();
	    var enc = $("#txtUsuario").val();
	    var li = "<?php echo $link; ?>";
	    var idPro = "<?php echo $id; ?>";
	   	//alert(nom + " " + fechaI + " " + fechaF + " " + det  + " " + enc + " " + li);
	   	$.ajax({url: 'Controladores/ControlProyecto.php',
				data: {nombre : nom, fechaInicio : fechaI, fechaFin : fechaF, detalle : det, encargado : enc, link : li, id : idPro},
				type: 'post',
				complete: function(output) {
					alert(output);
				}
		});
		/*$.post(
			"Controladores/ControlProyecto.php",
			{nombre : nom, fechaInicio : fechaI, fechaFin : fechaF, detalle : det, encargado : enc, link : li, id : idPro},
			function(data){
				alert(data);
			}
		);*/
	});
</script>