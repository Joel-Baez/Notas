<section class="card">
    <div class="header">
        <h2>Notas</h2>
        <a class="button-link" href="index.php?entity=grades&action=create">Registrar nota</a>
    </div>
    <form method="get" action="index.php" class="form-inline">
        <input type="hidden" name="entity" value="grades">
        <div class="form-group">
            <label for="student">Filtrar por estudiante</label>
            <select name="student" id="student" onchange="this.form.submit()">
                <option value="">Seleccione</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo htmlspecialchars($student['codigo']); ?>" <?php echo $studentFilter === $student['codigo'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($student['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="subject">Filtrar por materia</label>
            <select name="subject" id="subject" onchange="this.form.submit()">
                <option value="">Seleccione</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?php echo htmlspecialchars($subject['codigo']); ?>" <?php echo $subjectFilter === $subject['codigo'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($subject['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    <?php if ($grades): ?>
        <table>
            <thead>
            <tr>
                <th>Estudiante</th>
                <th>Materia</th>
                <th>Actividad</th>
                <th>Nota</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($grades as $grade): ?>
                <tr>
                    <td><?php echo htmlspecialchars($grade['estudiante_nombre'] ?? $grade['estudiante']); ?></td>
                    <td><?php echo htmlspecialchars($grade['materia_nombre'] ?? $grade['materia']); ?></td>
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
        <?php if ($studentFilter): ?>
            <p>
                <a class="button-link secondary" href="index.php?entity=grades&action=deleteAllForStudent&student=<?php echo urlencode($studentFilter); ?>">Eliminar todas las notas del estudiante</a>
            </p>
        <?php endif; ?>
    <?php else: ?>
        <p>No hay notas para los filtros seleccionados.</p>
    <?php endif; ?>
</section>
