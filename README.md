# 🚀 PromptVault

Sistema de Gestión de Prompts para IA

Un sistema completo para crear, organizar, versionar y compartir prompts para modelos de inteligencia artificial.

---

## 📋 Tabla de Contenidos

- [Características](#características)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Uso](#uso)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Tecnologías](#tecnologías)
- [Colaboradores](#colaboradores)
- [Licencia](#licencia)

## ✨ Características

### 🔒 Autenticación y Seguridad

- Sistema de login y registro
- Validación robusta con Form Requests
- Políticas de autorización (solo dueño edita)
- Protección de rutas con middleware
- Mensajes de error en español

### 📝 Gestión de Prompts

- Crear, editar y eliminar prompts
- Organización por categorías y etiquetas
- Búsqueda avanzada (título, contenido, descripción)
- Filtros por categoría, etiqueta, IA destino
- Marcado de favoritos
- Contador de usos
- Prompts privados y públicos

### 🔄 Sistema de Versiones

- Control de versiones de cada prompt
- Comparación entre versiones
- Restauración de versiones anteriores
- Historial completo de cambios

### 🤝 Colaboración

- Compartir prompts con otros usuarios
- Prompts públicos y privados
- Historial de actividades
- Exportación de datos

### 🎨 Interfaz

- Dashboard con métricas clave
- Diseño moderno y responsive
- Tema claro/oscuro
- Multi-idioma (Español/Inglés)

### 🧪 Calidad de Código

- Tests automatizados
- Validaciones centralizadas
- Código documentado
- Políticas de autorización

## 🔧 Requisitos

### Software Necesario

- PHP: >= 8.2
- Composer: >= 2.0
- Node.js: >= 18.0
- NPM: >= 9.0
- MySQL: >= 8.0 o MariaDB >= 10.3

### Extensiones de PHP Requeridas

- php-mbstring
- php-xml
- php-curl
- php-zip
- php-mysql
- php-pdo

## 📦 Instalación

1. **Clonar el Repositorio**
    ```sh
    git clone https://github.com/Guillen-cloud/PromptVault-.git
    cd PromptVault-
    ```
2. **Instalar Dependencias**
    ```sh
    composer install
    npm install
    ```
3. **Configurar Variables de Entorno**
    ```sh
    cp .env.example .env
    php artisan key:generate
    ```
4. **Configurar Base de Datos**
   Edita el archivo `.env` con tus credenciales:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=promptvault
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
    ```
5. **Crear Base de Datos**
    - Opción 1: MySQL Command Line
        ```sh
        mysql -u root -p
        CREATE DATABASE promptvault CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
        exit;
        ```
    - Opción 2: Usar script incluido (Windows)
        ```sh
        setup_database.bat
        ```
6. **Ejecutar Migraciones y Seeders**
    ```sh
    php artisan migrate
    php artisan db:seed
    ```
7. **Compilar Assets**
    - Desarrollo
        ```sh
        npm run dev
        ```
    - Producción
        ```sh
        npm run build
        ```

8. **Iniciar Servidor de Desarrollo**

    ```sh
    php artisan serve
    ```

    Esto levantará el servidor de Laravel en http://localhost:8000

    Si también quieres levantar el entorno de frontend (Vite):

    ```sh
    npm run dev
    ```

    Esto habilita recarga automática y assets modernos para desarrollo.

## ⚙️ Configuración

### Usuarios de Prueba

Después de ejecutar `php artisan db:seed`, puedes usar:

- **Usuario Demo:**
    - Email: demo@promptvault.com
    - Password: password
- **Usuario Admin:**
    - Email: admin@promptvault.com
    - Password: password

### Configuración de Idioma

El sistema soporta múltiples idiomas:

- Español (por defecto)
- Inglés
- Portugués (Brasil)
- Francés

Cambiar en: Dashboard → Selector de idioma

## 🎯 Uso

### Crear un Prompt

1. Ve a Prompts en el menú lateral
2. Click en Nuevo Prompt
3. Llena el formulario:
    - Título
    - Contenido
    - Descripción
    - Categoría
    - IA Destino (ChatGPT, Claude, etc.)
    - Etiquetas
4. Click en Guardar

### Buscar Prompts

- Usa la barra de búsqueda en la parte superior para buscar por:
    - Título
    - Contenido
    - Descripción
- O usa los filtros avanzados:
    - Por categoría
    - Por etiqueta
    - Por IA destino
    - Solo favoritos

### Sistema de Versiones

- Abre un prompt
- Click en Versiones
- Ver historial completo
- Comparar versiones
- Restaurar versión anterior

## 📁 Estructura del Proyecto
<img width="293" height="591" alt="image" src="https://github.com/user-attachments/assets/c4861f36-0995-403b-b077-6be594732f78" />
<img width="279" height="574" alt="image" src="https://github.com/user-attachments/assets/fc5b517e-b078-49c8-8d74-bfe446c95f1b" />



## 🛠️ Tecnologías

### Backend

- Laravel 12 - Framework PHP
- MySQL 8 - Base de datos
- PHP 8.2 - Lenguaje

### Frontend

- Blade - Motor de plantillas
- Vite - Build tool
- CSS3 - Estilos personalizados
- JavaScript (Vanilla) - Interactividad

### Herramientas

- Composer - Gestor de dependencias PHP
- NPM - Gestor de dependencias JS
- Git - Control de versiones

## 👥 Colaboradores

Este proyecto fue desarrollado por:

- Guillen-cloud - Desarrollador Principal

¿Quieres colaborar?

1. Fork el proyecto
2. Crea una rama (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -m 'Añadir nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

Ver `GUIA_COLABORACION.md` para más detalles.

## 📝 Comandos Útiles

```sh
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Resetear base de datos
php artisan migrate:fresh --seed

# Ejecutar tests
php artisan test

# Ver rutas
php artisan route:list

# Compilar assets en modo watch
yarn dev
npm run dev
```

## 🐛 Solución de Problemas

- **Error: "Class not found"**
    - `composer dump-autoload`
- **Error en migraciones**
    - `php artisan migrate:fresh --seed`
- **Assets no se cargan**
    - `npm run build`
    - `php artisan storage:link`
- **Error 500 en producción**
    - `php artisan config:cache`
    - `php artisan route:cache`
    - `php artisan view:cache`

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver archivo LICENSE para más detalles.

## 📞 Contacto

- Repositorio: https://github.com/Guillen-cloud/PromptVault-
- Issues: https://github.com/Guillen-cloud/PromptVault-/issues

---

Desarrollado con ❤️ para la gestión eficiente de prompts de IA
