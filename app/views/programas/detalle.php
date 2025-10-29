<section class="tarjeta">
    <h2><?= htmlspecialchars($programa['nombre']) ?></h2>
    <p><strong>Código:</strong> <?= htmlspecialchars($programa['codigo']) ?></p>
</section>

<section>
    <h3>Materias del programa</h3>
    <?php if ($materias): ?>
        <ul class="lista-simple">
            <?php foreach ($materias as $materia): ?>
                <li><a href="?entidad=materias&accion=mostrar&codigo=<?= urlencode($materia['codigo']) ?>"><?= htmlspecialchars($materia['nombre']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay materias asociadas.</p>
    <?php endif; ?>
</section>

<section>
    <h3>Estudiantes matriculados</h3>
    <?php if ($estudiantes): ?>
        <ul class="lista-simple">
            <?php foreach ($estudiantes as $estudiante): ?>
                <li><a href="?entidad=estudiantes&accion=mostrar&codigo=<?= urlencode($estudiante['codigo']) ?>"><?= htmlspecialchars($estudiante['nombre']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay estudiantes registrados.</p>
    <?php endif; ?>
</section>
