<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Grade
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(array $data, array &$errors = []): bool
    {
        if (!$this->validateScore($data['nota'])) {
            $errors[] = 'La nota debe ser un número mayor a 0 y menor a 5 con máximo dos decimales.';
            return false;
        }

        $stmt = $this->db->prepare('INSERT INTO notas (materia, estudiante, actividad, nota) VALUES (:materia, :estudiante, :actividad, :nota)');
        return $stmt->execute([
            'materia' => $data['materia'],
            'estudiante' => $data['estudiante'],
            'actividad' => $data['actividad'],
            'nota' => $data['nota'],
        ]);
    }

    public function update(string $subject, string $student, string $activity, float $grade, array &$errors = []): bool
    {
        if (!$this->validateScore($grade)) {
            $errors[] = 'La nota debe ser un número mayor a 0 y menor a 5 con máximo dos decimales.';
            return false;
        }

        $stmt = $this->db->prepare('UPDATE notas SET nota = :nota WHERE materia = :materia AND estudiante = :estudiante AND actividad = :actividad');
        return $stmt->execute([
            'nota' => $grade,
            'materia' => $subject,
            'estudiante' => $student,
            'actividad' => $activity,
        ]);
    }

    public function delete(string $subject, string $student, string $activity): bool
    {
        $stmt = $this->db->prepare('DELETE FROM notas WHERE materia = :materia AND estudiante = :estudiante AND actividad = :actividad');
        return $stmt->execute([
            'materia' => $subject,
            'estudiante' => $student,
            'actividad' => $activity,
        ]);
    }

    public function find(string $subject, string $student, string $activity): ?array
    {
        $stmt = $this->db->prepare('SELECT n.*, m.nombre AS materia_nombre, e.nombre AS estudiante_nombre FROM notas n INNER JOIN materias m ON m.codigo = n.materia INNER JOIN estudiantes e ON e.codigo = n.estudiante WHERE n.materia = :materia AND n.estudiante = :estudiante AND n.actividad = :actividad');
        $stmt->execute([
            'materia' => $subject,
            'estudiante' => $student,
            'actividad' => $activity,
        ]);

        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function allByStudent(string $student): array
    {
        $stmt = $this->db->prepare('SELECT n.*, m.nombre AS materia_nombre, e.nombre AS estudiante_nombre FROM notas n INNER JOIN materias m ON m.codigo = n.materia INNER JOIN estudiantes e ON e.codigo = n.estudiante WHERE n.estudiante = :estudiante ORDER BY m.nombre, n.actividad');
        $stmt->execute(['estudiante' => $student]);
        return $stmt->fetchAll();
    }

    public function allBySubject(string $subject): array
    {
        $stmt = $this->db->prepare('SELECT n.*, e.nombre AS estudiante_nombre FROM notas n INNER JOIN estudiantes e ON e.codigo = n.estudiante WHERE n.materia = :materia ORDER BY e.nombre, n.actividad');
        $stmt->execute(['materia' => $subject]);
        return $stmt->fetchAll();
    }

    public function getStudentSubjectAverages(string $student): array
    {
        $sql = 'SELECT m.codigo, m.nombre, IFNULL(ROUND(AVG(n.nota), 2), 0) AS promedio
                FROM materias m
                INNER JOIN notas n ON n.materia = m.codigo
                WHERE n.estudiante = :estudiante
                GROUP BY m.codigo, m.nombre
                ORDER BY m.nombre';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['estudiante' => $student]);
        return $stmt->fetchAll();
    }

    public function getProgramSubjectsWithAverageForStudent(string $programCode, string $student): array
    {
        $sql = 'SELECT m.codigo, m.nombre, IFNULL(ROUND(AVG(n.nota), 2), 0) AS promedio
                FROM materias m
                LEFT JOIN notas n ON n.materia = m.codigo AND n.estudiante = :estudiante
                WHERE m.programa = :programa
                GROUP BY m.codigo, m.nombre
                ORDER BY m.nombre';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['programa' => $programCode, 'estudiante' => $student]);
        return $stmt->fetchAll();
    }

    public function getSubjectStudentAverages(string $subject): array
    {
        $sql = 'SELECT e.codigo, e.nombre, IFNULL(ROUND(AVG(n.nota), 2), 0) AS promedio
                FROM estudiantes e
                INNER JOIN notas n ON n.estudiante = e.codigo
                WHERE n.materia = :materia
                GROUP BY e.codigo, e.nombre
                ORDER BY e.nombre';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['materia' => $subject]);
        return $stmt->fetchAll();
    }

    public function getAverageForStudentAndSubject(string $student, string $subject): float
    {
        $stmt = $this->db->prepare('SELECT ROUND(IFNULL(AVG(nota), 0), 2) FROM notas WHERE materia = :materia AND estudiante = :estudiante');
        $stmt->execute(['materia' => $subject, 'estudiante' => $student]);
        return (float) $stmt->fetchColumn();
    }

    public function deleteAllForStudent(string $student): bool
    {
        $stmt = $this->db->prepare('DELETE FROM notas WHERE estudiante = :estudiante');
        return $stmt->execute(['estudiante' => $student]);
    }

    private function validateScore(float|string $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        $number = (float) $value;
        if ($number <= 0 || $number >= 5) {
            return false;
        }

        $decimalPart = explode('.', (string) $value)[1] ?? '';
        return strlen($decimalPart) <= 2;
    }
}
