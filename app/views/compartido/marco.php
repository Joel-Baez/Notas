<?php
/** @var array $datos */
/** @var string $archivoVista */

$usuario = $_SESSION['credencial'] ?? null;
$avisos = $_SESSION['avisos'] ?? [];
unset($_SESSION['avisos']);

?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de notas</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <header class="cabecera">
        <div class="contenedor">
            <h1>Gestión académica</h1>
            <?php if ($usuario): ?>
                <p class="bienvenida">Sesión: <strong><?= htmlspecialchars($usuario['nombre']) ?></strong></p>
            <?php endif; ?>
        </div>
        <nav class="menu">
            <a href="index.php?modulo=inicio">Inicio</a>
            <a href="index.php?modulo=programas">Programas</a>
            <a href="index.php?modulo=estudiantes">Estudiantes</a>
            <a href="index.php?modulo=materias">Materias</a>
            <a href="index.php?modulo=calificaciones">Notas</a>
            <a href="index.php?modulo=reportes">Reportes</a>
            <?php if ($usuario): ?>
                <a href="index.php?modulo=acceso&operacion=salir">Cerrar sesión</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="contenido">
        <?php foreach ($avisos as $aviso): ?>
            <div class="alerta alerta-<?= htmlspecialchars($aviso['tipo']) ?>"><?= htmlspecialchars($aviso['texto']) ?></div>
        <?php endforeach; ?>
        <section class="panel">
            <?php
                extract($datos, EXTR_SKIP);
                require $archivoVista;
            ?>
        </section>
    </main>
</body>
</html>
