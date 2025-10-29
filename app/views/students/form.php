<section class="card">
    <h2><?php echo $student ? 'Editar estudiante' : 'Nuevo estudiante'; ?></h2>
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="index.php?entity=students&action=<?php echo $student ? 'update&code=' . urlencode($student['codigo']) : 'store'; ?>">
        <?php if (!$student): ?>
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" name="codigo" value="<?php echo htmlspecialchars($student['codigo'] ?? ''); ?>" required>
            </div>
        <?php else: ?>
            <p><strong>Código:</strong> <?php echo htmlspecialchars($student['codigo']); ?></p>
        <?php endif; ?>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($student['nombre'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="programa">Programa</label>
            <select id="programa" name="programa" required>
                <option value="">Seleccione</option>
                <?php foreach ($programs as $program): ?>
                    <option value="<?php echo htmlspecialchars($program['codigo']); ?>" <?php echo ($student['programa'] ?? '') === $program['codigo'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($program['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Guardar</button>
        <a class="button-link secondary" href="index.php?entity=students">Cancelar</a>
    </form>
</section>
