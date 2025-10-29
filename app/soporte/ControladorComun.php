<?php

declare(strict_types=1);

namespace App\Soporte;

use RuntimeException;

abstract class ControladorComun
{
    protected function renderizar(string $vista, array $parametros = []): void
    {
        $archivoVista = __DIR__ . '/../views/' . $vista . '.php';
        if (!is_file($archivoVista)) {
            throw new RuntimeException('Vista no disponible: ' . $vista);
        }

        $datos = $parametros;
        require __DIR__ . '/../views/compartido/marco.php';
    }

    protected function anunciar(string $mensaje, string $tipo = 'exito'): void
    {
        $_SESSION['avisos'][] = ['tipo' => $tipo, 'texto' => $mensaje];
    }

    protected function irA(string $modulo, string $operacion = 'inicio', array $query = []): void
    {
        $destino = array_merge(['modulo' => $modulo, 'operacion' => $operacion], $query);
        header('Location: index.php?' . http_build_query($destino));
        exit;
    }

    protected function exigirSesion(): void
    {
        if (empty($_SESSION['credencial'])) {
            $this->irA('acceso', 'entrar');
        }
    }
}
