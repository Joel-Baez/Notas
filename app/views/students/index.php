<section class="card">
    <div class="header">
        <h2>Estudiantes</h2>
        <a class="button-link" href="index.php?entity=students&action=create">Nuevo estudiante</a>
    </div>
    <form method="get" class="form-inline" action="index.php">
        <input type="hidden" name="entity" value="students">
        <div class="form-group">
            <label for="program">Programa</label>
            <select name="program" id="program" onchange="this.form.submit()">
                <option value="">Todos</option>
                <?php foreach ($programs as $program): ?>
                    <option value="<?php echo htmlspecialchars($program['codigo']); ?>" <?php echo $programFilter === $program['codigo'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($program['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    <table>
        <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Programa</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo htmlspecialchars($student['codigo']); ?></td>
                <td><?php echo htmlspecialchars($student['nombre']); ?></td>
                <td><?php echo htmlspecialchars($student['email']); ?></td>
                <td><?php echo htmlspecialchars($student['programa']); ?></td>
                <td>
                    <a class="button-link" href="index.php?entity=students&action=show&code=<?php echo urlencode($student['codigo']); ?>">Ver</a>
                    <a class="button-link" href="index.php?entity=students&action=edit&code=<?php echo urlencode($student['codigo']); ?>">Editar</a>
                    <a class="button-link secondary" href="index.php?entity=students&action=confirmDelete&code=<?php echo urlencode($student['codigo']); ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
