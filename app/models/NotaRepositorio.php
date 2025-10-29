<?php

declare(strict_types=1);

namespace App\Models;

final class NotaRepositorio extends RepositorioBase
{
    public function listado(): array
    {
        $sql = 'SELECT n.id, n.materia, n.estudiante, n.actividad, n.valor,
                       m.nombre AS materia_nombre, e.nombre AS estudiante_nombre
                FROM notas n
                JOIN materias m ON m.codigo = n.materia
                JOIN estudiantes e ON e.codigo = n.estudiante
                ORDER BY m.nombre, e.nombre, n.actividad';
        return $this->db->query($sql)->fetchAll();
    }

    public function resumenPromedios(): array
    {
        $sql = 'SELECT m.codigo AS materia, m.nombre AS materia_nombre,
                       e.codigo AS estudiante, e.nombre AS estudiante_nombre,
                       ROUND(AVG(n.valor), 2) AS promedio
                FROM notas n
                JOIN materias m ON m.codigo = n.materia
                JOIN estudiantes e ON e.codigo = n.estudiante
                GROUP BY m.codigo, m.nombre, e.codigo, e.nombre
                ORDER BY m.nombre, e.nombre';
        return $this->db->query($sql)->fetchAll();
    }

    public function promediosDeMateria(string $codigoMateria): array
    {
        $sql = 'SELECT e.codigo, e.nombre, ROUND(AVG(n.valor), 2) AS promedio
                FROM notas n
                JOIN estudiantes e ON e.codigo = n.estudiante
                WHERE n.materia = :materia
                GROUP BY e.codigo, e.nombre
                ORDER BY e.nombre';
        $sentencia = $this->db->prepare($sql);
        $sentencia->execute(['materia' => $codigoMateria]);
        return $sentencia->fetchAll();
    }

    public function notasDeEstudiante(string $codigoEstudiante): array
    {
        $sql = 'SELECT n.id, n.actividad, n.valor, m.codigo AS materia, m.nombre AS materia_nombre
                FROM notas n
                JOIN materias m ON m.codigo = n.materia
                WHERE n.estudiante = :estudiante
                ORDER BY m.nombre, n.actividad';
        $sentencia = $this->db->prepare($sql);
        $sentencia->execute(['estudiante' => $codigoEstudiante]);
        return $sentencia->fetchAll();
    }

    public function registrar(array $datos): void
    {
        $sql = 'INSERT INTO notas (materia, estudiante, actividad, valor) VALUES (:materia, :estudiante, :actividad, :valor)';
        $this->db->prepare($sql)->execute([
            'materia' => $datos['materia'],
            'estudiante' => $datos['estudiante'],
            'actividad' => $datos['actividad'],
            'valor' => $datos['valor'],
        ]);
    }

    public function buscar(int $id): ?array
    {
        $sentencia = $this->db->prepare('SELECT n.id, n.materia, n.estudiante, n.actividad, n.valor,
                m.nombre AS materia_nombre, e.nombre AS estudiante_nombre
            FROM notas n
            JOIN materias m ON m.codigo = n.materia
            JOIN estudiantes e ON e.codigo = n.estudiante
            WHERE n.id = :id');
        $sentencia->execute(['id' => $id]);
        $nota = $sentencia->fetch();
        return $nota ?: null;
    }

    public function actualizarValor(int $id, float $valor): bool
    {
        $sentencia = $this->db->prepare('UPDATE notas SET valor = :valor WHERE id = :id');
        $sentencia->execute(['valor' => $valor, 'id' => $id]);
        return $sentencia->rowCount() > 0;
    }

    public function eliminar(int $id): bool
    {
        $sentencia = $this->db->prepare('DELETE FROM notas WHERE id = :id');
        $sentencia->execute(['id' => $id]);
        return $sentencia->rowCount() > 0;
    }

    public function eliminarPorEstudiante(string $codigo): void
    {
        $sentencia = $this->db->prepare('DELETE FROM notas WHERE estudiante = :estudiante');
        $sentencia->execute(['estudiante' => $codigo]);
    }

    public function relacionValida(string $estudiante, string $materia): bool
    {
        $sql = 'SELECT COUNT(*)
                FROM estudiantes e
                JOIN materias m ON m.programa = e.programa
                WHERE e.codigo = :estudiante AND m.codigo = :materia';
        $sentencia = $this->db->prepare($sql);
        $sentencia->execute(['estudiante' => $estudiante, 'materia' => $materia]);
        return (int) $sentencia->fetchColumn() > 0;
    }
}
