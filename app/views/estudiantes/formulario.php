<section class="tarjeta">
    <h2><?= $accion === 'guardar' ? 'Registrar estudiante' : 'Actualizar estudiante' ?></h2>
    <form method="post" action="?entidad=estudiantes&accion=<?= $accion ?><?= $accion === 'actualizar' ? '&codigo=' . urlencode($estudiante['codigo']) : '' ?>" class="formulario">
        <div class="campo">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" name="codigo" maxlength="5" value="<?= htmlspecialchars($estudiante['codigo']) ?>" <?= $accion === 'actualizar' ? 'readonly' : 'required' ?>>
        </div>
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($estudiante['nombre']) ?>">
        </div>
        <div class="campo">
            <label for="email">Correo</label>
            <input type="email" id="email" name="email" required value="<?= htmlspecialchars($estudiante['email']) ?>">
        </div>
        <div class="campo">
            <label for="programa">Programa</label>
            <select id="programa" name="programa" required>
                <option value="">Seleccione</option>
                <?php foreach ($programas as $programa): ?>
                    <option value="<?= htmlspecialchars($programa['codigo']) ?>" <?= $programa['codigo'] === $estudiante['programa'] ? 'selected' : '' ?>><?= htmlspecialchars($programa['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="boton">Guardar</button>
        <a class="boton secundario" href="?entidad=estudiantes">Cancelar</a>
    </form>
</section>
