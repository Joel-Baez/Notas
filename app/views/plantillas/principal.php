<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <header class="barra-superior">
        <h1>Gestor académico</h1>
        <nav aria-label="Menú principal">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <?php if (!empty($_SESSION['usuario'])): ?>
                    <li><a href="?entidad=programas">Programas</a></li>
                    <li><a href="?entidad=materias">Materias</a></li>
                    <li><a href="?entidad=estudiantes">Estudiantes</a></li>
                    <li><a href="?entidad=notas">Notas</a></li>
                    <li><a href="?entidad=sesion&accion=cerrar">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="?entidad=sesion&accion=iniciar">Iniciar sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php if (!empty($_SESSION['usuario'])): ?>
            <p class="usuario">Sesión: <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></p>
        <?php endif; ?>
    </header>

    <main class="contenido">
        <?php if (!empty($mensaje)): ?>
            <div class="aviso aviso-<?= htmlspecialchars($mensaje['tipo']) ?>" role="alert">
                <?= htmlspecialchars($mensaje['texto']) ?>
            </div>
        <?php endif; ?>

        <?= $contenido ?>
    </main>

    <footer class="pie">
        <small>Aplicación de notas &copy; <?= date('Y') ?></small>
    </footer>
</body>
</html>
