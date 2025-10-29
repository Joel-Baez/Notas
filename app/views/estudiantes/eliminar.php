<section class="tarjeta advertencia">
    <h2>Confirmar eliminación</h2>
    <p>¿Eliminar al estudiante <strong><?= htmlspecialchars($estudiante['nombre']) ?></strong>?</p>
    <form method="post" action="?entidad=estudiantes&accion=eliminar&codigo=<?= urlencode($estudiante['codigo']) ?>" class="formulario">
        <button type="submit" class="boton peligro">Eliminar</button>
        <a class="boton secundario" href="?entidad=estudiantes">Cancelar</a>
    </form>
</section>
