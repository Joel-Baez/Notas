<section class="card">
    <h2>Programa: <?php echo htmlspecialchars($program['nombre']); ?> (<?php echo htmlspecialchars($program['codigo']); ?>)</h2>
    <p><a class="button-link" href="index.php?entity=programs">Volver</a></p>
</section>
<section class="card">
    <h3>Materias del programa</h3>
    <?php if ($subjects): ?>
        <table>
            <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($subjects as $subject): ?>
                <tr>
                    <td><?php echo htmlspecialchars($subject['codigo']); ?></td>
                    <td><a href="index.php?entity=subjects&action=show&code=<?php echo urlencode($subject['codigo']); ?>"><?php echo htmlspecialchars($subject['nombre']); ?></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay materias registradas.</p>
    <?php endif; ?>
</section>
<section class="card">
    <h3>Estudiantes del programa</h3>
    <?php if ($students): ?>
        <table>
            <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['codigo']); ?></td>
                    <td><a href="index.php?entity=students&action=show&code=<?php echo urlencode($student['codigo']); ?>"><?php echo htmlspecialchars($student['nombre']); ?></a></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay estudiantes registrados.</p>
    <?php endif; ?>
</section>
