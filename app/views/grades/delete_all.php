<section class="card">
    <h2>Eliminar todas las notas</h2>
    <p>¿Está seguro de eliminar todas las notas registradas para el estudiante <strong><?php echo htmlspecialchars($student['nombre']); ?></strong>?</p>
    <form method="post" action="index.php?entity=grades&action=deleteAllForStudent&student=<?php echo urlencode($student['codigo']); ?>">
        <button type="submit">Sí, eliminar</button>
        <a class="button-link secondary" href="index.php?entity=grades&student=<?php echo urlencode($student['codigo']); ?>">Cancelar</a>
    </form>
</section>
