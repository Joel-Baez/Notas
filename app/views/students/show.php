<section class="card">
    <h2><?php echo htmlspecialchars($student['nombre']); ?> (<?php echo htmlspecialchars($student['codigo']); ?>)</h2>
    <p><strong>Correo:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
    <p><strong>Programa:</strong> <?php echo htmlspecialchars($student['programa']); ?></p>
    <p>
        <a class="button-link" href="index.php?entity=grades&action=create&estudiante=<?php echo urlencode($student['codigo']); ?>">Registrar nota</a>
        <a class="button-link secondary" href="index.php?entity=students">Volver</a>
    </p>
</section>
<section class="card">
    <h3>Materias del programa y promedio</h3>
    <?php if ($subjectsWithAverage): ?>
        <table>
            <thead>
            <tr>
                <th>Materia</th>
                <th>Promedio</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($subjectsWithAverage as $subject): ?>
                <tr>
                    <td><?php echo htmlspecialchars($subject['nombre']); ?></td>
                    <td><?php echo number_format((float) $subject['promedio'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay materias registradas para el programa.</p>
    <?php endif; ?>
</section>
<section class="card">
    <h3>Notas registradas</h3>
    <?php if ($grades): ?>
        <?php
        $grouped = [];
        foreach ($grades as $grade) {
            $grouped[$grade['materia_nombre']][] = $grade;
        }
        ?>
        <?php foreach ($grouped as $subjectName => $subjectGrades): ?>
            <h4><?php echo htmlspecialchars($subjectName); ?></h4>
            <table>
                <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Nota</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($subjectGrades as $grade): ?>
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
