<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Subject
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM materias ORDER BY nombre');
        return $stmt->fetchAll();
    }

    public function allByProgram(string $programCode): array
    {
        $stmt = $this->db->prepare('SELECT * FROM materias WHERE programa = :programa ORDER BY nombre');
        $stmt->execute(['programa' => $programCode]);
        return $stmt->fetchAll();
    }

    public function find(string $code): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM materias WHERE codigo = :codigo');
        $stmt->execute(['codigo' => $code]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO materias (codigo, nombre, programa) VALUES (:codigo, :nombre, :programa)');
        return $stmt->execute([
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'programa' => $data['programa'],
        ]);
    }

    public function update(string $code, array $data, array &$errors = []): bool
    {
        if ($this->hasGrades($code)) {
            $errors[] = 'No es posible modificar la materia porque tiene notas registradas.';
            return false;
        }

        if ($this->hasStudentsRelated($code)) {
            $errors[] = 'No es posible modificar la materia porque tiene estudiantes relacionados.';
            return false;
        }

        $stmt = $this->db->prepare('UPDATE materias SET nombre = :nombre, programa = :programa WHERE codigo = :codigo');
        return $stmt->execute([
            'codigo' => $code,
            'nombre' => $data['nombre'],
            'programa' => $data['programa'],
        ]);
    }

    public function delete(string $code, array &$errors = []): bool
    {
        if ($this->hasGrades($code) || $this->hasStudentsRelated($code)) {
            $errors[] = 'No es posible eliminar la materia porque tiene estudiantes o notas relacionadas.';
            return false;
        }

        $stmt = $this->db->prepare('DELETE FROM materias WHERE codigo = :codigo');
        return $stmt->execute(['codigo' => $code]);
    }

    public function hasGrades(string $code): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM notas WHERE materia = :codigo');
        $stmt->execute(['codigo' => $code]);
        return (bool) $stmt->fetchColumn();
    }

    private function hasStudentsRelated(string $code): bool
    {
        // Actualmente no hay una tabla directa de estudiantes-materias, se asume relación por notas.
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM notas WHERE materia = :codigo');
        $stmt->execute(['codigo' => $code]);
        return (bool) $stmt->fetchColumn();
    }
}
