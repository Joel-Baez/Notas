<?php

declare(strict_types=1);

use App\Controllers\PrincipalControlador;
use App\Controllers\AutenticacionControlador;
use App\Controllers\ProgramasControlador;
use App\Controllers\EstudiantesControlador;
use App\Controllers\MateriasControlador;
use App\Controllers\CalificacionesControlador;
use App\Controllers\ReportesControlador;

return [
    'inicio' => PrincipalControlador::class,
    'acceso' => AutenticacionControlador::class,
    'programas' => ProgramasControlador::class,
    'estudiantes' => EstudiantesControlador::class,
    'materias' => MateriasControlador::class,
    'calificaciones' => CalificacionesControlador::class,
    'reportes' => ReportesControlador::class,
];
