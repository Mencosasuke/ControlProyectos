<?php
// Clase controladora de metodos relacionados a usuarios 
class ControlUsuario{
	
	// Función de LOGIN
	function login($link, $usuario, $password){
		$query = 'select usuario, nombre, apellido, "idRol", correo from "Usuario" where usuario=\''.$usuario.'\' and password=\''.$password.'\';';
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
			$validate = 'select "usuario" from "Usuario" where usuario=\''.$usuario.'\';';
			$resutl = pg_query($link, $validate);
			$row = pg_fetch_row($result);
			return $resutl;
		}
		return false;
	}

	// Obtiene la lista de roles
	function obtenerRoles($link){
		$query = 'select "idRol", nombre from "Rol" where nombre != \'Administrador\';';
		$result = pg_query($link, $query);
		return $result;
	}
}
?>