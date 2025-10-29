<section class="card">
    <div class="header">
        <h2>Materias</h2>
        <a class="button-link" href="index.php?entity=subjects&action=create">Nueva materia</a>
    </div>
    <form method="get" class="form-inline" action="index.php">
        <input type="hidden" name="entity" value="subjects">
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
            <th>Programa</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($subjects as $subject): ?>
            <tr>
                <td><?php echo htmlspecialchars($subject['codigo']); ?></td>
                <td><?php echo htmlspecialchars($subject['nombre']); ?></td>
                <td><?php echo htmlspecialchars($subject['programa']); ?></td>
                <td>
                    <a class="button-link" href="index.php?entity=subjects&action=show&code=<?php echo urlencode($subject['codigo']); ?>">Ver</a>
                    <a class="button-link" href="index.php?entity=subjects&action=edit&code=<?php echo urlencode($subject['codigo']); ?>">Editar</a>
                    <a class="button-link secondary" href="index.php?entity=subjects&action=confirmDelete&code=<?php echo urlencode($subject['codigo']); ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
