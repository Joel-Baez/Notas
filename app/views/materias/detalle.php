<?php
/** @var array $materia */
/** @var array $promedios */
?>
<h2>Detalle de la materia</h2>
<p><strong>Código:</strong> <?= htmlspecialchars($materia['codigo']) ?></p>
<p><strong>Nombre:</strong> <?= htmlspecialchars($materia['nombre']) ?></p>
<p><strong>Programa:</strong> <?= htmlspecialchars($materia['programa']) ?></p>

<h3>Estudiantes con promedio</h3>
<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Promedio</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($promedios as $registro): ?>
            <tr>
                <td><?= htmlspecialchars($registro['codigo']) ?></td>
                <td><?= htmlspecialchars($registro['nombre']) ?></td>
                <td><?= number_format((float) $registro['promedio'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$promedios): ?>
            <tr><td colspan="3">No hay notas registradas para esta materia.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<a class="boton" href="index.php?modulo=materias">Volver</a>
