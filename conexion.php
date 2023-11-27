<?php
class Conexion
{
    private static $host = "localhost";
    private static $usuario = "studium";
    private static $contrasena = "studium__";
    private static $nombreBD = "studium_dws_p2";
    private static $conexion;

    // Método para conectar a la base de datos
    public static function conectar()
    {
        self::$conexion = new mysqli(self::$host, self::$usuario, self::$contrasena, self::$nombreBD);

        // Verificar la conexión
        if (self::$conexion->connect_error) {
            die("Error de conexión: " . self::$conexion->connect_error);
        }

        return self::$conexion;
    }
}
