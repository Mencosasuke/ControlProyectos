<?php
// Clase controladora de metodos relacionados a usuarios 
class ControlUsuario{
	
	// Función de LOGIN
	function login($link, $usuario, $password){
		$query = 'select "idUsuario", usuario, nombre, apellido, "idRol", correo, password from "Usuario" where usuario=\''.$usuario.'\' and password=\''.$password.'\';';
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

	// Obtiene el rol de un usuario
	function obtenerRol($link, $idRol){
		$query = 'select nombre, "idRol" from "Rol" where "idRol" = '.$idRol.';';
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

	// Modifica información de usuario
	function modificarUsuario($link, $idUsuario, $usuario, $password, $correo, $idRol, $nombre, $apellido){
		$query = 'update "Usuario" set usuario=\''.$usuario.'\', password=\''.$password.'\', correo=\''.$correo.'\', "idRol"='.$idRol.', nombre=\''.$nombre.'\', apellido=\''.$apellido.'\' where "Usuario"."idUsuario" = '.$idUsuario.';';
		$result = pg_query($link, $query);
		return $result;
	}
}

$controlUsuario = new ControlUsuario();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$connection_string = "host=localhost port=5432 dbname=ControlProyectos user=postgres password=123";
	$link = pg_connect($connection_string);

	if($_POST['action'] == 'mu'){
			$idUsuario = $_POST['txtIdUsuario'];
			$nombre = $_POST['txtNombre'];
			$apellido = $_POST['txtApellido'];
			$usuario = $_POST['txtUsuario'];
			$password = $_POST['txtPassword'];
			$correo = $_POST['txtCorreo'];
			$rol = $_POST['txtRol'];
		$controlUsuario->modificarUsuario($link, $idUsuario, $usuario, $password, $correo, $rol, $nombre, $apellido);

		$result = $controlUsuario->login($link, $usuario, $password);
		$row = pg_fetch_row($result);
		session_start();
		$_SESSION["usuario"] = $row;
	}

	pg_close($link);
    header("Location: ../index.php");
}
?>