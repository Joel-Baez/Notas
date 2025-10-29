<?php

use App\Controllers\ControladorInicio;
use App\Controllers\ControladorProgramas;
use App\Controllers\ControladorEstudiantes;
use App\Controllers\ControladorMaterias;
use App\Controllers\ControladorNotas;
use App\Controllers\ControladorSesion;

session_start();

spl_autoload_register(function (string $class) {
    if (str_starts_with($class, 'App\\')) {
        $ruta = __DIR__ . '/../' . str_replace('App\\', 'app/', $class) . '.php';
        $ruta = str_replace('\\', '/', $ruta);
        if (is_file($ruta)) {
            require_once $ruta;
        }
    }
});

$entidad = $_GET['entidad'] ?? 'inicio';
$accion = $_GET['accion'] ?? 'index';

if (empty($_SESSION['usuario']) && $entidad !== 'sesion') {
    $entidad = 'sesion';
    $accion = 'iniciar';
}

$controladores = [
    'inicio' => ControladorInicio::class,
    'programas' => ControladorProgramas::class,
    'estudiantes' => ControladorEstudiantes::class,
    'materias' => ControladorMaterias::class,
    'notas' => ControladorNotas::class,
    'sesion' => ControladorSesion::class,
];

if (!isset($controladores[$entidad])) {
    http_response_code(404);
    echo 'Ruta no encontrada';
    exit;
}

$controlador = new ($controladores[$entidad])();

if (!method_exists($controlador, $accion)) {
    $accion = $entidad === 'inicio' ? 'mostrar' : 'index';
}

$metodo = new ReflectionMethod($controlador, $accion);
$argumentos = [];
foreach ($metodo->getParameters() as $parametro) {
    $argumentos[] = $_GET[$parametro->getName()] ?? '';
}

$metodo->invokeArgs($controlador, $argumentos);
