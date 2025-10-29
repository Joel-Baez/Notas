<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Program
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM programas ORDER BY nombre');
        return $stmt->fetchAll();
    }

    public function find(string $code): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM programas WHERE codigo = :codigo');
        $stmt->execute(['codigo' => $code]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO programas (codigo, nombre) VALUES (:codigo, :nombre)');
        return $stmt->execute([
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
        ]);
    }

    public function update(string $code, array $data, array &$errors = []): bool
    {
        if ($this->hasStudents($code)) {
            $errors[] = 'No es posible modificar el programa porque tiene estudiantes relacionados.';
            return false;
        }

        if ($this->hasSubjects($code)) {
            $errors[] = 'No es posible modificar el programa porque tiene materias relacionadas.';
            return false;
        }

        $stmt = $this->db->prepare('UPDATE programas SET nombre = :nombre WHERE codigo = :codigo');
        return $stmt->execute([
            'codigo' => $code,
            'nombre' => $data['nombre'],
        ]);
    }

    public function delete(string $code, array &$errors = []): bool
    {
        if ($this->hasStudents($code) || $this->hasSubjects($code)) {
            $errors[] = 'No es posible eliminar el programa porque tiene materias o estudiantes relacionados.';
            return false;
        }

        $stmt = $this->db->prepare('DELETE FROM programas WHERE codigo = :codigo');
        return $stmt->execute(['codigo' => $code]);
    }

    public function hasStudents(string $code): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM estudiantes WHERE programa = :codigo');
        $stmt->execute(['codigo' => $code]);
        return (bool) $stmt->fetchColumn();
    }

    public function hasSubjects(string $code): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM materias WHERE programa = :codigo');
        $stmt->execute(['codigo' => $code]);
        return (bool) $stmt->fetchColumn();
    }
}
