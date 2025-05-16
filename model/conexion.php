<?php


class BD {
    private $conexion;

    public function __construct() {
        $usuario = "root";
        $contrasenia = "123";
        $dsn = "mysql:host=localhost;dbname=TFG";

        try {
            $this->conexion = new PDO($dsn, $usuario, $contrasenia);//hacemos la conexion a la base de datos con "new PDO()"
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function iniciar_Conexion() { //hacemos una function de iniciar la conexion 
        return $this->conexion;
    }

    public function cerrar_conexion(){//hacemos una function de cerrar la conexion 
        return $this->conexion=null;
    }
}



   
?>