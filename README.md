# Notas

Aplicación web desarrollada en PHP siguiendo los principios de POO y MVC para gestionar programas de formación, estudiantes, materias y sus notas.

## Requisitos

- PHP 8.0 o superior con extensión `pdo_mysql` habilitada.
- Servidor web o el servidor embebido de PHP.
- Base de datos MySQL/MariaDB con la estructura definida en `database/schema.sql` (ver sección siguiente).

## Configuración de la base de datos

Importe el script SQL suministrado en el enunciado dentro de una base de datos llamada `notas_app`. Puede hacerlo desde phpMyAdmin o usando la línea de comandos:

```bash
mysql -u root -p < schema.sql
```

El proyecto utiliza las siguientes variables de entorno opcionales para conectarse a la base de datos:

- `DB_HOST` (por defecto `127.0.0.1`)
- `DB_NAME` (por defecto `notas_app`)
- `DB_USER` (por defecto `root`)
- `DB_PASSWORD` (por defecto cadena vacía)

## Puesta en marcha

1. Sitúe el directorio del proyecto en el servidor web apuntando al directorio `public/`.
2. Si utiliza el servidor embebido de PHP, ejecute:

   ```bash
   php -S localhost:8000 -t public/
   ```

3. Abra `http://localhost:8000` en el navegador.

## Funcionalidades principales

- **Programas**: creación, consulta, actualización y eliminación con validaciones que impiden cambios cuando hay estudiantes o materias asociadas.
- **Estudiantes**: gestión completa respetando las restricciones sobre códigos y notas registradas.
- **Materias**: administración por programa de formación controlando dependencias con estudiantes y notas.
- **Notas**: registro, actualización, eliminación individual y eliminación masiva por estudiante, controlando que las materias pertenezcan al programa del estudiante y que las notas estén en el rango permitido (0-5, dos decimales).
- **Autenticación**: inicio de sesión mediante el código del estudiante como usuario y el correo electrónico como contraseña para acceder al panel.
- **Reportes**: vistas para estudiantes por programa, materias por programa, promedios por estudiante y por materia, así como detalle de notas por actividad.

## Estructura del proyecto

```
app/
├── controllers/   # Controladores MVC en español
├── database/      # Clase de conexión PDO (Conexion.php)
├── models/        # Modelos de dominio en español
└── views/         # Vistas agrupadas por entidad y layout principal
public/
├── assets/css/    # Recursos estáticos
└── index.php      # Front controller y enrutador
```

## Notas adicionales

- Todas las operaciones de eliminación solicitan confirmación antes de ejecutarse.
- El diseño se basa únicamente en HTML y CSS para mantener la simplicidad del proyecto.
- Para adaptar la conexión a otra base de datos, actualice las variables de entorno o modifique `app/database/Conexion.php`.
