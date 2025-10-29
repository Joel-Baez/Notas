<section>
    <div class="encabezado">
        <h2>Materias</h2>
        <a class="boton" href="?entidad=materias&accion=crear">Nueva</a>
    </div>
    <table class="tabla">
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
                    <td class="acciones-tabla">
                        <a href="?entidad=materias&accion=mostrar&codigo=<?= urlencode($materia['codigo']) ?>">Ver</a>
                        <a href="?entidad=materias&accion=editar&codigo=<?= urlencode($materia['codigo']) ?>">Editar</a>
                        <a href="?entidad=materias&accion=confirmarEliminar&codigo=<?= urlencode($materia['codigo']) ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
