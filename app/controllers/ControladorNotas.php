<?php

namespace App\Controllers;

use App\Models\Nota;
use App\Models\Estudiante;
use App\Models\Materia;

final class ControladorNotas extends ControladorBase
{
    public function index(): void
    {
        $this->vista('notas/lista', [
            'titulo' => 'Notas registradas',
            'notas' => Nota::todas(),
            'resumen' => Nota::resumen(),
        ]);
    }

    public function crear(): void
    {
        $this->vista('notas/formulario', [
            'titulo' => 'Registrar nota',
            'nota' => ['id' => null, 'materia' => '', 'estudiante' => '', 'actividad' => '', 'nota' => ''],
            'estudiantes' => Estudiante::todos(),
            'materias' => Materia::todas(),
            'accion' => 'guardar',
        ]);
    }

    public function guardar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=notas');
            return;
        }

        $datos = $this->datos();
        if (!$this->validar($datos)) {
            $this->flash('error', 'Revisa la información suministrada.');
            $this->redirigir('?entidad=notas&accion=crear');
            return;
        }

        Nota::registrar($datos);
        $this->flash('exito', 'Nota registrada.');
        $this->redirigir('?entidad=notas');
    }

    public function editar(string $id): void
    {
        $nota = Nota::obtener((int) $id);
        if (!$nota) {
            $this->flash('error', 'Nota no encontrada.');
            $this->redirigir('?entidad=notas');
            return;
        }

        $this->vista('notas/formulario', [
            'titulo' => 'Editar nota',
            'nota' => $nota,
            'estudiantes' => Estudiante::todos(),
            'materias' => Materia::todas(),
            'accion' => 'actualizar',
        ]);
    }

    public function actualizar(string $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=notas');
            return;
        }

        $registro = Nota::obtener((int) $id);
        if (!$registro) {
            $this->flash('error', 'Nota no encontrada.');
            $this->redirigir('?entidad=notas');
            return;
        }

        $nota = (float) ($_POST['nota'] ?? 0);
        if ($nota <= 0 || $nota > 5) {
            $this->flash('error', 'La nota debe ser mayor a 0 y menor o igual a 5.');
            $this->redirigir('?entidad=notas&accion=editar&id=' . urlencode($id));
            return;
        }

        Nota::actualizar((int) $id, $nota);
        $this->flash('exito', 'Nota actualizada.');
        $this->redirigir('?entidad=notas');
    }

    public function confirmarEliminar(string $id): void
    {
        $nota = Nota::obtener((int) $id);
        if (!$nota) {
            $this->flash('error', 'Nota no encontrada.');
            $this->redirigir('?entidad=notas');
            return;
        }

        $this->vista('notas/eliminar', [
            'titulo' => 'Eliminar nota',
            'nota' => $nota,
        ]);
    }

    public function eliminar(string $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=notas');
            return;
        }

        Nota::eliminar((int) $id);
        $this->flash('exito', 'Nota eliminada.');
        $this->redirigir('?entidad=notas');
    }

    public function confirmarEliminarTodas(string $estudiante): void
    {
        $this->vista('notas/eliminar_todas', [
            'titulo' => 'Eliminar todas las notas',
            'estudiante' => $estudiante,
        ]);
    }

    public function eliminarTodas(string $estudiante): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=estudiantes&accion=mostrar&codigo=' . urlencode($estudiante));
            return;
        }

        Nota::eliminarPorEstudiante($estudiante);
        $this->flash('exito', 'Notas eliminadas.');
        $this->redirigir('?entidad=notas');
    }

    private function datos(): array
    {
        return [
            'materia' => trim($_POST['materia'] ?? ''),
            'estudiante' => trim($_POST['estudiante'] ?? ''),
            'actividad' => trim($_POST['actividad'] ?? ''),
            'nota' => (float) ($_POST['nota'] ?? 0),
        ];
    }

    private function validar(array $datos): bool
    {
        if (in_array('', [$datos['materia'], $datos['estudiante'], $datos['actividad']], true)) {
            return false;
        }

        if ($datos['nota'] <= 0 || $datos['nota'] > 5) {
            return false;
        }

        $estudiante = Estudiante::buscar($datos['estudiante']);
        if (!$estudiante) {
            return false;
        }

        return Materia::perteneceAPrograma($datos['materia'], $estudiante['programa']);
    }
}
