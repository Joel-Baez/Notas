<?php
/** @var array $estudiante */
?>
<h2>Eliminar estudiante</h2>
<p>¿Está seguro de eliminar al estudiante <strong><?= htmlspecialchars($estudiante['nombre']) ?></strong>?</p>
<form method="post" action="index.php?modulo=estudiantes&operacion=borrar">
    <input type="hidden" name="codigo" value="<?= htmlspecialchars($estudiante['codigo']) ?>">
    <button type="submit" class="peligro">Sí, eliminar</button>
    <a class="boton" href="index.php?modulo=estudiantes">Cancelar</a>
</form>
