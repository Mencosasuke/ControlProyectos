<?php
// Clase controladora de metodos relacionados a usuarios 
class ControlUsuario{
	
	// Función de LOGIN
	function login($link, $usuario, $password){
		$query = 'select "usuario" from "Usuario" where usuario=\''.$usuario.'\' and password=\''.$password.'\';';
		$result = pg_query($link, $query);
		return $result;
	}
}
?>