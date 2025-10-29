<?php
/** @var array $materia */
?>
<h2>Eliminar materia</h2>
<p>¿Desea eliminar la materia <strong><?= htmlspecialchars($materia['nombre']) ?></strong>?</p>
<form method="post" action="index.php?modulo=materias&operacion=borrar">
    <input type="hidden" name="codigo" value="<?= htmlspecialchars($materia['codigo']) ?>">
    <button type="submit" class="peligro">Sí, eliminar</button>
    <a class="boton" href="index.php?modulo=materias">Cancelar</a>
</form>
