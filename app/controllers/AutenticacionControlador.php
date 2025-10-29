<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\EstudianteRepositorio;
use App\Soporte\ControladorComun;

final class AutenticacionControlador extends ControladorComun
{
    private EstudianteRepositorio $estudiantes;

    public function __construct()
    {
        $this->estudiantes = new EstudianteRepositorio();
    }

    public function entrar(): void
    {
        $error = null;
        $codigo = trim($_POST['codigo'] ?? '');
        $correo = trim($_POST['correo'] ?? '');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($codigo === '' || $correo === '') {
                $error = 'Debe ingresar el código y el correo electrónico registrados.';
            } else {
                $estudiante = $this->estudiantes->credencialValida($codigo, $correo);
                if ($estudiante) {
                    $_SESSION['credencial'] = $estudiante;
                    $this->anunciar('Bienvenido(a) ' . $estudiante['nombre']);
                    $this->irA('inicio');
                } else {
                    $error = 'Las credenciales proporcionadas no son correctas.';
                }
            }
        }

        $this->renderizar('sesion/formulario', [
            'error' => $error,
            'valores' => ['codigo' => $codigo, 'correo' => $correo],
        ]);
    }

    public function inicio(): void
    {
        $this->irA('acceso', 'entrar');
    }

    public function salir(): void
    {
        $_SESSION = [];
        if (session_id() !== '') {
            session_destroy();
        }
        session_start();
        $this->anunciar('La sesión se cerró correctamente.', 'info');
        $this->irA('acceso', 'entrar');
    }
}
