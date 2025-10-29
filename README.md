# Notas

Aplicación web desarrollada en PHP siguiendo los principios de POO y MVC para gestionar programas de formación, estudiantes, materias y calificaciones.

## Requisitos

- PHP 8.0 o superior con extensión `pdo_mysql` habilitada.
- Servidor web o el servidor embebido de PHP.
- Base de datos MySQL/MariaDB con la estructura definida en `database/schema.sql`.

## Configuración de la base de datos

Importe el script SQL suministrado en `database/schema.sql`. El archivo crea la base de datos `notas_app`, reinicia las tablas necesarias y carga datos de ejemplo, por lo que puede ejecutarlo directamente desde phpMyAdmin o la línea de comandos:

```bash
mysql -u root -p < database/schema.sql
```

La conexión se configura en `app/configuracion/parametros.php`. Ajuste el DSN, usuario y contraseña según su entorno.

## Puesta en marcha

1. Sitúe el directorio del proyecto en el servidor web apuntando al directorio `public/`.
2. Si utiliza el servidor embebido de PHP, ejecute:

   ```bash
   php -S localhost:8000 -t public/
   ```

3. Abra `http://localhost:8000` en el navegador.

## Funcionalidades principales

- **Programas**: creación, consulta, actualización y eliminación con validaciones que impiden cambios cuando hay estudiantes o materias asociadas.
- **Estudiantes**: gestión completa respetando las restricciones sobre códigos, dependencia de notas y visibilidad de promedios.
- **Materias**: administración por programa controlando dependencias con estudiantes y calificaciones.
- **Notas**: registro, actualización, eliminación individual y limpieza masiva por estudiante, garantizando que las materias pertenezcan al programa correspondiente y que las notas estén en el rango permitido (0-5, dos decimales).
- **Autenticación**: inicio de sesión mediante el código del estudiante como usuario y el correo electrónico como contraseña para acceder al panel.
- **Reportes**: vistas para estudiantes por programa, materias por programa, promedios por estudiante y por materia, así como detalle de notas por actividad.

## Estructura del proyecto

```
app/
├── configuracion/   # Autocarga, parámetros y mapa de rutas
├── controllers/     # Controladores de cada módulo
├── database/        # Conexión PDO reutilizable
├── models/          # Repositorios con reglas de negocio
├── soporte/         # Clases base como el enrutador y controlador común
└── views/           # Plantillas HTML organizadas por módulo
public/
├── assets/css/      # Recursos estáticos
└── index.php        # Front controller
```

## Notas adicionales

- Todas las operaciones de eliminación solicitan confirmación antes de ejecutarse.
- El diseño se basa únicamente en HTML y CSS para mantener la simplicidad del proyecto.
- Para adaptar la conexión a otra base de datos, modifique `app/configuracion/parametros.php`.
