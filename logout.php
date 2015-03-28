<?php

	// Codigo para cerrar sesión.
	session_start();
	unset($_SESSION["usuario"]);
	header("Location: login.php");
?>