
#  Backend - API RESTful para Gestión de Restaurantes

Descripción:
Este proyecto es el backend de una API RESTful para gestionar restaurantes, desarrollado con Laravel y MySQL. Proporciona operaciones CRUD para restaurantes, autenticación mediante API Key y está preparado para ser desplegado con Docker.

## Características Principales

- CRUD completo de restaurantes (nombre, dirección, teléfono).
- Autenticación vía API Key.
- Documentación automática de la API.
- Manejo de errores y validaciones.
- Containerización con Docker.
- Listo para despliegue plataformas Docker.


## Tecnologías

- Laravel (PHP Framework)
- MySQL 
- Docker & Docker Compose
- Swagger/OpenAPI para documentación-
- Composer para gestión de dependencias PHP



## Instalación

1. Para comenzar, clona este repositorio con el siguiente comando:

```bash
  git clone https://github.com/Palenzuelamora2/Wewelcom-Api.git
  cd Wewelcom-Api
  composer install
```
2. Antes de iniciar la aplicación, crea un archivo .env en la raíz del proyecto con las variables de entorno necesarias. Puedes basarte en el archivo .env.example que viene incluido en el repositorio.

3. Genera la clave de la aplicación:

```bash
  php artisan key:generate
```

4. Ejecuta las migraciones para crear las tablas necesarias:
```bash
  php artisan migrate
```

5. Para iniciar la aplicación en modo desarrollo, ejecuta:
```bash
  npm run dev
```
6. Ejecuta los seeders para poblar la base de datos con datos de ejemplo:
```bash
  php artisan db:seed
```
7. Inicia el servidor local:
```bash
  php artisan serve
```
La API estará disponible en http://localhost:8000 o el puerto configurado.
## Uso con Docker
El proyecto incluye Docker para facilitar el despliegue.
Levantar con Docker Compose

Ejecuta:
```bash
  docker-compose up -d
```

Importante: Ejecuta el comando docker-compose up -d desde el directorio raíz del proyecto, donde se encuentra el archivo docker-compose.yml. Esto es necesario para que Docker Compose pueda encontrar la configuración y levantar los contenedores correctamente.

Esto iniciará tanto el contenedor del backend como el de la base de datos.
La API estará disponible en http://localhost:8000 (o el puerto definido).
##  Despliegue y demo

El backend está desplegado y accesible públicamente en Railway:

URL base de la API:
https://wewelcom-api-production.up.railway.app/api/v1

Puedes usar esta URL para conectar tu frontend o probar la API directamente.




## Documentación de la Api

[Documentación Automática](https://wewelcom-api-production.up.railway.app/api/documentation#/)

