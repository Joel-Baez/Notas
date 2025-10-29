<?php
/** @var array $notas */
/** @var array $resumen */
/** @var array $estudiantes */
/** @var array $materias */
?>
<div class="encabezado">
    <h2>Gestión de calificaciones</h2>
</div>
<section class="tarjeta">
    <h3>Registrar nueva nota</h3>
    <form method="post" action="index.php?modulo=calificaciones&operacion=registrar" class="formulario">
        <div class="fila">
            <div class="campo">
                <label for="estudiante">Estudiante</label>
                <select id="estudiante" name="estudiante" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estudiantes as $estudiante): ?>
                        <option value="<?= htmlspecialchars($estudiante['codigo']) ?>">
                            <?= htmlspecialchars($estudiante['nombre'] . ' (' . $estudiante['programa_nombre'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo">
                <label for="materia">Materia</label>
                <select id="materia" name="materia" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?= htmlspecialchars($materia['codigo']) ?>">
                            <?= htmlspecialchars($materia['nombre'] . ' (' . $materia['programa_nombre'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="fila">
            <div class="campo">
                <label for="actividad">Actividad</label>
                <input type="text" id="actividad" name="actividad" required>
            </div>
            <div class="campo">
                <label for="valor">Nota</label>
                <input type="number" step="0.01" min="0.01" max="5" id="valor" name="valor" required>
            </div>
        </div>
        <button type="submit">Guardar nota</button>
    </form>
</section>

<h3>Notas registradas</h3>
<table>
    <thead>
        <tr>
            <th>Materia</th>
            <th>Estudiante</th>
            <th>Actividad</th>
            <th>Nota</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($notas as $nota): ?>
            <tr>
                <td><?= htmlspecialchars($nota['materia_nombre']) ?></td>
                <td><?= htmlspecialchars($nota['estudiante_nombre']) ?></td>
                <td><?= htmlspecialchars($nota['actividad']) ?></td>
                <td><?= number_format((float) $nota['valor'], 2) ?></td>
                <td class="acciones">
                    <a href="index.php?modulo=calificaciones&operacion=editar&id=<?= htmlspecialchars((string) $nota['id']) ?>">Editar</a>
                    <a href="index.php?modulo=calificaciones&operacion=confirmar&id=<?= htmlspecialchars((string) $nota['id']) ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$notas): ?>
            <tr><td colspan="5">No hay notas registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<h3>Promedios por materia y estudiante</h3>
<table>
    <thead>
        <tr>
            <th>Materia</th>
            <th>Estudiante</th>
            <th>Promedio</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($resumen as $fila): ?>
            <tr>
                <td><?= htmlspecialchars($fila['materia_nombre']) ?></td>
                <td><?= htmlspecialchars($fila['estudiante_nombre']) ?></td>
                <td><?= number_format((float) $fila['promedio'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$resumen): ?>
            <tr><td colspan="3">No hay promedios disponibles.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
