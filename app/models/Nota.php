<?php

namespace App\Models;

final class Nota extends Modelo
{
    public static function registrar(array $datos): bool
    {
        $sql = 'INSERT INTO notas (materia, estudiante, actividad, nota)
                VALUES (:materia, :estudiante, :actividad, :nota)';
        return self::db()->prepare($sql)->execute([
            'materia' => $datos['materia'],
            'estudiante' => $datos['estudiante'],
            'actividad' => $datos['actividad'],
            'nota' => self::normalizar($datos['nota']),
        ]);
    }

    public static function actualizar(int $id, float $nota): bool
    {
        $sql = 'UPDATE notas SET nota = :nota WHERE id = :id';
        return self::db()->prepare($sql)->execute([
            'nota' => self::normalizar($nota),
            'id' => $id,
        ]);
    }

    public static function eliminar(int $id): bool
    {
        $sql = 'DELETE FROM notas WHERE id = :id';
        return self::db()->prepare($sql)->execute(['id' => $id]);
    }

    public static function eliminarPorEstudiante(string $estudiante): bool
    {
        $sql = 'DELETE FROM notas WHERE estudiante = :estudiante';
        return self::db()->prepare($sql)->execute(['estudiante' => $estudiante]);
    }

    public static function porEstudiante(string $codigoEstudiante): array
    {
        $sql = 'SELECT n.id, n.materia, m.nombre AS materia_nombre, n.actividad, n.nota
                FROM notas n
                JOIN materias m ON m.codigo = n.materia
                WHERE n.estudiante = :estudiante
                ORDER BY m.nombre, n.actividad';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['estudiante' => $codigoEstudiante]);
        return $consulta->fetchAll();
    }

    public static function todas(): array
    {
        $sql = 'SELECT n.id, n.materia, m.nombre AS materia_nombre, n.estudiante, e.nombre AS estudiante_nombre,
                       n.actividad, n.nota
                FROM notas n
                JOIN estudiantes e ON e.codigo = n.estudiante
                JOIN materias m ON m.codigo = n.materia
                ORDER BY e.nombre, m.nombre, n.actividad';
        $registros = self::db()->query($sql)->fetchAll();
        foreach ($registros as &$registro) {
            $registro['nota'] = self::formatearPromedio((float) $registro['nota']);
        }
        return $registros;
    }

    public static function estudiantesPorMateria(string $codigoMateria): array
    {
        $sql = 'SELECT e.codigo, e.nombre, AVG(n.nota) AS promedio
                FROM notas n
                JOIN estudiantes e ON e.codigo = n.estudiante
                WHERE n.materia = :materia
                GROUP BY e.codigo, e.nombre
                ORDER BY e.nombre';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['materia' => $codigoMateria]);
        $estudiantes = $consulta->fetchAll();
        foreach ($estudiantes as &$estudiante) {
            $estudiante['promedio'] = self::formatearPromedio($estudiante['promedio']);
        }
        return $estudiantes;
    }

    public static function resumen(): array
    {
        $sql = 'SELECT n.estudiante, e.nombre AS estudiante_nombre, n.materia, m.nombre AS materia_nombre,
                       AVG(n.nota) AS promedio
                FROM notas n
                JOIN estudiantes e ON e.codigo = n.estudiante
                JOIN materias m ON m.codigo = n.materia
                GROUP BY n.estudiante, e.nombre, n.materia, m.nombre
                ORDER BY e.nombre, m.nombre';
        $resumen = self::db()->query($sql)->fetchAll();
        foreach ($resumen as &$fila) {
            $fila['promedio'] = self::formatearPromedio($fila['promedio']);
        }
        return $resumen;
    }

    public static function promedioPorMateria(string $codigoMateria, string $codigoEstudiante): float
    {
        $sql = 'SELECT AVG(nota) FROM notas WHERE materia = :materia AND estudiante = :estudiante';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['materia' => $codigoMateria, 'estudiante' => $codigoEstudiante]);
        return self::formatearPromedio($consulta->fetchColumn() ?: 0.0);
    }

    public static function promedioGeneral(string $codigoEstudiante): float
    {
        $sql = 'SELECT AVG(promedio) FROM (
                    SELECT AVG(nota) AS promedio
                    FROM notas
                    WHERE estudiante = :estudiante
                    GROUP BY materia
                ) promedios';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['estudiante' => $codigoEstudiante]);
        $promedio = $consulta->fetchColumn();
        return self::formatearPromedio($promedio ?: 0.0);
    }

    public static function obtener(int $id): ?array
    {
        $sql = 'SELECT id, materia, estudiante, actividad, nota FROM notas WHERE id = :id';
        $consulta = self::db()->prepare($sql);
        $consulta->execute(['id' => $id]);
        $nota = $consulta->fetch();
        return $nota ?: null;
    }

    public static function existenParaEstudiante(string $codigoEstudiante): bool
    {
        return self::contar('notas', 'estudiante', $codigoEstudiante) > 0;
    }

    public static function existenParaMateria(string $codigoMateria): bool
    {
        return self::contar('notas', 'materia', $codigoMateria) > 0;
    }

    public static function formatearPromedio(float $promedio): float
    {
        return round($promedio, 2);
    }

    private static function normalizar(float $valor): float
    {
        $limpio = max(0.01, min(5.00, $valor));
        return self::formatearPromedio($limpio);
    }
}
