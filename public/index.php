<?php

declare(strict_types=1);

use App\Controllers\NotaController;

require __DIR__ . '/../bootstrap.php';

$controller = new NotaController();
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $controller->guardar($_POST);
}

$vista = __DIR__ . '/../resources/views/formulario.php';

require __DIR__ . '/../resources/views/layout.php';
