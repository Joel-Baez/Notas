<?php

namespace App\Database;

use PDO;
use PDOException;

final class Conexion
{
    private static ?PDO $conexion = null;

    public static function obtener(): PDO
    {
        if (self::$conexion === null) {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $nombre = getenv('DB_NAME') ?: 'notas_app';
            $usuario = getenv('DB_USER') ?: 'root';
            $clave = getenv('DB_PASSWORD') ?: '';
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $nombre);

            try {
                self::$conexion = new PDO($dsn, $usuario, $clave, $opciones);
            } catch (PDOException $excepcion) {
                throw new PDOException('No fue posible conectar con la base de datos: ' . $excepcion->getMessage());
            }
        }

        return self::$conexion;
    }
}
