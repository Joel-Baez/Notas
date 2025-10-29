<section class="tarjeta advertencia">
    <h2>Eliminar todas las notas</h2>
    <p>Esta acción quitará todas las notas del estudiante con código <strong><?= htmlspecialchars($estudiante) ?></strong>.</p>
    <form method="post" action="?entidad=notas&accion=eliminarTodas&estudiante=<?= urlencode($estudiante) ?>" class="formulario">
        <button type="submit" class="boton peligro">Eliminar</button>
        <a class="boton secundario" href="?entidad=estudiantes&accion=mostrar&codigo=<?= urlencode($estudiante) ?>">Cancelar</a>
    </form>
</section>
