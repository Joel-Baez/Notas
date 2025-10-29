<?php

namespace App\Controllers;

use App\Models\Materia;
use App\Models\Programa;
use App\Models\Nota;

final class ControladorMaterias extends ControladorBase
{
    public function index(): void
    {
        $this->vista('materias/lista', [
            'titulo' => 'Materias',
            'materias' => Materia::todas(),
        ]);
    }

    public function crear(): void
    {
        $this->vista('materias/formulario', [
            'titulo' => 'Nueva materia',
            'materia' => ['codigo' => '', 'nombre' => '', 'programa' => ''],
            'programas' => Programa::todos(),
            'accion' => 'guardar',
        ]);
    }

    public function guardar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=materias');
            return;
        }

        $datos = $this->datos();
        if (in_array('', $datos, true)) {
            $this->flash('error', 'Todos los campos son obligatorios.');
            $this->redirigir('?entidad=materias&accion=crear');
            return;
        }

        Materia::crear($datos);
        $this->flash('exito', 'Materia registrada.');
        $this->redirigir('?entidad=materias');
    }

    public function editar(string $codigo): void
    {
        $materia = Materia::buscar($codigo);
        if (!$materia) {
            $this->flash('error', 'Materia no encontrada.');
            $this->redirigir('?entidad=materias');
            return;
        }

        $this->vista('materias/formulario', [
            'titulo' => 'Editar materia',
            'materia' => $materia,
            'programas' => Programa::todos(),
            'accion' => 'actualizar',
        ]);
    }

    public function actualizar(string $codigo): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=materias');
            return;
        }

        $datos = $this->datos();
        if (in_array('', $datos, true) || !Materia::actualizar($codigo, $datos)) {
            $this->flash('error', 'No fue posible actualizar. Verifica que no tenga notas registradas.');
        } else {
            $this->flash('exito', 'Materia actualizada.');
        }
        $this->redirigir('?entidad=materias');
    }

    public function confirmarEliminar(string $codigo): void
    {
        $materia = Materia::buscar($codigo);
        if (!$materia) {
            $this->flash('error', 'Materia no encontrada.');
            $this->redirigir('?entidad=materias');
            return;
        }

        $this->vista('materias/eliminar', [
            'titulo' => 'Eliminar materia',
            'materia' => $materia,
        ]);
    }

    public function eliminar(string $codigo): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=materias');
            return;
        }

        if (Materia::eliminar($codigo)) {
            $this->flash('exito', 'Materia eliminada.');
        } else {
            $this->flash('error', 'No se puede eliminar porque tiene estudiantes o notas.');
        }
        $this->redirigir('?entidad=materias');
    }

    public function mostrar(string $codigo): void
    {
        $materia = Materia::buscar($codigo);
        if (!$materia) {
            $this->flash('error', 'Materia no encontrada.');
            $this->redirigir('?entidad=materias');
            return;
        }

        $this->vista('materias/detalle', [
            'titulo' => 'Detalle de la materia',
            'materia' => $materia,
            'estudiantes' => Nota::estudiantesPorMateria($codigo),
        ]);
    }

    private function datos(): array
    {
        return [
            'codigo' => strtoupper(trim($_POST['codigo'] ?? '')),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'programa' => trim($_POST['programa'] ?? ''),
        ];
    }
}
