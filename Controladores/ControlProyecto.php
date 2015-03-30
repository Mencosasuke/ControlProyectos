<?php
// Clase controlador para manejar procesos de Proyectos
class ControlProyecto{

	// Función para cargar todos los proyectos asignados al Usuario
	function obtenerProyectos($link, $idUsuario){
		$query = 'select * from "Proyecto" where "idUsuario" = \''.$idUsuario.'\';';
		$result = pg_query($link, $query);
		return $result;
	}

}
?>