<?php
/** @var array $nota */
?>
<h2>Editar calificación</h2>
<p>Materia: <strong><?= htmlspecialchars($nota['materia_nombre']) ?></strong></p>
<p>Estudiante: <strong><?= htmlspecialchars($nota['estudiante_nombre']) ?></strong></p>
<p>Actividad: <strong><?= htmlspecialchars($nota['actividad']) ?></strong></p>
<form method="post" class="formulario">
    <div class="campo">
        <label for="valor">Nota</label>
        <input type="number" step="0.01" min="0.01" max="5" id="valor" name="valor" value="<?= htmlspecialchars($nota['valor']) ?>" required>
    </div>
    <button type="submit">Actualizar</button>
    <a class="boton" href="index.php?modulo=calificaciones">Cancelar</a>
</form>
