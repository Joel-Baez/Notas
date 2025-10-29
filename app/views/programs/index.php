<section class="card">
    <div class="header">
        <h2>Programas de formación</h2>
        <a class="button-link" href="index.php?entity=programs&action=create">Nuevo programa</a>
    </div>
    <table>
        <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($programs as $program): ?>
            <tr>
                <td><?php echo htmlspecialchars($program['codigo']); ?></td>
                <td><?php echo htmlspecialchars($program['nombre']); ?></td>
                <td>
                    <a class="button-link" href="index.php?entity=programs&action=show&code=<?php echo urlencode($program['codigo']); ?>">Ver</a>
                    <a class="button-link" href="index.php?entity=programs&action=edit&code=<?php echo urlencode($program['codigo']); ?>">Editar</a>
                    <a class="button-link secondary" href="index.php?entity=programs&action=confirmDelete&code=<?php echo urlencode($program['codigo']); ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
