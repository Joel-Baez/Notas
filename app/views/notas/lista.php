<section>
    <div class="encabezado">
        <h2>Notas por estudiante y materia</h2>
        <a class="boton" href="?entidad=notas&accion=crear">Registrar nota</a>
    </div>
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
        <p>No hay notas registradas.</p>
    <?php endif; ?>
</section>
