<section class="card">
    <h2>Eliminar nota</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <p>¿Está seguro de que desea eliminar la nota de la actividad <strong><?php echo htmlspecialchars($grade['actividad']); ?></strong> del estudiante <strong><?php echo htmlspecialchars($grade['estudiante_nombre'] ?? $grade['estudiante']); ?></strong> en la materia <strong><?php echo htmlspecialchars($grade['materia_nombre'] ?? $grade['materia']); ?></strong>?</p>
    <form method="post" action="index.php?entity=grades&action=destroy&subject=<?php echo urlencode($grade['materia']); ?>&student=<?php echo urlencode($grade['estudiante']); ?>&activity=<?php echo urlencode($grade['actividad']); ?>">
        <button type="submit">Sí, eliminar</button>
        <a class="button-link secondary" href="index.php?entity=grades&student=<?php echo urlencode($grade['estudiante']); ?>">Cancelar</a>
    </form>
</section>
