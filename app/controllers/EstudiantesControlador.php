<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\EstudianteRepositorio;
use App\Models\MateriaRepositorio;
use App\Models\NotaRepositorio;
use App\Models\ProgramaRepositorio;
use App\Soporte\ControladorComun;
use PDOException;

final class EstudiantesControlador extends ControladorComun
{
    private EstudianteRepositorio $estudiantes;
    private ProgramaRepositorio $programas;
    private MateriaRepositorio $materias;
    private NotaRepositorio $notas;

    public function __construct()
    {
        $this->estudiantes = new EstudianteRepositorio();
        $this->programas = new ProgramaRepositorio();
        $this->materias = new MateriaRepositorio();
        $this->notas = new NotaRepositorio();
    }

    public function inicio(): void
    {
        $this->exigirSesion();
        $listado = $this->estudiantes->todos();
        $this->renderizar('estudiantes/listado', ['estudiantes' => $listado]);
    }

    public function registrar(): void
    {
        $this->exigirSesion();
        $datos = [
            'codigo' => trim($_POST['codigo'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'programa' => trim($_POST['programa'] ?? ''),
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (in_array('', $datos, true)) {
                $this->anunciar('Debe completar todos los datos del estudiante.', 'error');
            } else {
                try {
                    $this->estudiantes->crear($datos);
                    $this->anunciar('Estudiante registrado correctamente.');
                    $this->irA('estudiantes');
                } catch (PDOException) {
                    $this->anunciar('No fue posible guardar el estudiante. Verifique que el código no exista.', 'error');
                }
            }
        }

        $this->renderizar('estudiantes/formulario', [
            'accion' => 'registrar',
            'estudiante' => $datos,
            'programas' => $this->programas->todos(),
        ]);
    }

    public function modificar(): void
    {
        $this->exigirSesion();
        $codigo = $_GET['codigo'] ?? '';
        $estudiante = $this->estudiantes->buscar($codigo);

        if (!$estudiante) {
            $this->anunciar('No se encontró el estudiante solicitado.', 'error');
            $this->irA('estudiantes');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'programa' => trim($_POST['programa'] ?? ''),
            ];

            if (in_array('', $datos, true)) {
                $this->anunciar('Debe completar todos los campos.', 'error');
            } elseif ($this->estudiantes->actualizar($codigo, $datos)) {
                $this->anunciar('Información actualizada.');
                $this->irA('estudiantes');
            } else {
                $this->anunciar('El estudiante posee notas registradas y no puede modificarse.', 'error');
            }

            $estudiante = array_merge($estudiante, $datos);
        }

        $this->renderizar('estudiantes/formulario', [
            'accion' => 'modificar',
            'estudiante' => $estudiante,
            'programas' => $this->programas->todos(),
        ]);
    }

    public function detalle(): void
    {
        $this->exigirSesion();
        $codigo = $_GET['codigo'] ?? '';
        $estudiante = $this->estudiantes->buscar($codigo);

        if (!$estudiante) {
            $this->anunciar('No se encontró el estudiante solicitado.', 'error');
            $this->irA('estudiantes');
        }

        $materias = $this->materias->materiasPorEstudiante($codigo, $estudiante['programa']);
        $notas = $this->notas->notasDeEstudiante($codigo);

        $this->renderizar('estudiantes/detalle', [
            'estudiante' => $estudiante,
            'materias' => $materias,
            'notas' => $notas,
        ]);
    }

    public function confirmar(): void
    {
        $this->exigirSesion();
        $codigo = $_GET['codigo'] ?? '';
        $estudiante = $this->estudiantes->buscar($codigo);

        if (!$estudiante) {
            $this->anunciar('No se encontró el estudiante solicitado.', 'error');
            $this->irA('estudiantes');
        }

        $this->renderizar('estudiantes/confirmar', ['estudiante' => $estudiante]);
    }

    public function borrar(): void
    {
        $this->exigirSesion();
        $codigo = $_POST['codigo'] ?? '';

        if ($codigo === '') {
            $this->anunciar('Solicitud inválida.', 'error');
            $this->irA('estudiantes');
        }

        if ($this->estudiantes->eliminar($codigo)) {
            $this->anunciar('Estudiante eliminado.');
        } else {
            $this->anunciar('El estudiante tiene notas registradas y no puede eliminarse.', 'error');
        }

        $this->irA('estudiantes');
    }
}
