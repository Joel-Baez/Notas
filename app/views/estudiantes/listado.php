<?php
/** @var array $estudiantes */
?>
<div class="encabezado">
    <h2>Estudiantes registrados</h2>
    <a class="boton" href="index.php?modulo=estudiantes&operacion=registrar">Nuevo estudiante</a>
</div>
<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Programa</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($estudiantes as $estudiante): ?>
            <tr>
                <td><?= htmlspecialchars($estudiante['codigo']) ?></td>
                <td><?= htmlspecialchars($estudiante['nombre']) ?></td>
                <td><?= htmlspecialchars($estudiante['email']) ?></td>
                <td><?= htmlspecialchars($estudiante['programa_nombre']) ?></td>
                <td class="acciones">
                    <a href="index.php?modulo=estudiantes&operacion=detalle&codigo=<?= urlencode($estudiante['codigo']) ?>">Ver</a>
                    <a href="index.php?modulo=estudiantes&operacion=modificar&codigo=<?= urlencode($estudiante['codigo']) ?>">Editar</a>
                    <a href="index.php?modulo=estudiantes&operacion=confirmar&codigo=<?= urlencode($estudiante['codigo']) ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$estudiantes): ?>
            <tr><td colspan="5">No hay estudiantes registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
