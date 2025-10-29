<section class="card">
    <h2><?php echo htmlspecialchars($subject['nombre']); ?> (<?php echo htmlspecialchars($subject['codigo']); ?>)</h2>
    <p><strong>Programa:</strong> <?php echo htmlspecialchars($subject['programa']); ?></p>
    <p>
        <a class="button-link" href="index.php?entity=subjects">Volver</a>
    </p>
</section>
<section class="card">
    <h3>Estudiantes y promedio</h3>
    <?php if ($students): ?>
        <table>
            <thead>
            <tr>
                <th>Estudiante</th>
                <th>Promedio</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><a href="index.php?entity=students&action=show&code=<?php echo urlencode($student['codigo']); ?>"><?php echo htmlspecialchars($student['nombre']); ?></a></td>
                    <td><?php echo number_format((float) $student['promedio'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay estudiantes con notas registradas en esta materia.</p>
    <?php endif; ?>
</section>
<section class="card">
    <h3>Notas registradas</h3>
    <?php if ($grades): ?>
        <?php
        $grouped = [];
        foreach ($grades as $grade) {
            $grouped[$grade['estudiante_nombre']][] = $grade;
        }
        ?>
        <?php foreach ($grouped as $studentName => $studentGrades): ?>
            <h4><?php echo htmlspecialchars($studentName); ?></h4>
            <table>
                <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Nota</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($studentGrades as $grade): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($grade['actividad']); ?></td>
                        <td><?php echo number_format((float) $grade['nota'], 2); ?></td>
                        <td>
                            <a class="button-link" href="index.php?entity=grades&action=edit&subject=<?php echo urlencode($grade['materia']); ?>&student=<?php echo urlencode($grade['estudiante']); ?>&activity=<?php echo urlencode($grade['actividad']); ?>">Editar</a>
                            <a class="button-link secondary" href="index.php?entity=grades&action=confirmDelete&subject=<?php echo urlencode($grade['materia']); ?>&student=<?php echo urlencode($grade['estudiante']); ?>&activity=<?php echo urlencode($grade['actividad']); ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay notas registradas.</p>
    <?php endif; ?>
</section>
