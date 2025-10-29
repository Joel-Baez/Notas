<?php

namespace App\Models;

final class Materia extends Modelo
{
    public static function todas(): array
    {
        $sql = 'SELECT m.codigo, m.nombre, m.programa, p.nombre AS programa_nombre
                FROM materias m
                JOIN programas p ON p.codigo = m.programa
                ORDER BY m.nombre';
        return self::db()->query($sql)->fetchAll();
    }

    public static function porPrograma(string $codigoPrograma): array
    {
        $sql = 'SELECT codigo, nombre FROM materias WHERE programa = :programa ORDER BY nombre';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['programa' => $codigoPrograma]);
        return $consulta->fetchAll();
    }

    public static function porEstudiante(string $codigoEstudiante): array
    {
        $sql = 'SELECT m.codigo, m.nombre, COALESCE(AVG(n.nota), 0) AS promedio
                FROM estudiantes e
                JOIN materias m ON m.programa = e.programa
                LEFT JOIN notas n ON n.materia = m.codigo AND n.estudiante = e.codigo
                WHERE e.codigo = :estudiante
                GROUP BY m.codigo, m.nombre
                ORDER BY m.nombre';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['estudiante' => $codigoEstudiante]);
        $materias = $consulta->fetchAll();
        foreach ($materias as &$materia) {
            $materia['promedio'] = Nota::formatearPromedio((float) $materia['promedio']);
        }
        return $materias;
    }

    public static function buscar(string $codigo): ?array
    {
        $sql = 'SELECT m.codigo, m.nombre, m.programa, p.nombre AS programa_nombre
                FROM materias m
                JOIN programas p ON p.codigo = m.programa
                WHERE m.codigo = :codigo';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['codigo' => $codigo]);
        $materia = $consulta->fetch();
        if (!$materia) {
            return null;
        }

        $materia['estudiantes'] = Nota::estudiantesPorMateria($codigo);
        return $materia;
    }

    public static function crear(array $datos): bool
    {
        $sql = 'INSERT INTO materias (codigo, nombre, programa) VALUES (:codigo, :nombre, :programa)';
        return self::db()->prepare($sql)->execute([
            'codigo' => $datos['codigo'],
            'nombre' => $datos['nombre'],
            'programa' => $datos['programa'],
        ]);
    }

    public static function actualizar(string $codigo, array $datos): bool
    {
        if (Nota::existenParaMateria($codigo)) {
            return false;
        }

        $sql = 'UPDATE materias SET nombre = :nombre, programa = :programa WHERE codigo = :codigo';
        return self::db()->prepare($sql)->execute([
            'nombre' => $datos['nombre'],
            'programa' => $datos['programa'],
            'codigo' => $codigo,
        ]);
    }

    public static function eliminar(string $codigo): bool
    {
        if (Nota::existenParaMateria($codigo)) {
            return false;
        }

        $sql = 'DELETE FROM materias WHERE codigo = :codigo';
        return self::db()->prepare($sql)->execute(['codigo' => $codigo]);
    }

    public static function perteneceAPrograma(string $codigoMateria, string $codigoPrograma): bool
    {
        $sql = 'SELECT COUNT(*) FROM materias WHERE codigo = :codigo AND programa = :programa';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['codigo' => $codigoMateria, 'programa' => $codigoPrograma]);
        return (bool) $consulta->fetchColumn();
    }
}
