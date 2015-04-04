<?php
// Clase controladora de metodos relacionados a usuarios 
class ControlUsuario{
	
	// Función de LOGIN
	function login($link, $usuario, $password){
		$query = 'select "idUsuario", usuario, nombre, apellido, "idRol", correo from "Usuario" where usuario=\''.$usuario.'\' and password=\''.$password.'\';';
		$result = pg_query($link, $query);
		return $result;
	}

	// Función de Registro
	function registrar($link, $usuario, $password, $correo, $rol, $nombre, $apellido){
		$validate = 'select "usuario" from "Usuario" where usuario=\''.$usuario.'\';';
		$result = pg_query($link, $validate);
		$row = pg_fetch_row($result);
		if(!$row){
			$query = 'insert into "Usuario"(usuario, password, correo, "idRol", nombre, apellido) VALUES (\''.$usuario.'\',\''.$password.'\',\''.$correo.'\','.$rol.',\''.$nombre.'\',\''.$apellido.'\');';
			$insert = pg_query($link, $query);
			return $insert;
		}else{
			return false;
		}
	}

	// Obtiene la lista de roles
	function obtenerRoles($link){
		$query = 'select "idRol", nombre from "Rol" where nombre != \'Administrador\';';
		$result = pg_query($link, $query);
		return $result;
	}

	// Obtener usuarios Project Manager
	function obtenerUsuariosPM($link){
		$query = 'select * from "Usuario" where "Usuario"."idRol" = 2;';
		$result = pg_query($link, $query);
		return $result;
	}

	// Obtener usuarios Project Engineer
	function obtenerUsuariosPE($link){
		$query = 'select * from "Usuario" where "Usuario"."idRol" = 3;';
		$result = pg_query($link, $query);
		return $result;
	}
}
?>