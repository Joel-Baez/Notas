<?php
/** @var array $programa */
?>
<h2>Eliminar programa</h2>
<p>¿Desea eliminar el programa <strong><?= htmlspecialchars($programa['nombre']) ?></strong>?</p>
<form method="post" action="index.php?modulo=programas&operacion=borrar">
    <input type="hidden" name="codigo" value="<?= htmlspecialchars($programa['codigo']) ?>">
    <button type="submit" class="peligro">Sí, eliminar</button>
    <a class="boton" href="index.php?modulo=programas">Cancelar</a>
</form>
