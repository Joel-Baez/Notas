<section class="tarjeta advertencia">
    <h2>Confirmar eliminación</h2>
    <p>¿Eliminar la materia <strong><?= htmlspecialchars($materia['nombre']) ?></strong>?</p>
    <form method="post" action="?entidad=materias&accion=eliminar&codigo=<?= urlencode($materia['codigo']) ?>" class="formulario">
        <button type="submit" class="boton peligro">Eliminar</button>
        <a class="boton secundario" href="?entidad=materias">Cancelar</a>
    </form>
</section>
