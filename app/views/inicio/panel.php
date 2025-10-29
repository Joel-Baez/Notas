<?php
/** @var array $usuario */
?>
<h2>Panel principal</h2>
<p>Bienvenido(a) <?= htmlspecialchars($usuario['nombre']) ?>. Desde aquí puede administrar programas, estudiantes, materias y calificaciones.</p>
<div class="opciones">
    <a class="boton" href="index.php?modulo=programas">Gestionar programas</a>
    <a class="boton" href="index.php?modulo=estudiantes">Gestionar estudiantes</a>
    <a class="boton" href="index.php?modulo=materias">Gestionar materias</a>
    <a class="boton" href="index.php?modulo=calificaciones">Registrar notas</a>
    <a class="boton" href="index.php?modulo=reportes">Ver reportes</a>
</div>
