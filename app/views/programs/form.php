<section class="card">
    <h2><?php echo $program ? 'Editar programa' : 'Nuevo programa'; ?></h2>
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="index.php?entity=programs&action=<?php echo $program ? 'update&code=' . urlencode($program['codigo']) : 'store'; ?>">
        <?php if (!$program): ?>
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" name="codigo" value="<?php echo htmlspecialchars($program['codigo'] ?? ''); ?>" required>
            </div>
        <?php else: ?>
            <p><strong>Código:</strong> <?php echo htmlspecialchars($program['codigo']); ?></p>
        <?php endif; ?>
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($program['nombre'] ?? ''); ?>" required>
        </div>
        <button type="submit">Guardar</button>
        <a class="button-link secondary" href="index.php?entity=programs">Cancelar</a>
    </form>
</section>
