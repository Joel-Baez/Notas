<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\MateriaRepositorio;
use App\Models\NotaRepositorio;
use App\Models\ProgramaRepositorio;
use App\Soporte\ControladorComun;
use PDOException;

final class MateriasControlador extends ControladorComun
{
    private MateriaRepositorio $materias;
    private ProgramaRepositorio $programas;
    private NotaRepositorio $notas;

    public function __construct()
    {
        $this->materias = new MateriaRepositorio();
        $this->programas = new ProgramaRepositorio();
        $this->notas = new NotaRepositorio();
    }

    public function inicio(): void
    {
        $this->exigirSesion();
        $listado = $this->materias->todas();
        $this->renderizar('materias/listado', ['materias' => $listado]);
    }

    public function registrar(): void
    {
        $this->exigirSesion();
        $datos = [
            'codigo' => trim($_POST['codigo'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'programa' => trim($_POST['programa'] ?? ''),
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (in_array('', $datos, true)) {
                $this->anunciar('Debe completar toda la información de la materia.', 'error');
            } else {
                try {
                    $this->materias->crear($datos);
                    $this->anunciar('Materia registrada.');
                    $this->irA('materias');
                } catch (PDOException) {
                    $this->anunciar('No se pudo guardar la materia. Verifique que el código no exista.', 'error');
                }
            }
        }

        $this->renderizar('materias/formulario', [
            'accion' => 'registrar',
            'materia' => $datos,
            'programas' => $this->programas->todos(),
        ]);
    }

    public function modificar(): void
    {
        $this->exigirSesion();
        $codigo = $_GET['codigo'] ?? '';
        $materia = $this->materias->buscar($codigo);

        if (!$materia) {
            $this->anunciar('Materia no encontrada.', 'error');
            $this->irA('materias');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'programa' => trim($_POST['programa'] ?? ''),
            ];

            if (in_array('', $datos, true)) {
                $this->anunciar('Debe completar todos los campos.', 'error');
            } elseif ($this->materias->actualizar($codigo, $datos)) {
                $this->anunciar('Materia actualizada.');
                $this->irA('materias');
            } else {
                $this->anunciar('La materia tiene estudiantes o notas asociadas.', 'error');
            }

            $materia = array_merge($materia, $datos);
        }

        $this->renderizar('materias/formulario', [
            'accion' => 'modificar',
            'materia' => $materia,
            'programas' => $this->programas->todos(),
        ]);
    }

    public function detalle(): void
    {
        $this->exigirSesion();
        $codigo = $_GET['codigo'] ?? '';
        $materia = $this->materias->buscar($codigo);

        if (!$materia) {
            $this->anunciar('Materia no encontrada.', 'error');
            $this->irA('materias');
        }

        $promedios = $this->notas->promediosDeMateria($codigo);

        $this->renderizar('materias/detalle', [
            'materia' => $materia,
            'promedios' => $promedios,
        ]);
    }

    public function confirmar(): void
    {
        $this->exigirSesion();
        $codigo = $_GET['codigo'] ?? '';
        $materia = $this->materias->buscar($codigo);

        if (!$materia) {
            $this->anunciar('Materia no encontrada.', 'error');
            $this->irA('materias');
        }

        $this->renderizar('materias/confirmar', ['materia' => $materia]);
    }

    public function borrar(): void
    {
        $this->exigirSesion();
        $codigo = $_POST['codigo'] ?? '';

        if ($codigo === '') {
            $this->anunciar('Solicitud inválida.', 'error');
            $this->irA('materias');
        }

        if ($this->materias->eliminar($codigo)) {
            $this->anunciar('Materia eliminada.');
        } else {
            $this->anunciar('La materia tiene notas registradas y no puede eliminarse.', 'error');
        }

        $this->irA('materias');
    }
}
