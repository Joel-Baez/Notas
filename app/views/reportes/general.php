<?php
/** @var array $programas */
/** @var array $estudiantes */
/** @var array $materiasPorPrograma */
/** @var array $estudiantesPorPrograma */
/** @var array $materiasDeEstudiante */
/** @var array $notasDetalladas */
/** @var array $porMateria */
?>
<h2>Reportes generales</h2>

<section class="tarjeta">
    <h3>Programas registrados</h3>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($programas as $programa): ?>
                <tr>
                    <td><?= htmlspecialchars($programa['codigo']) ?></td>
                    <td><?= htmlspecialchars($programa['nombre']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$programas): ?>
                <tr><td colspan="2">No hay programas registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<section class="tarjeta">
    <h3>Materias por programa</h3>
    <?php foreach ($programas as $programa): ?>
        <h4><?= htmlspecialchars($programa['nombre']) ?></h4>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materiasPorPrograma[$programa['codigo']] as $materia): ?>
                    <tr>
                        <td><?= htmlspecialchars($materia['codigo']) ?></td>
                        <td><?= htmlspecialchars($materia['nombre']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$materiasPorPrograma[$programa['codigo']]): ?>
                    <tr><td colspan="2">Sin materias asociadas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</section>

<section class="tarjeta">
    <h3>Estudiantes por programa</h3>
    <?php foreach ($programas as $programa): ?>
        <h4><?= htmlspecialchars($programa['nombre']) ?></h4>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudiantesPorPrograma[$programa['codigo']] as $estudiante): ?>
                    <tr>
                        <td><?= htmlspecialchars($estudiante['codigo']) ?></td>
                        <td><?= htmlspecialchars($estudiante['nombre']) ?></td>
                        <td><?= htmlspecialchars($estudiante['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$estudiantesPorPrograma[$programa['codigo']]): ?>
                    <tr><td colspan="3">Sin estudiantes asociados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</section>

<section class="tarjeta">
    <h3>Estudiantes por materia con promedio</h3>
    <?php foreach ($porMateria as $codigo => $registros): ?>
        <?php $nombreMateria = $registros[0]['materia_nombre'] ?? $codigo; ?>
        <h4><?= htmlspecialchars($nombreMateria) ?></h4>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Promedio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['estudiante']) ?></td>
                        <td><?= htmlspecialchars($fila['estudiante_nombre']) ?></td>
                        <td><?= number_format((float) $fila['promedio'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$registros): ?>
                    <tr><td colspan="3">Sin notas registradas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
    <?php if (!$porMateria): ?>
        <p>No hay calificaciones registradas aún.</p>
    <?php endif; ?>
</section>

<section class="tarjeta">
    <h3>Materias y promedios por estudiante</h3>
    <?php foreach ($estudiantes as $estudiante): ?>
        <h4><?= htmlspecialchars($estudiante['nombre']) ?></h4>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Promedio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materiasDeEstudiante[$estudiante['codigo']] as $materia): ?>
                    <tr>
                        <td><?= htmlspecialchars($materia['nombre']) ?></td>
                        <td><?= number_format((float) $materia['promedio'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$materiasDeEstudiante[$estudiante['codigo']]): ?>
                    <tr><td colspan="2">Sin materias disponibles.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</section>

<section class="tarjeta">
    <h3>Notas detalladas por estudiante</h3>
    <?php foreach ($estudiantes as $estudiante): ?>
        <h4><?= htmlspecialchars($estudiante['nombre']) ?></h4>
        <table>
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Actividad</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notasDetalladas[$estudiante['codigo']] as $nota): ?>
                    <tr>
                        <td><?= htmlspecialchars($nota['materia_nombre']) ?></td>
                        <td><?= htmlspecialchars($nota['actividad']) ?></td>
                        <td><?= number_format((float) $nota['valor'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$notasDetalladas[$estudiante['codigo']]): ?>
                    <tr><td colspan="3">Sin notas registradas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</section>
