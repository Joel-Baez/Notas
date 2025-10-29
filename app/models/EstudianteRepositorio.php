<?php

declare(strict_types=1);

namespace App\Models;

final class EstudianteRepositorio extends RepositorioBase
{
    public function todos(): array
    {
        $sql = 'SELECT e.codigo, e.nombre, e.email, e.programa, p.nombre AS programa_nombre
                FROM estudiantes e
                JOIN programas p ON p.codigo = e.programa
                ORDER BY e.nombre';
        return $this->db->query($sql)->fetchAll();
    }

    public function porPrograma(string $codigoPrograma): array
    {
        $sentencia = $this->db->prepare('SELECT codigo, nombre, email FROM estudiantes WHERE programa = :programa ORDER BY nombre');
        $sentencia->execute(['programa' => $codigoPrograma]);
        return $sentencia->fetchAll();
    }

    public function buscar(string $codigo): ?array
    {
        $sentencia = $this->db->prepare('SELECT e.codigo, e.nombre, e.email, e.programa, p.nombre AS programa_nombre
            FROM estudiantes e
            JOIN programas p ON p.codigo = e.programa
            WHERE e.codigo = :codigo');
        $sentencia->execute(['codigo' => $codigo]);
        $estudiante = $sentencia->fetch();
        return $estudiante ?: null;
    }

    public function crear(array $datos): void
    {
        $sql = 'INSERT INTO estudiantes (codigo, nombre, email, programa) VALUES (:codigo, :nombre, :email, :programa)';
        $this->db->prepare($sql)->execute([
            'codigo' => $datos['codigo'],
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'programa' => $datos['programa'],
        ]);
    }

    public function actualizar(string $codigo, array $datos): bool
    {
        if ($this->poseeNotas($codigo)) {
            return false;
        }

        $sql = 'UPDATE estudiantes SET nombre = :nombre, email = :email, programa = :programa WHERE codigo = :codigo';
        $sentencia = $this->db->prepare($sql);
        $sentencia->execute([
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'programa' => $datos['programa'],
            'codigo' => $codigo,
        ]);
        return $sentencia->rowCount() > 0;
    }

    public function eliminar(string $codigo): bool
    {
        if ($this->poseeNotas($codigo)) {
            return false;
        }

        $sentencia = $this->db->prepare('DELETE FROM estudiantes WHERE codigo = :codigo');
        $sentencia->execute(['codigo' => $codigo]);
        return $sentencia->rowCount() > 0;
    }

    public function poseeNotas(string $codigo): bool
    {
        $sentencia = $this->db->prepare('SELECT COUNT(*) FROM notas WHERE estudiante = :codigo');
        $sentencia->execute(['codigo' => $codigo]);
        return (int) $sentencia->fetchColumn() > 0;
    }

    public function credencialValida(string $codigo, string $correo): ?array
    {
        $sentencia = $this->db->prepare('SELECT codigo, nombre, email FROM estudiantes WHERE codigo = :codigo AND email = :correo');
        $sentencia->execute(['codigo' => $codigo, 'correo' => $correo]);
        $registro = $sentencia->fetch();
        return $registro ?: null;
    }
}
