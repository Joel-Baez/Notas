<?php

namespace App\Models;

use App\Database\Conexion;
use PDO;

abstract class Modelo
{
    protected static function db(): PDO
    {
        return Conexion::obtener();
    }

    protected static function contar(string $tabla, string $columna, string $valor): int
    {
        $sql = "SELECT COUNT(*) FROM {$tabla} WHERE {$columna} = :valor";
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['valor' => $valor]);
        return (int) $consulta->fetchColumn();
    }
}
