# Sistema de Registro de Alumnos
Este proyecto es una aplicación web integral desarrollada para la gestión académica, implementando prácticas modernas de desarrollo, seguridad y arquitectura modular.

# Características Principales
- Arquitectura Modular: Organización de archivos separada por responsabilidades (actions, config, pages, static) para facilitar el mantenimiento.
- Gestión de Usuarios: Sistema de autenticación con roles diferenciados para Administradores y Estudiantes.
- Seguridad: Cifrado de contraseñas mediante algoritmos de hash (BCrypt) para proteger la integridad de los datos de los usuarios.
- Borrado Lógico (Soft Delete): Implementación de eliminación lógica para prevenir la pérdida accidental de datos y mantener registros históricos.
- Interfaz Responsiva: Diseño adaptativo utilizando Bootstrap y CSS personalizado.

# Tecnologías Utilizadas
- Backend: PHP 8.x
- Base de Datos: MySQL / MariaDB
- Frontend: HTML5, CSS3, JavaScript, Bootstrap
- Control de Versiones: Git & GitHub

# Estructura del Proyecto

├── actions/     # Lógica de procesamiento (Insert, Update, Delete)
├── config/      # Conexión a BD y funciones globales
├── img/         # Almacenamiento de fotos de alumnos (ignorado en git)
├── pages/       # Vistas divididas por roles (Admin/Student)
├── static/      # Archivos CSS y JS
└── index.php    # Punto de entrada principal

# Instalación
Clona el repositorio.

Importa el archivo database/registro_db.sql en tu servidor local (XAMPP/MySQL).

Renombra el archivo config/db_connect.php.example a db_connect.php y configura tus credenciales locales.

¡Listo! Accede desde localhost/registro-alumnos.