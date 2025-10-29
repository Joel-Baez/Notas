<?php

declare(strict_types=1);

namespace App\Soporte;

class Enrutador
{
    public function __construct(private array $mapa)
    {
    }

    public function ejecutar(): void
    {
        $modulo = $_GET['modulo'] ?? 'inicio';
        $operacion = $_GET['operacion'] ?? 'inicio';

        if (empty($_SESSION['credencial']) && $modulo !== 'acceso') {
            $modulo = 'acceso';
            $operacion = 'entrar';
        }

        if (!isset($this->mapa[$modulo])) {
            http_response_code(404);
            echo 'Ruta no localizada';
            return;
        }

        $clase = $this->mapa[$modulo];
        $controlador = new $clase();

        if (!method_exists($controlador, $operacion)) {
            $operacion = method_exists($controlador, 'inicio') ? 'inicio' : 'listar';
        }

        $controlador->$operacion();
    }
}
