<section>
    <div class="encabezado">
        <h2>Notas registradas</h2>
        <a class="boton" href="?entidad=notas&accion=crear">Registrar nota</a>
    </div>
    <?php if ($notas): ?>
        <table class="tabla">
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
                <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?= htmlspecialchars($nota['estudiante_nombre']) ?></td>
                        <td><?= htmlspecialchars($nota['materia_nombre']) ?></td>
                        <td><?= htmlspecialchars($nota['actividad']) ?></td>
                        <td><?= number_format($nota['nota'], 2) ?></td>
                        <td class="acciones-tabla">
                            <a href="?entidad=notas&accion=editar&id=<?= urlencode((string) $nota['id']) ?>">Editar</a>
                            <a href="?entidad=notas&accion=confirmarEliminar&id=<?= urlencode((string) $nota['id']) ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay notas registradas.</p>
    <?php endif; ?>
</section>

<section>
    <h3>Promedios por estudiante y materia</h3>
    <?php if ($resumen): ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Materia</th>
                    <th>Promedio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resumen as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['estudiante_nombre']) ?></td>
                        <td><?= htmlspecialchars($fila['materia_nombre']) ?></td>
                        <td><?= number_format($fila['promedio'], 2) ?></td>
                        <td class="acciones-tabla">
                            <a href="?entidad=estudiantes&accion=mostrar&codigo=<?= urlencode($fila['estudiante']) ?>">Ver estudiante</a>
                            <a href="?entidad=materias&accion=mostrar&codigo=<?= urlencode($fila['materia']) ?>">Ver materia</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aún no hay promedios calculados.</p>
    <?php endif; ?>
</section>
