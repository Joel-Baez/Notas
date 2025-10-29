<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

/**
 * Excepción lanzada cuando la información proporcionada no supera el proceso de validación.
 */
class ValidationException extends RuntimeException
{
    /**
     * @var array<string, string> Lista de errores asociados a cada campo.
     */
    private array $errores;

    /**
     * @var array<string, mixed> Datos sanitizados que permiten repoblar el formulario.
     */
    private array $datos;

    /**
     * @param array<string, string> $errores
     * @param array<string, mixed> $datos
     */
    public function __construct(array $errores, array $datos = [])
    {
        parent::__construct('La información enviada no es válida.');
        $this->errores = $errores;
        $this->datos = $datos;
    }

    /**
     * @return array<string, string>
     */
    public function errores(): array
    {
        return $this->errores;
    }

    /**
     * @return array<string, mixed>
     */
    public function datos(): array
    {
        return $this->datos;
    }
}
