<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Student
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM estudiantes ORDER BY nombre');
        return $stmt->fetchAll();
    }

    public function find(string $code): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM estudiantes WHERE codigo = :codigo');
        $stmt->execute(['codigo' => $code]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO estudiantes (codigo, nombre, email, programa) VALUES (:codigo, :nombre, :email, :programa)');
        return $stmt->execute([
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'programa' => $data['programa'],
        ]);
    }

    public function update(string $code, array $data, array &$errors = []): bool
    {
        if ($this->hasGrades($code)) {
            $errors[] = 'No es posible modificar el estudiante porque tiene notas registradas.';
            return false;
        }

        $stmt = $this->db->prepare('UPDATE estudiantes SET nombre = :nombre, email = :email, programa = :programa WHERE codigo = :codigo');
        return $stmt->execute([
            'codigo' => $code,
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'programa' => $data['programa'],
        ]);
    }

    public function delete(string $code, array &$errors = []): bool
    {
        if ($this->hasGrades($code)) {
            $errors[] = 'No es posible eliminar el estudiante porque tiene notas registradas.';
            return false;
        }

        $stmt = $this->db->prepare('DELETE FROM estudiantes WHERE codigo = :codigo');
        return $stmt->execute(['codigo' => $code]);
    }

    public function allByProgram(string $program): array
    {
        $stmt = $this->db->prepare('SELECT * FROM estudiantes WHERE programa = :programa ORDER BY nombre');
        $stmt->execute(['programa' => $program]);
        return $stmt->fetchAll();
    }

    public function hasGrades(string $code): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM notas WHERE estudiante = :codigo');
        $stmt->execute(['codigo' => $code]);
        return (bool) $stmt->fetchColumn();
    }
}
