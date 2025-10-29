<?php

declare(strict_types=1);

namespace App\Models;

final class MateriaRepositorio extends RepositorioBase
{
    public function todas(): array
    {
        $sql = 'SELECT m.codigo, m.nombre, m.programa, p.nombre AS programa_nombre
                FROM materias m
                JOIN programas p ON p.codigo = m.programa
                ORDER BY p.nombre, m.nombre';
        return $this->db->query($sql)->fetchAll();
    }

    public function porPrograma(string $codigoPrograma): array
    {
        $sentencia = $this->db->prepare('SELECT codigo, nombre FROM materias WHERE programa = :programa ORDER BY nombre');
        $sentencia->execute(['programa' => $codigoPrograma]);
        return $sentencia->fetchAll();
    }

    public function buscar(string $codigo): ?array
    {
        $sentencia = $this->db->prepare('SELECT codigo, nombre, programa FROM materias WHERE codigo = :codigo');
        $sentencia->execute(['codigo' => $codigo]);
        $materia = $sentencia->fetch();
        return $materia ?: null;
    }

    public function crear(array $datos): void
    {
        $sql = 'INSERT INTO materias (codigo, nombre, programa) VALUES (:codigo, :nombre, :programa)';
        $this->db->prepare($sql)->execute([
            'codigo' => $datos['codigo'],
            'nombre' => $datos['nombre'],
            'programa' => $datos['programa'],
        ]);
    }

    public function actualizar(string $codigo, array $datos): bool
    {
        if ($this->poseeRegistros($codigo)) {
            return false;
        }

        $sql = 'UPDATE materias SET nombre = :nombre, programa = :programa WHERE codigo = :codigo';
        $sentencia = $this->db->prepare($sql);
        $sentencia->execute([
            'nombre' => $datos['nombre'],
            'programa' => $datos['programa'],
            'codigo' => $codigo,
        ]);
        return $sentencia->rowCount() > 0;
    }

    public function eliminar(string $codigo): bool
    {
        if ($this->poseeRegistros($codigo)) {
            return false;
        }

        $sentencia = $this->db->prepare('DELETE FROM materias WHERE codigo = :codigo');
        $sentencia->execute(['codigo' => $codigo]);
        return $sentencia->rowCount() > 0;
    }

    public function materiasPorEstudiante(string $codigoEstudiante, string $programa): array
    {
        $sql = 'SELECT m.codigo, m.nombre,
                       COALESCE(ROUND(AVG(n.valor), 2), 0) AS promedio
                FROM materias m
                LEFT JOIN notas n ON n.materia = m.codigo AND n.estudiante = :estudiante
                WHERE m.programa = :programa
                GROUP BY m.codigo, m.nombre
                ORDER BY m.nombre';
        $sentencia = $this->db->prepare($sql);
        $sentencia->execute(['estudiante' => $codigoEstudiante, 'programa' => $programa]);
        return $sentencia->fetchAll();
    }

    private function poseeRegistros(string $codigo): bool
    {
        $sentencia = $this->db->prepare('SELECT COUNT(*) FROM notas WHERE materia = :codigo');
        $sentencia->execute(['codigo' => $codigo]);
        return (int) $sentencia->fetchColumn() > 0;
    }
}
