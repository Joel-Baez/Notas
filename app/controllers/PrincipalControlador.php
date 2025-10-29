<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Soporte\ControladorComun;

final class PrincipalControlador extends ControladorComun
{
    public function inicio(): void
    {
        $this->exigirSesion();
        $usuario = $_SESSION['credencial'];
        $this->renderizar('inicio/panel', ['usuario' => $usuario]);
    }
}
