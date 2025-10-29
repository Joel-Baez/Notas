<?php

namespace App\Models;

use PDO;

final class Programa extends Modelo
{
    public static function todos(): array
    {
        $sql = 'SELECT codigo, nombre FROM programas ORDER BY nombre';
        return self::db()->query($sql)->fetchAll();
    }

    public static function buscar(string $codigo): ?array
    {
        $sql = 'SELECT codigo, nombre FROM programas WHERE codigo = :codigo';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['codigo' => $codigo]);
        $programa = $consulta->fetch();
        return $programa ?: null;
    }

    public static function crear(array $datos): bool
    {
        $sql = 'INSERT INTO programas (codigo, nombre) VALUES (:codigo, :nombre)';
        return self::db()->prepare($sql)->execute([
            'codigo' => $datos['codigo'],
            'nombre' => $datos['nombre'],
        ]);
    }

    public static function actualizar(string $codigo, string $nombre): bool
    {
        if (self::tieneRelaciones($codigo)) {
            return false;
        }

        $sql = 'UPDATE programas SET nombre = :nombre WHERE codigo = :codigo';
        return self::db()->prepare($sql)->execute([
            'nombre' => $nombre,
            'codigo' => $codigo,
        ]);
    }

    public static function eliminar(string $codigo): bool
    {
        if (self::tieneRelaciones($codigo)) {
            return false;
        }

        $sql = 'DELETE FROM programas WHERE codigo = :codigo';
        return self::db()->prepare($sql)->execute(['codigo' => $codigo]);
    }

    public static function resumen(string $codigo): ?array
    {
        $programa = self::buscar($codigo);
        if (!$programa) {
            return null;
        }

        $programa['materias'] = Materia::porPrograma($codigo);
        $programa['estudiantes'] = Estudiante::porPrograma($codigo);
        return $programa;
    }

    private static function tieneRelaciones(string $codigo): bool
    {
        return self::contar('estudiantes', 'programa', $codigo) > 0
            || self::contar('materias', 'programa', $codigo) > 0;
    }
}
