<?php
// Clase conexión para iniciar y cerrar conexiones a la base de datos PostgreSQL
class Conexion{

    // Cadena de conexión a la base de datos de POSTGRES
    var $connection_string = "host=localhost port=5432 dbname=ControlProyectos user=postgres password=123";
    var $conexion; // Variable que obtiene la conexión

    // Función para conectar a la base de datos
    function open(){

        // Conexión a la base de datos
        $link = pg_connect($this->connection_string);

        // Prueba la conexión
        if(!$link){
            die ("Imposible conectar a la base de datos.");
        }else{
            $this->conexion = $link;
        }

        // Devuelve la conexión establecida
        return $this->conexion;
    }

    /*
    function selectDatabase() // selecting the database.
    {
        mysql_select_db($this->database);  //use php inbuild functions for select database

        if(mysql_error()) // if error occured display the error message
        {

            echo "Cannot find the database ".$this->database;

        }
         echo "Database selected..";       
    }
    */

    // Cierra la conexión a la base de datos Postgres
    function close(){
        pg_close($this->conexion);
    }
}
?>