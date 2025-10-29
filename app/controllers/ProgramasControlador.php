<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ProgramaRepositorio;
use App\Soporte\ControladorComun;
use PDOException;

final class ProgramasControlador extends ControladorComun
{
    private ProgramaRepositorio $programas;

    public function __construct()
    {
        $this->programas = new ProgramaRepositorio();
    }

    public function inicio(): void
    {
        $this->exigirSesion();
        $listado = $this->programas->todos();
        $this->renderizar('programas/listado', ['programas' => $listado]);
    }

    public function registrar(): void
    {
        $this->exigirSesion();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo = trim($_POST['codigo'] ?? '');
            $nombre = trim($_POST['nombre'] ?? '');

            if ($codigo === '' || $nombre === '') {
                $this->anunciar('Debe completar los campos del formulario.', 'error');
            } else {
                try {
                    $this->programas->crear(['codigo' => $codigo, 'nombre' => $nombre]);
                    $this->anunciar('Programa registrado correctamente.');
                    $this->irA('programas');
                } catch (PDOException) {
                    $this->anunciar('No se pudo guardar el programa. Verifique que el código no exista.', 'error');
                }
            }
        }

        $this->renderizar('programas/formulario', [
            'accion' => 'registrar',
            'programa' => ['codigo' => $_POST['codigo'] ?? '', 'nombre' => $_POST['nombre'] ?? ''],
        ]);
    }

    public function modificar(): void
    {
        $this->exigirSesion();
        $codigo = $_GET['codigo'] ?? '';
        $programa = $this->programas->buscar($codigo);

        if (!$programa) {
            $this->anunciar('Programa no localizado.', 'error');
            $this->irA('programas');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            if ($nombre === '') {
                $this->anunciar('El nombre del programa es obligatorio.', 'error');
            } elseif ($this->programas->actualizarNombre($codigo, $nombre)) {
                $this->anunciar('Programa actualizado.');
                $this->irA('programas');
            } else {
                $this->anunciar('El programa tiene información asociada y no puede modificarse.', 'error');
            }
            $programa['nombre'] = $nombre;
        }

        $this->renderizar('programas/formulario', [
            'accion' => 'modificar',
            'programa' => $programa,
        ]);
    }

    public function confirmar(): void
    {
        $this->exigirSesion();
        $codigo = $_GET['codigo'] ?? '';
        $programa = $this->programas->buscar($codigo);

        if (!$programa) {
            $this->anunciar('Programa no localizado.', 'error');
            $this->irA('programas');
        }

        $this->renderizar('programas/confirmar', ['programa' => $programa]);
    }

    public function borrar(): void
    {
        $this->exigirSesion();
        $codigo = $_POST['codigo'] ?? '';

        if ($codigo === '') {
            $this->anunciar('Solicitud inválida.', 'error');
            $this->irA('programas');
        }

        if ($this->programas->eliminar($codigo)) {
            $this->anunciar('Programa eliminado.');
        } else {
            $this->anunciar('El programa tiene estudiantes o materias asociadas.', 'error');
        }

        $this->irA('programas');
    }
}
