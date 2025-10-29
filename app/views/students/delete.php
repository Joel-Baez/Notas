<section class="card">
    <h2>Eliminar estudiante</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <p>¿Está seguro de que desea eliminar al estudiante <strong><?php echo htmlspecialchars($student['nombre']); ?></strong>?</p>
    <form method="post" action="index.php?entity=students&action=destroy&code=<?php echo urlencode($student['codigo']); ?>">
        <button type="submit">Sí, eliminar</button>
        <a class="button-link secondary" href="index.php?entity=students">Cancelar</a>
    </form>
</section>
