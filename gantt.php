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

	include ('conexion.php'); // Incluye la clase conexión
	include ('Controladores/ControlProyecto.php'); // Incluye la clase controlador de proyectos

	$conexion = new Conexion(); // Instancia clase Conexión
	$controlProyecto = new ControlProyecto(); // Instancia clase ControlProyecto

	$id = $_GET['id'];

	$link = $conexion->open();

	$result = $controlProyecto->obtenerProyecto($link, $id);
	$row = pg_fetch_assoc($result);

	$result2 = $controlProyecto->obtenerActividadesProyecto($link, $id);
	$actividades =  array();

	while($row2 = pg_fetch_assoc($result2)){
		$actividades[] = $row2;
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Reportes - Control de Proyectos</title>
	
	<link href="Resources/favicon.ico" rel="icon" type="image/x-icon" />
	<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.fn.gantt.min.js"></script>
	<script src="js/moment.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/gantt/style.css">
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

			<div class="Proyecto" data-proyecto='<?= json_encode($row); ?>' data-actividades='<?= json_encode($actividades); ?>'></div>

			<div class="gantt"></div>
		</div>
	</div>

<script>

	var $proyectos = $(".Proyecto"), proyecto, proyectos = [];
	$proyectos.each(function(index, item){
		proyecto = JSON.parse($(item).attr('data-proyecto'));
		proyecto.actividades = JSON.parse($(item).attr('data-actividades'));
		proyectos.push(proyecto);
	});

	console.log(proyectos);

	$(function() {

		"use strict";

		var today = moment();
		var andTwoHours = moment().add("hours",2);

		var today_friendly = "/Date(" + today.valueOf() + ")/";
		var next_friendly = "/Date(" + andTwoHours.valueOf() + ")/";

		//{"idProyecto":"9","nombre":"Proyecto Prueba 1","fechaInicio":"2015-03-01","fechaFin":"2015-04-07","detalle":"Proyecto de prueba #1","idUsuario":"4"}
			//descripcion: "Tarea #1 del Proyecto #1"fechaFin: "2015-03-12"fechaInicio: "2015-03-01"idActividad: "6"nombre: "TAREA 1 PROYECTO 1"numero: "1"tipo: "Tipo 1"usuario: "test"

			var source = [];

			proyectos.forEach(function(item, index){
				source.push({
					name : item.nombre,
					desc : item.detalle,
					values : [{
						from : "/Date(" + item.fechaInicio + ")/",
						to : "/Date("+item.fechaFin+")/",
						label : item.nombre,
						customClass: "ganttRed"
					}]
				});

				source = source.concat(item.actividades.map(function(actividad){
					return {
						name : "",
						desc : actividad.descripcion,
						values : [{
							from : "/Date(" + actividad.fechaInicio + ")/",
							to : "/Date("+actividad.fechaFin+")/",
							label : actividad.nombre
						}]
					};
				}));
			});

			console.log(source);
		$(".gantt").gantt({
			source: source,
			scale: "days",
			minScale: "hours",
			maxScale: "months",
			navigate: "scroll"
		});

	});

</script>

</body>
</html>