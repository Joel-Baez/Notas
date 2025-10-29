<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Http\Requests\GuardarNotaRequest;
use App\Models\Nota;

/**
 * Controlador responsable de recibir y procesar las notas enviadas por el usuario.
 */
class NotaController
{
    private GuardarNotaRequest $request;

    public function __construct(?GuardarNotaRequest $request = null)
    {
        $this->request = $request ?? new GuardarNotaRequest();
    }

    /**
     * Procesa la solicitud de guardado de nota y genera la respuesta para la vista.
     *
     * @param array<string, mixed> $datos
     *
     * @return array{
     *     exito: bool,
     *     mensaje: string,
     *     nota?: Nota,
     *     errores?: array<string, string>,
     *     datos?: array<string, mixed>
     * }
     */
    public function guardar(array $datos): array
    {
        try {
            $nota = $this->request->validar($datos);
        } catch (ValidationException $exception) {
            return [
                'exito' => false,
                'mensaje' => $exception->getMessage(),
                'errores' => $exception->errores(),
                'datos' => $exception->datos(),
            ];
        }

        return [
            'exito' => true,
            'mensaje' => 'Nota guardada correctamente.',
            'nota' => $nota,
        ];
    }
}
