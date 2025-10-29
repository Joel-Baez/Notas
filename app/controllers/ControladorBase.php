<?php

namespace App\Controllers;

abstract class ControladorBase
{
    protected function vista(string $ruta, array $datos = []): void
    {
        $titulo = $datos['titulo'] ?? 'Gestor de notas';
        $mensaje = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        $archivo = __DIR__ . '/../views/' . $ruta . '.php';
        if (!is_file($archivo)) {
            http_response_code(404);
            echo 'Vista no encontrada';
            return;
        }

        ob_start();
        extract($datos, EXTR_SKIP);
        require $archivo;
        $contenido = ob_get_clean();

        require __DIR__ . '/../views/plantillas/principal.php';
    }

    protected function redirigir(string $ruta): void
    {
        header('Location: ' . $ruta);
        exit;
    }

    protected function flash(string $tipo, string $texto): void
    {
        $_SESSION['mensaje'] = ['tipo' => $tipo, 'texto' => $texto];
    }
}
