<section class="tarjeta">
    <h2><?= htmlspecialchars($estudiante['nombre']) ?></h2>
    <dl class="detalle">
        <div><dt>Código</dt><dd><?= htmlspecialchars($estudiante['codigo']) ?></dd></div>
        <div><dt>Correo</dt><dd><?= htmlspecialchars($estudiante['email']) ?></dd></div>
        <div><dt>Programa</dt><dd><?= htmlspecialchars($estudiante['programa_nombre']) ?> (<?= htmlspecialchars($estudiante['programa']) ?>)</dd></div>
        <div><dt>Promedio general</dt><dd><?= number_format($estudiante['promedio'], 2) ?></dd></div>
    </dl>
</section>

<section>
    <h3>Materias inscritas</h3>
    <?php if ($estudiante['materias']): ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Promedio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiante['materias'] as $materia): ?>
                    <tr>
                        <td><?= htmlspecialchars($materia['nombre']) ?></td>
                        <td><?= number_format($materia['promedio'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($materiasPrograma): ?>
        <ul class="lista-simple">
            <?php foreach ($materiasPrograma as $materia): ?>
                <li><?= htmlspecialchars($materia['nombre']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay materias registradas en el programa.</p>
    <?php endif; ?>
</section>

<section>
    <h3>Notas registradas</h3>
    <?php if ($estudiante['notas']): ?>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Actividad</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiante['notas'] as $nota): ?>
                    <tr>
                        <td><?= htmlspecialchars($nota['materia_nombre']) ?></td>
                        <td><?= htmlspecialchars($nota['actividad']) ?></td>
                        <td><?= number_format($nota['nota'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a class="boton peligro" href="?entidad=notas&accion=confirmarEliminarTodas&estudiante=<?= urlencode($estudiante['codigo']) ?>">Eliminar todas las notas</a></p>
    <?php else: ?>
        <p>No hay notas registradas.</p>
    <?php endif; ?>
</section>
