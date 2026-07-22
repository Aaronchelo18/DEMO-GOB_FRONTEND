# Estado del demo SISCAT

Fecha de trabajo: 2026-07-20

## Ruta principal

Frontend:

```text
C:\DEMO-GOB_FRONTEND
```

Backend:

```text
C:\DEMO-GOB_BACKEND
```

El trabajo realizado por ahora esta en el frontend.

## Como levantar con Docker

Arranque recomendado:

```powershell
cd /d C:\demo-gob_frontend
docker compose up -d --build
```

Tambien puedes ejecutar:

```powershell
C:\demo-gob_frontend\INICIAR_DOCKER.bat
```

URLs locales:

```text
Frontend: http://localhost:8080
Backend:  http://localhost:8081/api/health
```

El frontend usa `API_BASE_URL=http://demo-gob-backend/api` dentro de Docker para comunicarse con el backend por red interna.

## Como levantar sin Docker

PHP 8.3 quedo instalado por winget en:

```text
C:\Users\Jozef\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe
```

Arranque recomendado:

```powershell
cd /d C:\demo-gob_frontend
.\INICIAR_FRONTEND.bat
```

URL local:

```text
http://127.0.0.1:8080/index.php
```

## Cambios actuales

- Se recreo la pantalla inicial tipo SISCAT.
- El sidebar principal se comporta como el original: colapsado y se expande con hover.
- El menu principal contiene solo:
  - Categorizacion
  - Reportes Excel
  - Criterios
  - Reporte Cumplimiento
- Se corrigio el icono del menu para que sea unico y no parpadee.
- Se corrigio el texto del hover para que no aparezca/desaparezca con duplicado visual.
- La tarjeta `INFRAESTRUCTURA` entra directo a `consulta-externa.php`; ya no existe pantalla intermedia `infraestructura.php`.
- La pantalla `consulta-externa.php` conserva el flujo de tres columnas: UPSS izquierda, items centro, formulario derecha.
- Debajo de `CONSULTA EXTERNA` se agrego jerarquia padre-hijo:
  - Medicina
  - Enfermeria
  - Obstetricia
  - Componentes como Infraestructura, Equipamiento y RRHH
  - Items concretos como lavamanos, tensiometro, camilla, etc.

## Archivos importantes

```text
C:\DEMO-GOB_FRONTEND\index.php
C:\DEMO-GOB_FRONTEND\consulta-externa.php
C:\DEMO-GOB_FRONTEND\includes\data.php
C:\DEMO-GOB_FRONTEND\includes\layout.php
C:\DEMO-GOB_FRONTEND\includes\icons.php
C:\DEMO-GOB_FRONTEND\assets\css\app.css
C:\DEMO-GOB_FRONTEND\assets\js\app.js
C:\DEMO-GOB_FRONTEND\INICIAR_FRONTEND.bat
```

## Validacion hecha

- PHP sin errores de sintaxis.
- JavaScript sin errores de sintaxis.
- `index.php` responde `200`.
- `consulta-externa.php` responde `200`.
- Se hicieron capturas locales con Edge headless para revisar el diseño.
- Docker Compose levanta frontend y backend juntos.
- El frontend consume `GET /api/session`, `GET /api/catalog` y guarda con `POST /api/captures` cuando el backend esta disponible.

## Siguiente pendiente

- Seguir afinando visualmente el sidebar si se requiere.
- Conectar mas interacciones visuales del arbol a endpoints especificos si el flujo crece.
