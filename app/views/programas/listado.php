<?php
/** @var array $programas */
?>
<div class="encabezado">
    <h2>Programas de formación</h2>
    <a class="boton" href="index.php?modulo=programas&operacion=registrar">Nuevo programa</a>
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
        <?php foreach ($programas as $programa): ?>
            <tr>
                <td><?= htmlspecialchars($programa['codigo']) ?></td>
                <td><?= htmlspecialchars($programa['nombre']) ?></td>
                <td class="acciones">
                    <a href="index.php?modulo=programas&operacion=modificar&codigo=<?= urlencode($programa['codigo']) ?>">Editar</a>
                    <a href="index.php?modulo=programas&operacion=confirmar&codigo=<?= urlencode($programa['codigo']) ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$programas): ?>
            <tr><td colspan="3">No hay programas registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
