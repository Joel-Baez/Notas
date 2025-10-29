<section class="tarjeta advertencia">
    <h2>Confirmar eliminación</h2>
    <p>¿Eliminar la nota de la actividad <strong><?= htmlspecialchars($nota['actividad']) ?></strong>?</p>
    <form method="post" action="?entidad=notas&accion=eliminar&materia=<?= urlencode($nota['materia']) ?>&estudiante=<?= urlencode($nota['estudiante']) ?>&actividad=<?= urlencode($nota['actividad']) ?>" class="formulario">
        <button type="submit" class="boton peligro">Eliminar</button>
        <a class="boton secundario" href="?entidad=notas">Cancelar</a>
    </form>
</section>
