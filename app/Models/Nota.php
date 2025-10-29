<?php

declare(strict_types=1);

namespace App\Models;

use InvalidArgumentException;

/**
 * Representa una calificación registrada por el docente.
 */
class Nota
{
    public const MINIMA = 0.0;
    public const MAXIMA = 5.0;

    private float $valor;

    private function __construct(float $valor)
    {
        $this->valor = $valor;
    }

    public static function desdeValor(float $valor): self
    {
        self::asegurarRango($valor);
        $valorNormalizado = self::normalizar($valor);

        return new self($valorNormalizado);
    }

    public function valor(): float
    {
        return $this->valor;
    }

    public function valorFormateado(): string
    {
        return number_format($this->valor, 2, '.', '');
    }

    private static function normalizar(float $valor): float
    {
        return round($valor, 2);
    }

    private static function asegurarRango(float $valor): void
    {
        if ($valor < self::MINIMA || $valor > self::MAXIMA) {
            throw new InvalidArgumentException(
                sprintf('La nota debe estar entre %.2f y %.2f.', self::MINIMA, self::MAXIMA)
            );
        }
    }
}
