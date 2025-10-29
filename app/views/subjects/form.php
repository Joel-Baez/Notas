<section class="card">
    <h2><?php echo $subject ? 'Editar materia' : 'Nueva materia'; ?></h2>
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="index.php?entity=subjects&action=<?php echo $subject ? 'update&code=' . urlencode($subject['codigo']) : 'store'; ?>">
        <?php if (!$subject): ?>
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" name="codigo" value="<?php echo htmlspecialchars($subject['codigo'] ?? ''); ?>" required>
            </div>
        <?php else: ?>
            <p><strong>Código:</strong> <?php echo htmlspecialchars($subject['codigo']); ?></p>
        <?php endif; ?>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($subject['nombre'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="programa">Programa</label>
            <select id="programa" name="programa" required>
                <option value="">Seleccione</option>
                <?php foreach ($programs as $program): ?>
                    <option value="<?php echo htmlspecialchars($program['codigo']); ?>" <?php echo ($subject['programa'] ?? '') === $program['codigo'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($program['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Guardar</button>
        <a class="button-link secondary" href="index.php?entity=subjects">Cancelar</a>
    </form>
</section>
