# 🛠️ Configuración del Proyecto en Local con Docker

Esta guía explica cómo desplegar y probar el proyecto usando Docker. Docker nos permite empaquetar toda la aplicación con sus dependencias en contenedores, facilitando la instalación y evitando conflictos entre sistemas.

## 1. Clonar el repositorio

- Primero, se debe copiar el código fuente del proyecto al equipo local usando Git. Esto descarga todo el código y permite trabajar dentro del directorio del proyecto.

    ```bash
    git clone https://github.com/ZuhirDev/Backend-API-Laravel.git
    cd Backend-API-Laravel
    ```

## 2. Configurar las variables de entorno

El archivo `.env` contiene la configuración necesaria para que la aplicación funcione correctamente

- Se debe crear el archivo `.env` copiándolo desde un archivo de ejemplo.

    ```bash
    cp .env.example .env
    ```

## 3. Levantar los contenedores Docker

Se levantan los contenedores que contienen la base de datos, servidor web, PHP y otros servicios necesarios.

- Se ejecuta Docker Compose para construir y correr los contenedores en segundo plano.

    ```bash
    docker compose up -d --build
    ```

Esto pone en marcha toda la infraestructura del proyecto.


## 4. Configurar Laravel dentro del contenedor

Para que Laravel funcione correctamente, es necesario instalar dependencias y configurar la aplicación.

- Se debe acceder al contenedor donde está Laravel.

    ```bash
    docker exec -it laravel bash
    ```
- Dentro del contenedor, se instalan las dependencias PHP necesarias.
    
    ```bash
    composer install
    ```
- Luego, se generan las claves necesarias para la aplicación y autenticación.
    
    ```bash
    php artisan key:generate
    php artisan jwt:secret
    ```
- Finalmente, se ejecutan las migraciones para crear las tablas en la base de datos y se insertan datos iniciales.

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

- >Si hay problemas con las migraciones o el sembrado de datos, se puede reiniciar la base de datos con una opción que elimina todo y vuelve a crear desde cero.

    ```bash
    php artisan migrate:fresh --seed
    ```

## 5. Reiniciar los contenedores

- Se debe reiniciar los contenedores para que los demás servicios funcionen automáticamente sin tener que hacer nada porque la configuración del backend ya está lista.

    ```bash
    docker compose down
    ```

    ```bash
    docker compose up -d
    ```
## 6. Acceder a la aplicación

Una vez que los contenedores están levantados correctamente, puedes acceder a los siguientes servicios desde tu navegador:

### 🔌 API Laravel

- URL base: [http://localhost:85/api](http://localhost:85/api)  
- Puedes probar los endpoints con la colección Postman incluida (`Postman.json`).

### 🗄️ phpMyAdmin (interfaz para MySQL)

- URL: [http://localhost:8080/](http://localhost:8080/)  
- **Usuario**: `root`  
- **Contraseña**: `root`


## Nota sobre la configuración del correo electrónico

Para poder probar funcionalidades que requieren envío de correos, como la verificación de email o la recuperación de contraseña, es necesario configurar correctamente las variables relacionadas al correo en el archivo `.env`. 
```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=your_mail_host
MAIL_PORT=your_mail_port
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
Puedes usar Mailtrap, un servicio gratuito que facilita pruebas de correo capturando los emails sin enviarlos realmente. Solo crea una cuenta, usa sus datos SMTP y configúralos en las variables para que las funciones de correo funcionen en desarrollo.