# CHANGELOG.md

## Historial de Cambios - PromptVault

Este archivo documenta los cambios, mejoras y correcciones realizados en el proyecto.

---

### 2026-01-28

- Creación y adaptación del README.md con instrucciones completas de instalación, uso y colaboración.
- Creación y subida de la guía de colaboración (GUIA_COLABORACION.md) adaptada al repositorio y estructura real.
- Documentación de cómo levantar el servidor de desarrollo (`php artisan serve`) y el entorno de frontend (`npm run dev`).
- Cambio de la base de datos utilizada en el entorno local:
    - Variable `DB_DATABASE` en `.env` actualizada de `promptvault` a `promptvault1`.
    - Esto permite trabajar con una base de datos diferente para pruebas o desarrollo sin afectar la base de datos principal.

---

Cada vez que se realice un cambio relevante, por favor añade una entrada aquí con la fecha, descripción breve y archivos afectados.

**Ejemplo:**

```
### 2026-02-01
- Añadida funcionalidad de favoritos en prompts (app/Models/Prompt.php, app/Http/Controllers/PromptController.php)
- Mejorada validación de registro de usuarios (app/Http/Requests/RegisterRequest.php)
```
