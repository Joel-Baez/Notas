<?php

namespace App\Models;

final class Estudiante extends Modelo
{
    public static function todos(): array
    {
        $sql = 'SELECT e.codigo, e.nombre, e.email, e.programa, p.nombre AS programa_nombre
                FROM estudiantes e
                JOIN programas p ON p.codigo = e.programa
                ORDER BY e.nombre';
        return self::db()->query($sql)->fetchAll();
    }

    public static function porPrograma(string $codigoPrograma): array
    {
        $sql = 'SELECT codigo, nombre, email FROM estudiantes WHERE programa = :programa ORDER BY nombre';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['programa' => $codigoPrograma]);
        return $consulta->fetchAll();
    }

    public static function buscar(string $codigo): ?array
    {
        $sql = 'SELECT e.codigo, e.nombre, e.email, e.programa, p.nombre AS programa_nombre
                FROM estudiantes e
                JOIN programas p ON p.codigo = e.programa
                WHERE e.codigo = :codigo';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['codigo' => $codigo]);
        $estudiante = $consulta->fetch();
        if (!$estudiante) {
            return null;
        }

        $estudiante['materias'] = Materia::porEstudiante($codigo);
        $estudiante['notas'] = Nota::porEstudiante($codigo);
        $estudiante['promedio'] = Nota::promedioGeneral($codigo);
        return $estudiante;
    }

    public static function crear(array $datos): bool
    {
        $sql = 'INSERT INTO estudiantes (codigo, nombre, email, programa)
                VALUES (:codigo, :nombre, :email, :programa)';
        return self::db()->prepare($sql)->execute([
            'codigo' => $datos['codigo'],
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'programa' => $datos['programa'],
        ]);
    }

    public static function actualizar(string $codigo, array $datos): bool
    {
        if (Nota::existenParaEstudiante($codigo)) {
            return false;
        }

        $sql = 'UPDATE estudiantes SET nombre = :nombre, email = :email, programa = :programa WHERE codigo = :codigo';
        return self::db()->prepare($sql)->execute([
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'programa' => $datos['programa'],
            'codigo' => $codigo,
        ]);
    }

    public static function eliminar(string $codigo): bool
    {
        if (Nota::existenParaEstudiante($codigo)) {
            return false;
        }

        $sql = 'DELETE FROM estudiantes WHERE codigo = :codigo';
        return self::db()->prepare($sql)->execute(['codigo' => $codigo]);
    }
}
