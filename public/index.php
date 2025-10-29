<?php

declare(strict_types=1);

session_start();

require __DIR__ . '/../app/configuracion/autocarga.php';

use App\Soporte\Enrutador;

$mapa = require __DIR__ . '/../app/configuracion/rutas.php';

$enrutador = new Enrutador($mapa);
$enrutador->ejecutar();
