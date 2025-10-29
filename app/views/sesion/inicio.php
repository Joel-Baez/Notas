<section class="tarjeta">
    <h2>Inicia sesión</h2>
    <form method="post" action="?entidad=sesion&accion=acceder" class="formulario">
        <div class="campo">
            <label for="codigo">Código del estudiante</label>
            <input type="text" name="codigo" id="codigo" required maxlength="5">
        </div>
        <div class="campo">
            <label for="clave">Correo electrónico</label>
            <input type="email" name="clave" id="clave" required>
        </div>
        <button type="submit" class="boton">Ingresar</button>
    </form>
</section>
