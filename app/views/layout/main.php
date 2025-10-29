<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Notas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<header>
    <h1>Gestión de Notas</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="index.php?entity=programs">Programas</a></li>
            <li><a href="index.php?entity=subjects">Materias</a></li>
            <li><a href="index.php?entity=students">Estudiantes</a></li>
            <li><a href="index.php?entity=grades">Notas</a></li>
        </ul>
    </nav>
</header>
<main>
    <?php if (!empty($_GET['status'])): ?>
        <div class="alert success">
            Operación realizada correctamente (<?php echo htmlspecialchars($_GET['status']); ?>).
        </div>
    <?php elseif (!empty($_GET['error'])): ?>
        <div class="alert error">
            Ha ocurrido un error (<?php echo htmlspecialchars($_GET['error']); ?>).
        </div>
    <?php endif; ?>
    <?php echo $content; ?>
</main>
<footer>
    <p>Aplicación de ejemplo para la gestión de notas.</p>
</footer>
</body>
</html>
