<section>
    <div class="encabezado">
        <h2>Estudiantes</h2>
        <a class="boton" href="?entidad=estudiantes&accion=crear">Nuevo</a>
    </div>
    <table class="tabla">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Programa</th>
                <th>Promedio</th>
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
                    <td><?= number_format($estudiante['promedio'], 2) ?></td>
                    <td class="acciones-tabla">
                        <a href="?entidad=estudiantes&accion=mostrar&codigo=<?= urlencode($estudiante['codigo']) ?>">Ver</a>
                        <a href="?entidad=estudiantes&accion=editar&codigo=<?= urlencode($estudiante['codigo']) ?>">Editar</a>
                        <a href="?entidad=estudiantes&accion=confirmarEliminar&codigo=<?= urlencode($estudiante['codigo']) ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
