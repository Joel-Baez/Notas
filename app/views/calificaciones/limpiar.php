<?php
/** @var array $estudiante */
?>
<h2>Eliminar notas del estudiante</h2>
<p>Se eliminarán todas las calificaciones registradas para <strong><?= htmlspecialchars($estudiante['nombre']) ?></strong>.</p>
<form method="post" action="index.php?modulo=calificaciones&operacion=limpiar">
    <input type="hidden" name="estudiante" value="<?= htmlspecialchars($estudiante['codigo']) ?>">
    <button type="submit" class="peligro">Eliminar todas</button>
    <a class="boton" href="index.php?modulo=calificaciones">Cancelar</a>
</form>
