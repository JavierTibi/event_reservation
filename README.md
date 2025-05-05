# Event Reservation API

Este proyecto es una API RESTful desarrollada en Laravel 12 que permite a los usuarios registrarse, iniciar sesión, crear eventos, reservar entradas, dejar reseñas y ver reseñas de eventos.

### Requisitos
- PHP >= 8.1
- Composer
- Docker 
- Laravel 12


### Endpoints principales

- POST /api/register – Registro de usuario

- POST /api/login – Autenticación y generación de token

- GET /api/events – Listado de eventos

- POST /api/events – Crear nuevo evento (requiere autenticación)

- POST /api/events/{event}/reserve – Reservar ticket para un evento

- POST /api/events/{event}/review – Dejar reseña (solo si se asistió al evento)

- GET /api/events/{event}/reviews – Ver reseñas de un evento

## Autenticación
La autenticación se realiza con tokens utilizando Laravel Sanctum. Asegurate de incluir el header:

`Authorization: Bearer {token}`

en todas las rutas protegidas.

## Tests
Este proyecto incluye tests de integración y unitarios. Para ejecutarlos:

Configurar la base de datos SQLite en .env.testing:

DB_CONNECTION=sqlite
DB_DATABASE=:memory:

Ejecutar los tests:

```bash 
php artisan test
```


###  Colección de Postman
Hay una colección Postman incluida en el archivo Event API.postman_collection.json. Podés importarla directamente en Postman para probar los endpoints.