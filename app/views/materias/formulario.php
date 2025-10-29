<section class="tarjeta">
    <h2><?= $accion === 'guardar' ? 'Registrar materia' : 'Actualizar materia' ?></h2>
    <form method="post" action="?entidad=materias&accion=<?= $accion ?><?= $accion === 'actualizar' ? '&codigo=' . urlencode($materia['codigo']) : '' ?>" class="formulario">
        <div class="campo">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" name="codigo" maxlength="4" value="<?= htmlspecialchars($materia['codigo']) ?>" <?= $accion === 'actualizar' ? 'readonly' : 'required' ?>>
        </div>
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($materia['nombre']) ?>">
        </div>
        <div class="campo">
            <label for="programa">Programa</label>
            <select id="programa" name="programa" required>
                <option value="">Seleccione</option>
                <?php foreach ($programas as $programa): ?>
                    <option value="<?= htmlspecialchars($programa['codigo']) ?>" <?= $programa['codigo'] === $materia['programa'] ? 'selected' : '' ?>><?= htmlspecialchars($programa['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="boton">Guardar</button>
        <a class="boton secundario" href="?entidad=materias">Cancelar</a>
    </form>
</section>
