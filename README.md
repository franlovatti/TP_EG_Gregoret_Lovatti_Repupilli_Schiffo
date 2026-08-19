# Shopping Rosario — Plataforma de Promociones

Trabajo Práctico de la materia Entornos Gráficos (UTN Facultad Regional Rosario, 2025).

Aplicación web que centraliza las promociones de los locales de un shopping ficticio en Rosario. Permite a los clientes descubrir y filtrar ofertas por categoría y día vigente, a los dueños de locales cargar y gestionar sus propias promociones y novedades, y a un administrador aprobar solicitudes y consultar reportes.

🚀 **Demo en producción:** <https://tpeggregoretlovattirepupillischiffo-production.up.railway.app/front/home.php>

## Roles de usuario

- **Cliente**: navega promociones y novedades, se registra y accede a beneficios según su categoría de cuenta (Inicial, Medium, Premium).
- **Dueño de local**: da de alta su local, crea y edita promociones y novedades, y solicita la aprobación de nuevas promociones.
- **Administrador**: aprueba o rechaza solicitudes de promociones, gestiona locales y usuarios, y accede a reportes.

## Funcionalidades principales

- Registro, login, recuperación de contraseña y verificación de cuenta por mail.
- Alta y gestión de locales del shopping.
- Alta, edición, vencimiento y reactivación de promociones, con filtro por categoría y por día de la semana.
- Publicación de novedades, con acceso diferenciado según la categoría del usuario.
- Flujo de solicitud/aprobación/rechazo de promociones entre dueños y administrador.
- Envío de mails (verificación de cuenta, notificación de promociones, contacto) mediante PHPMailer.
- Reportes de promociones para el administrador.

## Stack técnico

- **Backend**: PHP 8.2 (sin framework), consultas directas con `mysqli`.
- **Base de datos**: MySQL/MariaDB.
- **Frontend**: PHP + Bootstrap 5 (CDN) + CSS propio, sin build step.
- **Mailing**: [PHPMailer](https://github.com/PHPMailer/PHPMailer) vía SMTP (Gmail) o Brevo API.
- **Infraestructura**: Docker (imagen `php:8.2-cli` con extensiones `mysqli`/`pdo_mysql`), pensado para desplegar en Railway.

## Estructura del repositorio

- `front/`: vistas (home, locales, promociones, novedades, reportes, etc.), estilos e imágenes.
- `modals/`: modales reutilizables (login, sign up, edición de perfil/local/novedad, mensajes de estado).
- `consultas/`: lógica de acceso a datos y acciones sobre promociones, locales y novedades.
- `config/Load.php`: carga de variables de entorno desde `.env`.
- `PHPmailer/`: librería PHPMailer vendorizada.
- `conexion.php`, `sesion.php`, `header.php`, `footer.php`: conexión a la base de datos, manejo de sesión y layout compartido.
- Archivos en la raíz (`login.php`, `signUp.php`, `recuperar.php`, `cerrarSesion.php`, `enviarMailPromo.php`, `scriptPHPmailer.php`, etc.): endpoints de autenticación y envío de mails.

## Puesta en marcha

### 1) Requisitos

- PHP 8.2+ con extensión `mysqli` habilitada.
- Servidor MySQL/MariaDB.
- (Opcional) Docker, si se prefiere no instalar PHP localmente.

### 2) Configurar variables de entorno

Copiar `.env.example` a `.env` y completar al menos:

- `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_NAME`, `DB_PORT`
- Datos de envío de mail: `MAIL_USER`/`MAIL_PASSWORD` (SMTP Gmail) o `BREVO_API_KEY` (recomendado para uso académico, no requiere dominio propio)

### 3) Levantar la aplicación

**Con el servidor embebido de PHP:**

```
php -S localhost:8080
```

**Con Docker:**

```
docker build -t promociones-shopping .
docker run --env-file .env -p 8080:8080 promociones-shopping
```

La aplicación queda disponible en `http://localhost:8080`.

## Integrantes

Entornos Gráficos — UTN FRRo, 2025. Prof. Ing. Daniela Díaz; Prof. Ing. Julián Butti.

- Gregoret, Facundo Uriel — 52634
- Lovatti, Francisco — 52420
- Repupilli, Irina — 52417
- Schiffo, Bruno — 53256
