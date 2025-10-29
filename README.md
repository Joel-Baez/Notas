# Sistema de registro de notas

Aplicación PHP mínima con una arquitectura organizada en capas (controladores, solicitudes, modelos y vistas) que permite registrar una nota dentro del rango 0.00 a 5.00.

## Requisitos

- PHP 8.1 o superior.

## Puesta en marcha

1. Instala las dependencias necesarias (no se requieren librerías externas).
2. Ejecuta un servidor embebido de PHP desde la raíz del proyecto:

   ```bash
   php -S localhost:8000 -t public
   ```

3. Abre tu navegador e ingresa a [http://localhost:8000](http://localhost:8000) para visualizar el formulario de registro.

## Estructura del proyecto

- `app/`
  - `Controllers/`: controladores que orquestan la lógica de cada caso de uso.
  - `Exceptions/`: excepciones propias de la aplicación.
  - `Http/Requests/`: objetos responsables de validar y sanear la entrada del usuario.
  - `Models/`: entidades de dominio puras.
- `public/`: punto de entrada HTTP (`index.php`).
- `resources/views/`: plantillas utilizadas para renderizar la interfaz.
- `bootstrap.php`: registro del autoloader PSR-4 simple utilizado por la aplicación.

## Pruebas manuales

1. Ingresa una nota válida, por ejemplo `5.00`. El sistema mostrará un mensaje de éxito y la nota formateada.
2. Intenta registrar una nota fuera del rango, por ejemplo `6`. Obtendrás un mensaje de error y el campo se repoblará con el valor ingresado.
3. Envíe el formulario vacío para verificar que se muestre el mensaje de validación correspondiente.
