<?php

namespace App\Controllers;

use App\Models\Estudiante;

final class ControladorSesion extends ControladorBase
{
    public function iniciar(): void
    {
        if (!empty($_SESSION['usuario'])) {
            $this->redirigir('index.php');
            return;
        }

        $this->vista('sesion/inicio', ['titulo' => 'Iniciar sesión']);
    }

    public function acceder(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir('?entidad=sesion&accion=iniciar');
            return;
        }

        $codigo = strtoupper(trim($_POST['codigo'] ?? ''));
        $clave = strtolower(trim($_POST['clave'] ?? ''));

        $estudiante = Estudiante::buscar($codigo);
        if ($estudiante && $estudiante['email'] === $clave) {
            $_SESSION['usuario'] = [
                'codigo' => $estudiante['codigo'],
                'nombre' => $estudiante['nombre'],
            ];
            $this->flash('exito', 'Bienvenido ' . $estudiante['nombre'] . '.');
            $this->redirigir('index.php');
            return;
        }

        $this->flash('error', 'Credenciales inválidas.');
        $this->redirigir('?entidad=sesion&accion=iniciar');
    }

    public function cerrar(): void
    {
        unset($_SESSION['usuario']);
        $this->flash('exito', 'Sesión finalizada.');
        $this->redirigir('?entidad=sesion&accion=iniciar');
    }
}
