<?php

namespace App\Controllers;

final class ControladorInicio extends ControladorBase
{
    public function mostrar(): void
    {
        $this->vista('inicio/bienvenida', ['titulo' => 'Inicio']);
    }
}
