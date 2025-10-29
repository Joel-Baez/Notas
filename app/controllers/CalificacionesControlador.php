<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\EstudianteRepositorio;
use App\Models\MateriaRepositorio;
use App\Models\NotaRepositorio;
use App\Soporte\ControladorComun;

final class CalificacionesControlador extends ControladorComun
{
    private NotaRepositorio $notas;
    private EstudianteRepositorio $estudiantes;
    private MateriaRepositorio $materias;

    public function __construct()
    {
        $this->notas = new NotaRepositorio();
        $this->estudiantes = new EstudianteRepositorio();
        $this->materias = new MateriaRepositorio();
    }

    public function inicio(): void
    {
        $this->exigirSesion();
        $this->renderizar('calificaciones/listado', [
            'notas' => $this->notas->listado(),
            'resumen' => $this->notas->resumenPromedios(),
            'estudiantes' => $this->estudiantes->todos(),
            'materias' => $this->materias->todas(),
        ]);
    }

    public function registrar(): void
    {
        $this->exigirSesion();
        $actividad = trim($_POST['actividad'] ?? '');
        $valorTexto = trim($_POST['valor'] ?? '');
        $materia = trim($_POST['materia'] ?? '');
        $estudiante = trim($_POST['estudiante'] ?? '');

        if ($actividad === '' || $valorTexto === '' || $materia === '' || $estudiante === '') {
            $this->anunciar('Debe completar todos los campos de la calificación.', 'error');
            $this->irA('calificaciones');
        }

        if (!preg_match('/^(\d{1})(\.\d{1,2})?$/', $valorTexto) && !preg_match('/^5(\.00?)?$/', $valorTexto)) {
            $this->anunciar('La nota debe tener máximo dos decimales.', 'error');
            $this->irA('calificaciones');
        }

        $valor = (float) $valorTexto;
        if ($valor <= 0 || $valor > 5) {
            $this->anunciar('La nota debe ser mayor que cero y menor o igual que cinco.', 'error');
            $this->irA('calificaciones');
        }

        if (!$this->notas->relacionValida($estudiante, $materia)) {
            $this->anunciar('El estudiante no pertenece al programa de la materia seleccionada.', 'error');
            $this->irA('calificaciones');
        }

        $this->notas->registrar([
            'actividad' => $actividad,
            'valor' => $valor,
            'materia' => $materia,
            'estudiante' => $estudiante,
        ]);

        $this->anunciar('Calificación guardada con éxito.');
        $this->irA('calificaciones');
    }

    public function editar(): void
    {
        $this->exigirSesion();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $nota = $this->notas->buscar($id);

        if (!$nota) {
            $this->anunciar('La calificación solicitada no existe.', 'error');
            $this->irA('calificaciones');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $valorTexto = trim($_POST['valor'] ?? '');
            if (!preg_match('/^(\d{1})(\.\d{1,2})?$/', $valorTexto) && !preg_match('/^5(\.00?)?$/', $valorTexto)) {
                $this->anunciar('La nota debe tener máximo dos decimales.', 'error');
            } else {
                $valor = (float) $valorTexto;
                if ($valor > 0 && $valor <= 5) {
                    if ($this->notas->actualizarValor($id, $valor)) {
                        $this->anunciar('Nota actualizada.');
                        $this->irA('calificaciones');
                    } else {
                        $this->anunciar('No fue posible actualizar la nota.', 'error');
                    }
                } else {
                    $this->anunciar('La nota debe ser mayor que cero y no superar cinco.', 'error');
                }
            }
            $nota['valor'] = $valorTexto;
        }

        $this->renderizar('calificaciones/formulario', ['nota' => $nota]);
    }

    public function confirmar(): void
    {
        $this->exigirSesion();
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $nota = $this->notas->buscar($id);

        if (!$nota) {
            $this->anunciar('La calificación solicitada no existe.', 'error');
            $this->irA('calificaciones');
        }

        $this->renderizar('calificaciones/confirmar', ['nota' => $nota]);
    }

    public function borrar(): void
    {
        $this->exigirSesion();
        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        if ($id === 0) {
            $this->anunciar('Solicitud inválida.', 'error');
            $this->irA('calificaciones');
        }

        if ($this->notas->eliminar($id)) {
            $this->anunciar('Calificación eliminada.');
        } else {
            $this->anunciar('No fue posible eliminar la calificación.', 'error');
        }

        $this->irA('calificaciones');
    }

    public function limpiar(): void
    {
        $this->exigirSesion();
        $codigo = $_GET['estudiante'] ?? ($_POST['estudiante'] ?? '');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($codigo === '') {
                $this->anunciar('Solicitud inválida.', 'error');
            } else {
                $this->notas->eliminarPorEstudiante($codigo);
                $this->anunciar('Se eliminaron todas las notas del estudiante.');
            }
            $this->irA('calificaciones');
        }

        $estudiante = $this->estudiantes->buscar($codigo);
        if (!$estudiante) {
            $this->anunciar('No se encontró el estudiante indicado.', 'error');
            $this->irA('calificaciones');
        }

        $this->renderizar('calificaciones/limpiar', ['estudiante' => $estudiante]);
    }
}
