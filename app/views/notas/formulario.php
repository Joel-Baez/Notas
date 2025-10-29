<section class="tarjeta">
    <h2><?= $accion === 'guardar' ? 'Registrar nota' : 'Actualizar nota' ?></h2>
    <?php $accionUrl = '?entidad=notas&accion=' . $accion . ($accion === 'actualizar' ? '&id=' . urlencode((string) $nota['id']) : ''); ?>
    <form method="post" action="<?= $accionUrl ?>" class="formulario">
        <div class="campo">
            <label for="estudiante">Estudiante</label>
            <?php if ($accion === 'guardar'): ?>
                <select id="estudiante" name="estudiante" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <option value="<?= htmlspecialchars($estudiante['codigo']) ?>" <?= $estudiante['codigo'] === ($nota['estudiante'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars($estudiante['nombre']) ?> (<?= htmlspecialchars($estudiante['programa_nombre']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="text" value="<?= htmlspecialchars($nota['estudiante']) ?>" readonly>
                <input type="hidden" name="estudiante" value="<?= htmlspecialchars($nota['estudiante']) ?>">
            <?php endif; ?>
        </div>
        <div class="campo">
            <label for="materia">Materia</label>
            <?php if ($accion === 'guardar'): ?>
                <select id="materia" name="materia" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?= htmlspecialchars($materia['codigo']) ?>" <?= $materia['codigo'] === ($nota['materia'] ?? '') ? 'selected' : '' ?>><?= htmlspecialchars($materia['nombre']) ?> (<?= htmlspecialchars($materia['programa_nombre']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="text" value="<?= htmlspecialchars($nota['materia']) ?>" readonly>
                <input type="hidden" name="materia" value="<?= htmlspecialchars($nota['materia']) ?>">
            <?php endif; ?>
        </div>
        <div class="campo">
            <label for="actividad">Actividad</label>
            <?php if ($accion === 'guardar'): ?>
                <input type="text" id="actividad" name="actividad" required maxlength="50" value="<?= htmlspecialchars($nota['actividad']) ?>">
            <?php else: ?>
                <input type="text" value="<?= htmlspecialchars($nota['actividad']) ?>" readonly>
                <input type="hidden" name="actividad" value="<?= htmlspecialchars($nota['actividad']) ?>">
            <?php endif; ?>
        </div>
        <div class="campo">
            <label for="nota">Nota</label>
            <input type="number" step="0.01" min="0.01" max="5" id="nota" name="nota" required value="<?= htmlspecialchars($nota['nota']) ?>">
        </div>
        <button type="submit" class="boton">Guardar</button>
        <a class="boton secundario" href="?entidad=notas">Cancelar</a>
    </form>
</section>
