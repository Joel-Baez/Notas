<?php

declare(strict_types=1);

/** @var string $vista */
/** @var array|null $resultado */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de notas</title>
    <style>
        :root {
            color-scheme: light dark;
            font-family: "Segoe UI", Roboto, sans-serif;
        }

        body {
            margin: 0;
            background-color: #f5f5f5;
        }

        main {
            max-width: 480px;
            margin: 4rem auto;
            background-color: #ffffff;
            padding: 2rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
            font-size: 1.8rem;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: 600;
        }

        input[type="number"] {
            font-size: 1.1rem;
            padding: 0.75rem 1rem;
            border: 1px solid #d0d5dd;
            border-radius: 8px;
        }

        button {
            padding: 0.85rem 1rem;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            background-color: #2f80ed;
            color: #ffffff;
            font-weight: 600;
        }

        .alerta {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alerta--exito {
            background-color: #e8f8f0;
            border: 1px solid #3ba776;
            color: #236947;
        }

        .alerta--error {
            background-color: #fdeaea;
            border: 1px solid #e03131;
            color: #7f1d1d;
        }

        .campo__error {
            color: #e03131;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
<main>
    <?php require $vista; ?>
</main>
</body>
</html>
