<?php
/** @var array $programa */
/** @var string $accion */
?>
<h2><?= $accion === 'registrar' ? 'Registrar programa' : 'Actualizar programa' ?></h2>
<form method="post" class="formulario">
    <div class="campo">
        <label for="codigo">Código</label>
        <input type="text" id="codigo" name="codigo" value="<?= htmlspecialchars($programa['codigo'] ?? '') ?>" <?= $accion === 'registrar' ? 'required' : 'readonly' ?>>
    </div>
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($programa['nombre'] ?? '') ?>" required>
    </div>
    <button type="submit">Guardar</button>
    <a class="boton" href="index.php?modulo=programas">Cancelar</a>
</form>
