<section class="card">
    <h2>Actualizar nota</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <p><strong>Estudiante:</strong> <?php echo htmlspecialchars($grade['estudiante_nombre'] ?? $grade['estudiante']); ?></p>
    <p><strong>Materia:</strong> <?php echo htmlspecialchars($grade['materia_nombre'] ?? $grade['materia']); ?></p>
    <p><strong>Actividad:</strong> <?php echo htmlspecialchars($grade['actividad']); ?></p>
    <form method="post" action="index.php?entity=grades&action=update&subject=<?php echo urlencode($grade['materia']); ?>&student=<?php echo urlencode($grade['estudiante']); ?>&activity=<?php echo urlencode($grade['actividad']); ?>">
        <div class="form-group">
            <label for="nota">Nota</label>
            <input type="number" step="0.01" min="0.01" max="4.99" id="nota" name="nota" value="<?php echo htmlspecialchars($grade['nota']); ?>" required>
        </div>
        <button type="submit">Guardar</button>
        <a class="button-link secondary" href="index.php?entity=grades&student=<?php echo urlencode($grade['estudiante']); ?>">Cancelar</a>
    </form>
</section>
