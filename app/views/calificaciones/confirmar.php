<?php
/** @var array $nota */
?>
<h2>Eliminar calificación</h2>
<p>Confirme que desea eliminar la calificación de <strong><?= htmlspecialchars($nota['actividad']) ?></strong> en <strong><?= htmlspecialchars($nota['materia_nombre']) ?></strong> para <strong><?= htmlspecialchars($nota['estudiante_nombre']) ?></strong>.</p>
<form method="post" action="index.php?modulo=calificaciones&operacion=borrar">
    <input type="hidden" name="id" value="<?= htmlspecialchars((string) $nota['id']) ?>">
    <button type="submit" class="peligro">Sí, eliminar</button>
    <a class="boton" href="index.php?modulo=calificaciones">Cancelar</a>
</form>
