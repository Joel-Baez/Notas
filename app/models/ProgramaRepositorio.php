<?php

declare(strict_types=1);

namespace App\Models;

final class ProgramaRepositorio extends RepositorioBase
{
    public function todos(): array
    {
        $sql = 'SELECT codigo, nombre FROM programas ORDER BY nombre';
        return $this->db->query($sql)->fetchAll();
    }

    public function buscar(string $codigo): ?array
    {
        $sentencia = $this->db->prepare('SELECT codigo, nombre FROM programas WHERE codigo = :codigo');
        $sentencia->execute(['codigo' => $codigo]);
        $programa = $sentencia->fetch();

        return $programa ?: null;
    }

    public function crear(array $datos): void
    {
        $sentencia = $this->db->prepare('INSERT INTO programas (codigo, nombre) VALUES (:codigo, :nombre)');
        $sentencia->execute([
            'codigo' => $datos['codigo'],
            'nombre' => $datos['nombre'],
        ]);
    }

    public function actualizarNombre(string $codigo, string $nombre): bool
    {
        if ($this->tieneAsociados($codigo)) {
            return false;
        }

        $sentencia = $this->db->prepare('UPDATE programas SET nombre = :nombre WHERE codigo = :codigo');
        $sentencia->execute(['nombre' => $nombre, 'codigo' => $codigo]);
        return $sentencia->rowCount() > 0;
    }

    public function eliminar(string $codigo): bool
    {
        if ($this->tieneAsociados($codigo)) {
            return false;
        }

        $sentencia = $this->db->prepare('DELETE FROM programas WHERE codigo = :codigo');
        $sentencia->execute(['codigo' => $codigo]);
        return $sentencia->rowCount() > 0;
    }

    private function tieneAsociados(string $codigo): bool
    {
        $sql = 'SELECT (
                    SELECT COUNT(*) FROM estudiantes WHERE programa = :codigo
                ) + (
                    SELECT COUNT(*) FROM materias WHERE programa = :codigo
                ) AS total';
        $sentencia = $this->db->prepare($sql);
        $sentencia->execute(['codigo' => $codigo]);
        return (int) $sentencia->fetchColumn() > 0;
    }
}
