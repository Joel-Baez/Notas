<section>
    <div class="encabezado">
        <h2>Programas</h2>
        <a class="boton" href="?entidad=programas&accion=crear">Nuevo</a>
    </div>
    <table class="tabla">
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
                    <td class="acciones-tabla">
                        <a href="?entidad=programas&accion=mostrar&codigo=<?= urlencode($programa['codigo']) ?>">Ver</a>
                        <a href="?entidad=programas&accion=editar&codigo=<?= urlencode($programa['codigo']) ?>">Editar</a>
                        <a href="?entidad=programas&accion=confirmarEliminar&codigo=<?= urlencode($programa['codigo']) ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
