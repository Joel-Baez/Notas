<section class="tarjeta advertencia">
    <h2>Confirmar eliminación</h2>
    <p>¿Deseas eliminar el programa <strong><?= htmlspecialchars($programa['nombre']) ?></strong>?</p>
    <form method="post" action="?entidad=programas&accion=eliminar&codigo=<?= urlencode($programa['codigo']) ?>" class="formulario">
        <button type="submit" class="boton peligro">Eliminar</button>
        <a class="boton secundario" href="?entidad=programas">Cancelar</a>
    </form>
</section>
