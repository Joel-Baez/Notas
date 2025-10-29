<?php

namespace App\Controllers;

use App\Models\Programa;
use App\Models\Materia;
use App\Models\Estudiante;

final class ControladorProgramas extends ControladorBase
{
    public function index(): void
    {
        $this->vista('programas/lista', [
            'titulo' => 'Programas de formación',
            'programas' => Programa::todos(),
        ]);
    }

    public function crear(): void
    {
        $this->vista('programas/formulario', [
            'titulo' => 'Nuevo programa',
            'programa' => ['codigo' => '', 'nombre' => ''],
            'accion' => 'guardar',
        ]);
    }

    public function guardar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=programas');
            return;
        }

        $datos = $this->datosPrograma();
        if (!$datos['codigo'] || !$datos['nombre']) {
            $this->flash('error', 'Completa todos los campos.');
            $this->redirigir('?entidad=programas&accion=crear');
            return;
        }

        Programa::crear($datos);
        $this->flash('exito', 'Programa registrado.');
        $this->redirigir('?entidad=programas');
    }

    public function editar(string $codigo): void
    {
        $programa = Programa::buscar($codigo);
        if (!$programa) {
            $this->flash('error', 'Programa no encontrado.');
            $this->redirigir('?entidad=programas');
            return;
        }

        $this->vista('programas/formulario', [
            'titulo' => 'Editar programa',
            'programa' => $programa,
            'accion' => 'actualizar',
        ]);
    }

    public function actualizar(string $codigo): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=programas');
            return;
        }

        $nombre = trim($_POST['nombre'] ?? '');
        if (!$nombre || !Programa::actualizar($codigo, $nombre)) {
            $this->flash('error', 'No fue posible actualizar el programa.');
        } else {
            $this->flash('exito', 'Programa actualizado.');
        }

        $this->redirigir('?entidad=programas');
    }

    public function confirmarEliminar(string $codigo): void
    {
        $programa = Programa::buscar($codigo);
        if (!$programa) {
            $this->flash('error', 'Programa no encontrado.');
            $this->redirigir('?entidad=programas');
            return;
        }

        $this->vista('programas/eliminar', [
            'titulo' => 'Eliminar programa',
            'programa' => $programa,
        ]);
    }

    public function eliminar(string $codigo): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=programas');
            return;
        }

        if (Programa::eliminar($codigo)) {
            $this->flash('exito', 'Programa eliminado.');
        } else {
            $this->flash('error', 'No se puede eliminar el programa porque tiene relaciones.');
        }
        $this->redirigir('?entidad=programas');
    }

    public function mostrar(string $codigo): void
    {
        $programa = Programa::resumen($codigo);
        if (!$programa) {
            $this->flash('error', 'Programa no encontrado.');
            $this->redirigir('?entidad=programas');
            return;
        }

        $this->vista('programas/detalle', [
            'titulo' => 'Detalle del programa',
            'programa' => $programa,
            'materias' => Materia::porPrograma($codigo),
            'estudiantes' => Estudiante::porPrograma($codigo),
        ]);
    }

    private function datosPrograma(): array
    {
        return [
            'codigo' => strtoupper(trim($_POST['codigo'] ?? '')),
            'nombre' => trim($_POST['nombre'] ?? ''),
        ];
    }
}
