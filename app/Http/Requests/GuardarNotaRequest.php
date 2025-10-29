<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use App\Models\Nota;

/**
 * Encapsula la lógica de validación del formulario de notas.
 */
class GuardarNotaRequest
{
    public function validar(array $datos): Nota
    {
        $errores = [];
        $valorNormalizado = '';
        $valorOriginal = $datos['valor'] ?? '';

        if ($valorOriginal === '' || $valorOriginal === null) {
            $errores['valor'] = 'Debe proporcionar un valor de nota.';
        } elseif (!is_numeric($valorOriginal)) {
            $errores['valor'] = 'La nota debe ser un número.';
        } else {
            $valorComoNumero = (float) $valorOriginal;
            $valorNormalizado = number_format(round($valorComoNumero, 2), 2, '.', '');

            try {
                return Nota::desdeValor($valorComoNumero);
            } catch (\InvalidArgumentException $exception) {
                $errores['valor'] = $exception->getMessage();
            }
        }

        throw new ValidationException($errores, ['valor' => $valorNormalizado !== '' ? $valorNormalizado : $valorOriginal]);
    }
}
