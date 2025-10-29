<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\EstudianteRepositorio;
use App\Models\MateriaRepositorio;
use App\Models\NotaRepositorio;
use App\Models\ProgramaRepositorio;
use App\Soporte\ControladorComun;

final class ReportesControlador extends ControladorComun
{
    private ProgramaRepositorio $programas;
    private MateriaRepositorio $materias;
    private EstudianteRepositorio $estudiantes;
    private NotaRepositorio $notas;

    public function __construct()
    {
        $this->programas = new ProgramaRepositorio();
        $this->materias = new MateriaRepositorio();
        $this->estudiantes = new EstudianteRepositorio();
        $this->notas = new NotaRepositorio();
    }

    public function inicio(): void
    {
        $this->exigirSesion();

        $programas = $this->programas->todos();
        $materiasPorPrograma = [];
        $estudiantesPorPrograma = [];

        foreach ($programas as $programa) {
            $materiasPorPrograma[$programa['codigo']] = $this->materias->porPrograma($programa['codigo']);
            $estudiantesPorPrograma[$programa['codigo']] = $this->estudiantes->porPrograma($programa['codigo']);
        }

        $estudiantes = $this->estudiantes->todos();
        $materiasDeEstudiante = [];
        $notasDetalladas = [];

        foreach ($estudiantes as $estudiante) {
            $materiasDeEstudiante[$estudiante['codigo']] = $this->materias->materiasPorEstudiante($estudiante['codigo'], $estudiante['programa']);
            $notasDetalladas[$estudiante['codigo']] = $this->notas->notasDeEstudiante($estudiante['codigo']);
        }

        $porMateria = [];
        foreach ($this->notas->resumenPromedios() as $registro) {
            $porMateria[$registro['materia']][] = $registro;
        }

        $this->renderizar('reportes/general', [
            'programas' => $programas,
            'estudiantes' => $estudiantes,
            'materiasPorPrograma' => $materiasPorPrograma,
            'estudiantesPorPrograma' => $estudiantesPorPrograma,
            'materiasDeEstudiante' => $materiasDeEstudiante,
            'notasDetalladas' => $notasDetalladas,
            'porMateria' => $porMateria,
        ]);
    }
}
