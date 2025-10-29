<section class="tarjeta">
    <h2>Bienvenido</h2>
    <p>Administra programas, materias, estudiantes y notas desde este panel.</p>
    <?php if (empty($_SESSION['usuario'])): ?>
        <p><a class="boton" href="?entidad=sesion&accion=iniciar">Acceder al sistema</a></p>
    <?php else: ?>
        <ul class="acciones">
            <li><a href="?entidad=programas" class="boton">Programas</a></li>
            <li><a href="?entidad=materias" class="boton">Materias</a></li>
            <li><a href="?entidad=estudiantes" class="boton">Estudiantes</a></li>
            <li><a href="?entidad=notas" class="boton">Notas</a></li>
        </ul>
    <?php endif; ?>
</section>
