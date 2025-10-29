<?php
ob_start();
?>
<section class="card">
    <h2>Bienvenido</h2>
    <p>Seleccione una opción del menú para gestionar los programas, materias, estudiantes o notas.</p>
</section>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/main.php';
