<?php
namespace Src;
use PDO;
use PDOException;

class Conexion {
    protected static $conexion;

    public function __construct()
    {
        if(self::$conexion == null) {
            self::crearConexion();
        }
    }

    public static function crearConexion() {
        //1.- Leemos la configuracion de config
        $fichero = dirname(__DIR__, 1)."/.config";
        $opciones = parse_ini_file($fichero);
        $dbname = $opciones['bbdd'];
        $host = $opciones['host'];
        $usuario = $opciones['usuario'];
        //2.- me creo el dns descriptor de nombre de servicio
        $dns = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try {
            self::$conexion = new PDO($dns, $usuario);
            //solo en desarrollo
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $ex) {
            die("Error en la conexion".$ex->getMessage());
        }
    }
}