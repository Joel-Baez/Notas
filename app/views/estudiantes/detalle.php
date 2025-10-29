<?php
/** @var array $estudiante */
/** @var array $materias */
/** @var array $notas */
?>
<h2>Detalle del estudiante</h2>
<p><strong>Código:</strong> <?= htmlspecialchars($estudiante['codigo']) ?></p>
<p><strong>Nombre:</strong> <?= htmlspecialchars($estudiante['nombre']) ?></p>
<p><strong>Correo:</strong> <?= htmlspecialchars($estudiante['email']) ?></p>
<p><strong>Programa:</strong> <?= htmlspecialchars($estudiante['programa_nombre']) ?></p>
<a class="boton" href="index.php?modulo=calificaciones&operacion=limpiar&estudiante=<?= urlencode($estudiante['codigo']) ?>">Eliminar todas las notas</a>

<h3>Materias con promedio</h3>
<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Promedio</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($materias as $materia): ?>
            <tr>
                <td><?= htmlspecialchars($materia['codigo']) ?></td>
                <td><?= htmlspecialchars($materia['nombre']) ?></td>
                <td><?= number_format((float) $materia['promedio'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$materias): ?>
            <tr><td colspan="3">No hay materias registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<h3>Notas registradas</h3>
<table>
    <thead>
        <tr>
            <th>Materia</th>
            <th>Actividad</th>
            <th>Nota</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($notas as $nota): ?>
            <tr>
                <td><?= htmlspecialchars($nota['materia_nombre']) ?></td>
                <td><?= htmlspecialchars($nota['actividad']) ?></td>
                <td><?= number_format((float) $nota['valor'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$notas): ?>
            <tr><td colspan="3">No hay notas registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<a class="boton" href="index.php?modulo=estudiantes">Volver</a>
