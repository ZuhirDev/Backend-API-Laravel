# 🧠 Backend con Autenticación — Laravel

Este proyecto es una base modular para backend desarrollada con **Laravel** y **MySQL**, diseñada para ofrecer una arquitectura robusta, escalable y reutilizable enfocada en la **gestión de autenticación de usuarios** y **eventos en tiempo real con WebSockets** mediante **Laravel Reverb**.

---

## 🔐 Funcionalidades Incluidas

- ✅ Registro y login con JWT (JSON Web Tokens)  
- 🔒 Middlewares personalizados para proteger rutas y acciones sensibles  
- ✉️ Verificación de email mediante enlaces firmados  
- 🔁 Recuperación de contraseña vía email  
- 🔐 Cambio de contraseña autenticado  
- 🔑 Autenticación en dos factores (2FA) con Google Authenticator  
- 🌍 Multilenguaje (soporte para cabeceras `Accept-Language`)  
- 📡 WebSockets en tiempo real con Laravel Reverb 


## 🚀 Ideal para

- Nuevos proyectos en Laravel que requieran un sistema de autenticación completo y listo para producción  
- Desarrollo de APIs RESTful modernas, seguras y escalables  
- Aplicaciones que necesiten comunicación en tiempo real (notificaciones, eventos, chat, etc.)

---


## 🐳 Dockerización

El proyecto está completamente **dockerizado**, lo que permite levantar todo el entorno con un solo comando, asegurando la misma configuración en todos los entornos.

El archivo `docker-compose.yml` incluye los siguientes contenedores:

- 🟢 **Backend Laravel**: servidor PHP con Laravel + JWT  
- 🔄 **Laravel Reverb**: WebSocket server para broadcasting en tiempo real  
- 🟣 **MySQL**: motor de base de datos relacional  
- 🟠 **phpMyAdmin**: panel de administración visual de base de datos  
- 🔵 **Nginx**: proxy inverso y servidor web para producción  

> 📄 Para una guía completa de instalación y despliegue, consulta [`Deploy.md`](./Deploy.md), que explica cómo clonar, configurar el entorno, levantar los contenedores y generar claves necesarias.

---


## 📬 Uso con Postman

Para facilitar las pruebas de la API, se incluye el archivo [`Postman.json`](./Postman.json), una colección preconfigurada para **Postman**.

Puedes importarla y comenzar a probar todos los endpoints de forma rápida, con ejemplos listos para usar y configuraciones ya preparadas.