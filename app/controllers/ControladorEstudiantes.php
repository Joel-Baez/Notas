<?php

namespace App\Controllers;

use App\Models\Estudiante;
use App\Models\Programa;
use App\Models\Nota;
use App\Models\Materia;

final class ControladorEstudiantes extends ControladorBase
{
    public function index(): void
    {
        $estudiantes = Estudiante::todos();
        foreach ($estudiantes as &$estudiante) {
            $estudiante['promedio'] = Nota::promedioGeneral($estudiante['codigo']);
        }

        $this->vista('estudiantes/lista', [
            'titulo' => 'Estudiantes',
            'estudiantes' => $estudiantes,
        ]);
    }

    public function crear(): void
    {
        $this->vista('estudiantes/formulario', [
            'titulo' => 'Nuevo estudiante',
            'estudiante' => ['codigo' => '', 'nombre' => '', 'email' => '', 'programa' => ''],
            'programas' => Programa::todos(),
            'accion' => 'guardar',
        ]);
    }

    public function guardar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=estudiantes');
            return;
        }

        $datos = $this->datos();
        if (in_array('', $datos, true)) {
            $this->flash('error', 'Todos los campos son obligatorios.');
            $this->redirigir('?entidad=estudiantes&accion=crear');
            return;
        }

        Estudiante::crear($datos);
        $this->flash('exito', 'Estudiante registrado.');
        $this->redirigir('?entidad=estudiantes');
    }

    public function editar(string $codigo): void
    {
        $estudiante = Estudiante::buscar($codigo);
        if (!$estudiante) {
            $this->flash('error', 'Estudiante no encontrado.');
            $this->redirigir('?entidad=estudiantes');
            return;
        }

        $this->vista('estudiantes/formulario', [
            'titulo' => 'Editar estudiante',
            'estudiante' => $estudiante,
            'programas' => Programa::todos(),
            'accion' => 'actualizar',
        ]);
    }

    public function actualizar(string $codigo): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=estudiantes');
            return;
        }

        $datos = $this->datos();
        if (in_array('', $datos, true) || !Estudiante::actualizar($codigo, $datos)) {
            $this->flash('error', 'No se pudo actualizar el estudiante. Verifica que no tenga notas registradas.');
        } else {
            $this->flash('exito', 'Estudiante actualizado.');
        }
        $this->redirigir('?entidad=estudiantes');
    }

    public function confirmarEliminar(string $codigo): void
    {
        $estudiante = Estudiante::buscar($codigo);
        if (!$estudiante) {
            $this->flash('error', 'Estudiante no encontrado.');
            $this->redirigir('?entidad=estudiantes');
            return;
        }

        $this->vista('estudiantes/eliminar', [
            'titulo' => 'Eliminar estudiante',
            'estudiante' => $estudiante,
        ]);
    }

    public function eliminar(string $codigo): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=estudiantes');
            return;
        }

        if (Estudiante::eliminar($codigo)) {
            $this->flash('exito', 'Estudiante eliminado.');
        } else {
            $this->flash('error', 'No es posible eliminar porque tiene notas asociadas.');
        }
        $this->redirigir('?entidad=estudiantes');
    }

    public function mostrar(string $codigo): void
    {
        $estudiante = Estudiante::buscar($codigo);
        if (!$estudiante) {
            $this->flash('error', 'Estudiante no encontrado.');
            $this->redirigir('?entidad=estudiantes');
            return;
        }

        $this->vista('estudiantes/detalle', [
            'titulo' => 'Detalle del estudiante',
            'estudiante' => $estudiante,
            'materiasPrograma' => Materia::porPrograma($estudiante['programa']),
        ]);
    }

    private function datos(): array
    {
        return [
            'codigo' => strtoupper(trim($_POST['codigo'] ?? '')),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'email' => strtolower(trim($_POST['email'] ?? '')),
            'programa' => trim($_POST['programa'] ?? ''),
        ];
    }
}
