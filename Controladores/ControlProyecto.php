<?php
// Clase controlador para manejar procesos de Proyectos
class ControlProyecto{

	// Función para cargar todos los proyectos asignados al Usuario
	function obtenerProyectos($link, $idUsuario){
		$query = 'select "Proyecto"."idProyecto", "Proyecto".nombre, "Proyecto"."fechaInicio", "Proyecto"."fechaFin", "Usuario".usuario, "Proyecto".detalle from "Proyecto", "Usuario" where "Proyecto"."idUsuario" = '.$idUsuario.' and "Usuario"."idUsuario" = "Proyecto"."idUsuario" order by "Proyecto"."idProyecto" asc;';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para obtener los proyectos a los que esta asignado un PE
	function obtenerProyectosPE($link, $idUsuario){
		$query = 'select distinct "Proyecto"."idProyecto", "Proyecto".nombre, "Proyecto"."fechaInicio", "Proyecto"."fechaFin", "Usuario".usuario, "Proyecto".detalle from "Proyecto", "Usuario", "Actividad" where "Actividad"."idUsuario" = '.$idUsuario.' and "Usuario"."idUsuario" = "Actividad"."idUsuario" AND "Proyecto"."idProyecto" = "Actividad"."idProyecto" order by "Proyecto"."idProyecto" asc;';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para obtener las actividades de cada proyecto
	function obtenerActividadesProyecto($link, $idProyecto){
		$query = 'select "Actividad".numero, "Actividad".nombre, "Actividad".tipo, "Actividad"."fechaInicio", "Actividad"."fechaFin", "Usuario".usuario, "Actividad".descripcion, "Actividad"."idActividad" from "Actividad", "Usuario" where "Usuario"."idUsuario" = "Actividad"."idUsuario" and "Actividad"."idProyecto" ='.$idProyecto.' order by "Actividad".numero asc;';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para obtener las actividades correspondientes a los PE
	function obtenerActividadesProyectoPE($link, $idProyecto, $idUsuario){
		$query = 'select "Actividad".numero, "Actividad".nombre, "Actividad".tipo, "Actividad"."fechaInicio", "Actividad"."fechaFin", "Usuario".usuario, "Actividad".descripcion, "Actividad"."idActividad" from "Actividad", "Usuario" where "Usuario"."idUsuario" = "Actividad"."idUsuario" and "Actividad"."idProyecto" ='.$idProyecto.' and "Actividad"."idUsuario" = '.$idUsuario.' order by "Actividad".numero asc;';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para obtener un proyecto especifico
	function obtenerProyecto($link, $idProyecto){
		$query = 'select * from "Proyecto" where "Proyecto"."idProyecto" = '.$idProyecto.';';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para obtener una actividad especifica
	function obtenerActividad($link, $idActividad){
		$query = 'select * from "Actividad" where "Actividad"."idActividad" = '.$idActividad.';';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para modificar Proyecto
	function modificarProyecto($link, $id, $nombre, $fechaInicio, $fechaFin, $detalle, $encargado){
		$query = 'update "Proyecto" set nombre=\''.$nombre.'\', "fechaInicio"=\''.$fechaInicio.'\', "fechaFin"=\''.$fechaFin.'\', detalle=\''.$detalle.'\', "idUsuario"='.$encargado.' where "idProyecto" = '.$id.';';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para modificar Actividad
	function modificarActividad($link, $id, $nombre, $tipo, $fechaInicio, $fechaFin, $detalle, $encargado){
		$query = 'update "Actividad" set tipo=\''.$tipo.'\', "fechaInicio"=\''.$fechaInicio.'\', "fechaFin"=\''.$fechaFin.'\', "idUsuario"='.$encargado.', descripcion=\''.$detalle.'\', nombre=\''.$nombre.'\' where "idActividad"='.$id.';';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para agregar Proyecto
	function agregarProyecto($link, $nombre, $fechaInicio, $fechaFin, $detalle, $encargado){
		$query = 'insert into "Proyecto"(nombre, "fechaInicio", "fechaFin", detalle, "idUsuario") VALUES (\''.$nombre.'\', \''.$fechaInicio.'\', \''.$fechaFin.'\', \''.$detalle.'\', '.$encargado.');';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para agregar Tarea
	function agregarTarea($link, $id, $nombre, $tipo, $fechaInicio, $fechaFin, $detalle, $encargado){
		$query = 'insert into "Actividad"("idProyecto", tipo, "fechaInicio", "fechaFin", "idUsuario", descripcion, nombre) values ('.$id.', \''.$tipo.'\', \''.$fechaInicio.'\', \''.$fechaFin.'\', '.$encargado.', \''.$detalle.'\', \''.$nombre.'\');';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para eliminar Proyecto
	function eliminarProyecto($link, $id){
		$query = 'delete from "Proyecto" where "idProyecto"='.$id.';';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para eliminar Actividad
	function eliminarActividad($link, $id){
		$query = 'delete from "Actividad" where "idActividad"='.$id.';';
		$result = pg_query($link, $query);
		return $result;
	}
}

$controlProyecto = new ControlProyecto();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$connection_string = "host=localhost port=5432 dbname=ControlProyectos user=postgres password=123";
	$link = pg_connect($connection_string);

	switch ($_POST['action']) {
		case 'mp':
			$id = $_POST['txtId'];
			$nombre = $_POST['txtNombre'];
			$fechaInicio = $_POST['txtFechaInicio'];
			$fechaFin = $_POST['txtFechaFin'];
			$detalle = $_POST['txtDetalle'];
			$encargado = $_POST['txtUsuario'];
			$controlProyecto->modificarProyecto($link, $id, $nombre, $fechaInicio, $fechaFin, $detalle, $encargado);
			break;
		case 'np':
			$nombre = $_POST['txtNombre'];
			$fechaInicio = $_POST['txtFechaInicio'];
			$fechaFin = $_POST['txtFechaFin'];
			$detalle = $_POST['txtDetalle'];
			$encargado = $_POST['txtUsuario'];
			$controlProyecto->agregarProyecto($link, $nombre, $fechaInicio, $fechaFin, $detalle, $encargado);
			break;
		case 'nt':
			$id = $_POST['txtId'];
			$nombre = $_POST['txtNombre'];
			$tipo = $_POST['txtTipo'];
			$fechaInicio = $_POST['txtFechaInicio'];
			$fechaFin = $_POST['txtFechaFin'];
			$detalle = $_POST['txtDetalle'];
			$encargado = $_POST['txtUsuario'];
			$controlProyecto->agregarTarea($link, $id, $nombre, $tipo, $fechaInicio, $fechaFin, $detalle, $encargado);
			break;
		case 'ma':
			$id = $_POST['txtId'];
			$nombre = $_POST['txtNombre'];
			$tipo = $_POST['txtTipo'];
			$fechaInicio = $_POST['txtFechaInicio'];
			$fechaFin = $_POST['txtFechaFin'];
			$detalle = $_POST['txtDetalle'];
			$encargado = $_POST['txtUsuario'];
			$controlProyecto->modificarActividad($link, $id, $nombre, $tipo, $fechaInicio, $fechaFin, $detalle, $encargado);
			break;
		default:
			# code...
			break;
	}

    pg_close($link);
    header("Location: ../index.php");
}
?>