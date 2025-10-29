<section class="card">
    <h2>Eliminar programa</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <p>¿Está seguro de que desea eliminar el programa <strong><?php echo htmlspecialchars($program['nombre']); ?></strong>?</p>
    <form method="post" action="index.php?entity=programs&action=destroy&code=<?php echo urlencode($program['codigo']); ?>">
        <button type="submit">Sí, eliminar</button>
        <a class="button-link secondary" href="index.php?entity=programs">Cancelar</a>
    </form>
</section>
