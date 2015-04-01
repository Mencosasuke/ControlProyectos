<?php
// Clase controlador para manejar procesos de Proyectos
class ControlProyecto{

	// Función para cargar todos los proyectos asignados al Usuario
	function obtenerProyectos($link, $idUsuario){
		$query = 'select "Proyecto"."idProyecto", "Proyecto".nombre, "Proyecto"."fechaInicio", "Proyecto"."fechaFin", "Usuario".usuario, "Proyecto".detalle from "Proyecto", "Usuario" where "Proyecto"."idUsuario" = '.$idUsuario.' and "Usuario"."idUsuario" = "Proyecto"."idUsuario";';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función para obtener las actividades de cada proyecto
	function obtenerActividadesProyecto($link, $idProyecto){
		$query = 'select "Actividad".numero, "Actividad".nombre, "Actividad".tipo, "Actividad"."fechaInicio", "Actividad"."fechaFin", "Usuario".usuario, "Actividad".descripcion, "Actividad"."idActividad" from "Actividad", "Usuario" where "Usuario"."idUsuario" = "Actividad"."idUsuario" and "Actividad"."idProyecto" ='.$idProyecto.';';
		$result = pg_query($link, $query);
		return $result;
	}
}
?>