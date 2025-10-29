<section class="card">
    <h2>Eliminar materia</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <p>¿Está seguro de que desea eliminar la materia <strong><?php echo htmlspecialchars($subject['nombre']); ?></strong>?</p>
    <form method="post" action="index.php?entity=subjects&action=destroy&code=<?php echo urlencode($subject['codigo']); ?>">
        <button type="submit">Sí, eliminar</button>
        <a class="button-link secondary" href="index.php?entity=subjects">Cancelar</a>
    </form>
</section>
