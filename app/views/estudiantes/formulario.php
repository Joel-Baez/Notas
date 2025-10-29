<?php
/** @var array $estudiante */
/** @var array $programas */
/** @var string $accion */
?>
<h2><?= $accion === 'registrar' ? 'Registrar estudiante' : 'Actualizar estudiante' ?></h2>
<form method="post" class="formulario">
    <div class="campo">
        <label for="codigo">Código</label>
        <input type="text" id="codigo" name="codigo" value="<?= htmlspecialchars($estudiante['codigo'] ?? '') ?>" <?= $accion === 'registrar' ? 'required' : 'readonly' ?>>
    </div>
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($estudiante['nombre'] ?? '') ?>" required>
    </div>
    <div class="campo">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($estudiante['email'] ?? '') ?>" required>
    </div>
    <div class="campo">
        <label for="programa">Programa</label>
        <select id="programa" name="programa" required>
            <option value="">Seleccione...</option>
            <?php foreach ($programas as $programa): ?>
                <option value="<?= htmlspecialchars($programa['codigo']) ?>" <?= ($estudiante['programa'] ?? '') === $programa['codigo'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($programa['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit">Guardar</button>
    <a class="boton" href="index.php?modulo=estudiantes">Cancelar</a>
</form>
