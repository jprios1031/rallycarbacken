
El backend de RallyCar fue desarrollado con Laravel 12 y funciona como la API que gestiona la comunicación entre el sistema y la base de datos.
Incluye autenticación segura con Laravel Sanctum, CRUDs protegidos, validaciones y control de acceso por roles.

 Tecnologías utilizadas

Laravel 12

MySQL

Laravel Sanctum

Form Requests

Controladores REST

Validación de datos

Funcionalidades principales

Autenticación: inicio de sesión y registro con token.

Gestión de usuarios.

Control de novedades: registro y seguimiento de reportes entre cliente y taller.

Gestión de ventas y gastos.

Roles: diferenciación entre administrador y cliente.

Seguridad

Tokens con Laravel Sanctum.

Validación robusta de formularios.

Pruebas manuales (end-to-end)

El sistema fue probado manualmente simulando el flujo completo de uso:

Login y obtención de token.

Acceso y creación de registros desde el frontend.

Validación de permisos por usuario.

Confirmación del correcto funcionamiento de la API desde el navegador.

Instalación
git clone https://github.com/jprios1031/rallycarbacken.git
cd rallycarbacken
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve  --port=8000

Conexión con el Frontend

El frontend (rallycarfronted) consume los endpoints de esta API mediante Laravel HTTP Client.
Asegúrate de mantener ambos servidores activos (API y Frontend) al momento de realizar pruebas
