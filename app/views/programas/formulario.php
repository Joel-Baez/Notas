<section class="tarjeta">
    <h2><?= $accion === 'guardar' ? 'Registrar programa' : 'Actualizar programa' ?></h2>
    <form method="post" action="?entidad=programas&accion=<?= $accion ?><?= $accion === 'actualizar' ? '&codigo=' . urlencode($programa['codigo']) : '' ?>" class="formulario">
        <div class="campo">
            <label for="codigo">Código</label>
            <input type="text" id="codigo" name="codigo" maxlength="4" value="<?= htmlspecialchars($programa['codigo']) ?>" <?= $accion === 'actualizar' ? 'readonly' : 'required' ?>>
        </div>
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($programa['nombre']) ?>">
        </div>
        <button type="submit" class="boton">Guardar</button>
        <a class="boton secundario" href="?entidad=programas">Cancelar</a>
    </form>
</section>
