<?php

declare(strict_types=1);

use App\Models\Nota;

/** @var array|null $resultado */
$datos = $resultado['datos'] ?? [];
$errores = $resultado['errores'] ?? [];
$nota = $resultado['nota'] ?? null;
$valorAnterior = $datos['valor'] ?? '';
?>
<h1>Registrar nota</h1>

<?php if ($resultado !== null): ?>
    <div class="alerta <?= $resultado['exito'] ? 'alerta--exito' : 'alerta--error' ?>">
        <strong><?= htmlspecialchars($resultado['mensaje'], ENT_QUOTES, 'UTF-8') ?></strong>
        <?php if ($resultado['exito'] && $nota instanceof Nota): ?>
            <p>Valor registrado: <strong><?= htmlspecialchars($nota->valorFormateado(), ENT_QUOTES, 'UTF-8') ?></strong></p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<form method="POST" action="">
    <div>
        <label for="valor">Nota (0.00 - 5.00)</label>
        <input
            type="number"
            id="valor"
            name="valor"
            min="0"
            max="5"
            step="0.01"
            value="<?= htmlspecialchars((string) $valorAnterior, ENT_QUOTES, 'UTF-8') ?>"
            required
        >
        <?php if (isset($errores['valor'])): ?>
            <p class="campo__error"><?= htmlspecialchars($errores['valor'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
    </div>
    <button type="submit">Guardar</button>
</form>
