<section class="card">
    <h2>Registrar nota</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="index.php?entity=grades&action=store">
        <div class="form-group">
            <label for="estudiante">Estudiante</label>
            <select name="estudiante" id="estudiante" required>
                <option value="">Seleccione</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo htmlspecialchars($student['codigo']); ?>" <?php echo ($grade['estudiante'] ?? $_GET['estudiante'] ?? '') === $student['codigo'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($student['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="materia">Materia</label>
            <select name="materia" id="materia" required>
                <option value="">Seleccione</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?php echo htmlspecialchars($subject['codigo']); ?>" <?php echo ($grade['materia'] ?? $_GET['materia'] ?? '') === $subject['codigo'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($subject['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="actividad">Actividad</label>
            <input type="text" id="actividad" name="actividad" value="<?php echo htmlspecialchars($grade['actividad'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="nota">Nota</label>
            <input type="number" step="0.01" min="0.01" max="4.99" id="nota" name="nota" value="<?php echo htmlspecialchars($grade['nota'] ?? ''); ?>" required>
        </div>
        <button type="submit">Guardar</button>
        <a class="button-link secondary" href="index.php?entity=grades">Cancelar</a>
    </form>
</section>
