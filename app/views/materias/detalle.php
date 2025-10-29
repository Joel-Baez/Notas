<section class="tarjeta">
    <h2><?= htmlspecialchars($materia['nombre']) ?></h2>
    <dl class="detalle">
        <div><dt>Código</dt><dd><?= htmlspecialchars($materia['codigo']) ?></dd></div>
        <div><dt>Programa</dt><dd><?= htmlspecialchars($materia['programa_nombre']) ?> (<?= htmlspecialchars($materia['programa']) ?>)</dd></div>
    </dl>
</section>

<section>
    <h3>Estudiantes inscritos</h3>
    <?php if ($estudiantes): ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Promedio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <tr>
                        <td><?= htmlspecialchars($estudiante['nombre']) ?></td>
                        <td><?= number_format($estudiante['promedio'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay estudiantes con notas en esta materia.</p>
    <?php endif; ?>
</section>
