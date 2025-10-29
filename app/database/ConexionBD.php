<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;

final class ConexionBD
{
    private static ?PDO $instancia = null;

    public static function obtener(): PDO
    {
        if (self::$instancia instanceof PDO) {
            return self::$instancia;
        }

        $configuracion = require __DIR__ . '/../configuracion/parametros.php';

        try {
            $pdo = new PDO(
                $configuracion['dsn'],
                $configuracion['usuario'],
                $configuracion['clave'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException('No fue posible conectarse a la base de datos', 0, $e);
        }

        return self::$instancia = $pdo;
    }

    private function __construct()
    {
    }
}
