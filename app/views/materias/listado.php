<?php
/** @var array $materias */
?>
<div class="encabezado">
    <h2>Materias</h2>
    <a class="boton" href="index.php?modulo=materias&operacion=registrar">Nueva materia</a>
</div>
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
        <?php foreach ($materias as $materia): ?>
            <tr>
                <td><?= htmlspecialchars($materia['codigo']) ?></td>
                <td><?= htmlspecialchars($materia['nombre']) ?></td>
                <td><?= htmlspecialchars($materia['programa_nombre']) ?></td>
                <td class="acciones">
                    <a href="index.php?modulo=materias&operacion=detalle&codigo=<?= urlencode($materia['codigo']) ?>">Ver</a>
                    <a href="index.php?modulo=materias&operacion=modificar&codigo=<?= urlencode($materia['codigo']) ?>">Editar</a>
                    <a href="index.php?modulo=materias&operacion=confirmar&codigo=<?= urlencode($materia['codigo']) ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$materias): ?>
            <tr><td colspan="4">No hay materias registradas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
