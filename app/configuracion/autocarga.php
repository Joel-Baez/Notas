<?php

declare(strict_types=1);

spl_autoload_register(function (string $clase): void {
    $prefijo = 'App\\';
    if (strncmp($clase, $prefijo, strlen($prefijo)) !== 0) {
        return;
    }

    $rutaRelativa = str_replace('\\', '/', substr($clase, strlen($prefijo)));
    $archivo = __DIR__ . '/../' . $rutaRelativa . '.php';

    if (is_file($archivo)) {
        require_once $archivo;
    }
});
