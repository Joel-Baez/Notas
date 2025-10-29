<?php
/** @var array $valores */
/** @var string|null $error */
?>
<h2>Ingreso al sistema</h2>
<p>Utilice su código y correo institucional para acceder.</p>
<?php if ($error): ?>
    <div class="alerta alerta-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post" class="formulario">
    <div class="campo">
        <label for="codigo">Código del estudiante</label>
        <input type="text" name="codigo" id="codigo" value="<?= htmlspecialchars($valores['codigo'] ?? '') ?>" required>
    </div>
    <div class="campo">
        <label for="correo">Correo electrónico</label>
        <input type="email" name="correo" id="correo" value="<?= htmlspecialchars($valores['correo'] ?? '') ?>" required>
    </div>
    <button type="submit">Entrar</button>
</form>
