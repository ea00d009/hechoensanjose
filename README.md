# Hecho en San José &bull; Plataforma Productiva y Cartográfica Oficial

Plataforma web integral, interactiva y de soberanía tecnológica diseñada para articular el sector productivo local con el ecosistema turístico oficial de la ciudad de **San José, Entre Ríos, Argentina** ([sanjose.tur.ar/hechoensanjose](https://sanjose.tur.ar/hechoensanjose/)).

Desarrollada bajo estándares modernos de desarrollo web, accesibilidad y seguridad para fomento del consumo de cercanía, visibilidad del productor regional y tratamiento institucional ante el **Honorable Concejo Deliberante de la Ciudad de San José**.

---

## 🎯 Objetivos Estratégicos del Programa

1. **Articulación Turismo + Producción Autóctona:** Visibilizar a micro y medianos productores (agroecología, nuez pecán, licores artesanales centenarios, apicultura nativa, queserías de colonia y cuchillería entrerriana) para que turistas y vecinos accedan a productos con sello de identidad de origen.
2. **Georreferenciación Precisa:** Ubicación exacta de cada establecimiento en el ejido urbano y colonias aledañas con coordenadas satelitales comprobadas.
3. **Comercialización Directa sin Intermediarios:** Enlace instantáneo a WhatsApp con mensaje personalizado y botón de ruta guiada paso a paso mediante GPS (Google Maps).
4. **URLs Amigables y Códigos QR Oficiales:** Enlaces directos y códigos QR limpios por productor (ej. `/mapa/licores-bard`) para packaging, etiquetas y folletería turística.
5. **Soberanía y Ahorro Tecnológico:** Construido con tecnologías de código abierto (**Leaflet.js**, **OpenStreetMap**, **PHP 8** y **MySQL**), sin costos recurrentes de licencias ni consumo de cuotas de APIs privativas.
6. **Elevación y Respaldo Institucional:** Módulo integrado para la generación formal del expediente e informe membretado para tratamiento legislativo en el Honorable Concejo Deliberante.

---

## 🚀 Mejoras Implementadas (UI/UX, Funcionalidad y Seguridad)

### 1. URLs Amigables y Semánticas (`/mapa/{slug}`)
- **Enrutamiento Dinámico con Parámetros:** El enrutador (`core/Router.php`) ahora soporta patrones dinámicos con parámetros `{param}`, permitiendo rutas limpias como `/mapa/licores-bard` o `/mapa/establecimiento-los-nogales`.
- **Generación Automática de Slugs:** Algoritmo nativo en PHP que convierte nombres comerciales en identificadores legibles y aptos para la web (eliminación de acentos, caracteres especiales y espacios).
- **Etiqueta Base Dinámica:** Se implementó `<base href="...">` en las vistas públicas para garantizar que rutas multinivel carguen correctamente hojas de estilo CSS, scripts e imágenes sin errores de resolución relativa.
- **Auto-Enfoque Cartográfico Inteligente:** `app.js` detecta automáticamente el slug o ID provisto en la URL, desplaza suavemente el mapa (`flyTo`), enfoca el marcador correspondiente y despliega su tarjeta interactiva.
- **Códigos QR de Alta Definición:** El módulo de administración genera códigos QR que apuntan a la URL limpia oficial (`https://sanjose.tur.ar/mapa/<slug>`), listos para impresión en etiquetas de productos y señalética urbana.
- **Retrocompatibilidad Completa:** Se mantiene compatibilidad total con parámetros legados (`/mapa?id=1`, `/mapa?productor=slug` y `/mapa.php`).

### 2. Padrón Dinámico y Sincronización en Tiempo Real
- **Carga Integral de Productores:** Sincronización completa con la base de datos MySQL, reflejando la totalidad de los productores activos tanto en el catálogo como en el mapa interactivo.
- **Renderizado Instantáneo (Zero Latency):** Inyección síncrona de datos desde el controlador PHP hacia JavaScript (`window.INITIAL_PRODUCTORES`), evitando retardos de red o pantallas en blanco al cargar la página.
- **Contadores de Filtros Dinámicos:** Los chips de filtrado por categoría y los subtítulos descriptivos actualizan su conteo numérico de manera automática a partir de los datos reales de la base de datos.
- **API REST de Respaldo:** Endpoint `/api/productores` con respuestas JSON estructuradas, soporte CORS y fallback seguro en frontend ante cualquier eventualidad.

### 3. Sistema de Inscripción Pública y Gestión de Solicitudes
- **Formulario Guiado en 4 Pasos (`/inscribir`):** Interfaz pública paso a paso para la postulación de nuevos emprendimientos locales.
- **Persistencia en Base de Datos:** Endpoint `/api/inscribir` que valida rigurosamente los datos ingresados y los almacena en la tabla relacional `ps_solicitudes_inscripcion` con estado `'pendiente'`.
- **Captura de Identificación Tributaria:** Registro automático del DNI/CUIT dentro del campo de notas de administración (`notas_admin`) para facilitar la verificación fiscal y comercial.
- **Bandeja de Aprobación en el Panel Admin (`/admin/solicitudes`):**
  - Listado de solicitudes pendientes con visualización de datos de contacto, notas y documentación.
  - Acciones directas de **Aprobar** (que traslada y da de alta automáticamente al productor en el padrón oficial) o **Rechazar**.
- **Feedback Transparente:** Eliminación de simulaciones ficticias; la interfaz informa con precisión el estado real del envío.

### 4. Panel de Control y Gestión Administrativa (Backoffice)
- **Gestión Integral de Productores (CRUD):** Alta, edición, suspensión y baja de productores con carga de coordenadas satelitales, rubros y canales de contacto.
- **Botón de Previsualización Directa («Ver»):** Enlace directo desde el listado administrativo hacia el mapa interactivo para corroborar la geolocalización exacta de cada comercio.
- **Gestión de Categorías y Rubros:** Configuración centralizada de categorías, colores de pines y etiquetas temáticas.
- **Exportación de Datos:** Descarga del padrón completo en formato CSV para análisis estadístico y cruce de datos comunales.
- **Manual de Seguridad y Buenas Prácticas:** Sección interna con lineamientos operativos para el personal municipal.

### 5. Arquitectura de Seguridad y Robustez Técnica
- **Protección contra Falsificación de Peticiones (CSRF):** Generación y validación de tokens criptográficos de un solo uso en todas las operaciones de modificación del panel de administración.
- **Prevención de Inyecciones SQL:** Acceso a datos implementado exclusivamente mediante `PDO` con consultas preparadas (`Prepared Statements`) y tipado estricto.
- **Mitigación de Cross-Site Scripting (XSS):** Sanitización y escape contextual riguroso (`htmlspecialchars` con flags `ENT_QUOTES, 'UTF-8'`) en todas las salidas HTML y respuestas JSON.
- **Cabeceras de Seguridad HTTP:** Reglas en `.htaccess` que inyectan directivas de protección:
  - `X-Frame-Options: SAMEORIGIN` (prevención de clickjacking).
  - `X-Content-Type-Options: nosniff` (bloqueo de sniffing de MIME types).
  - `X-XSS-Protection: 1; mode=block` (filtro activo en navegadores heredados).
  - `Referrer-Policy: strict-origin-when-cross-origin`.
- **Aislamiento de Archivos Críticos:** Bloqueo por servidor de archivos de configuración (`.env`, `env.php`), logs y repositorios `.git/`.
- **Conexión de Base de Datos Resiliente:** Mecanismo de conexión tolerante a fallos que evalúa variables de entorno (`.env`), configuraciones PHP directas (`env.php`) y credenciales seguras por defecto.

### 6. Sistema de Diseño (UI/UX) y Accesibilidad
- **Zero FOUC Dark Mode:** Algoritmo en el `<head>` que previene el destello blanco al cargar la página en modo oscuro, sincronizado con las preferencias del sistema operativo y persistido en `localStorage`.
- **Mobile First & Pestañas Táctiles:** En dispositivos móviles, la interfaz del mapa alterna con fluidez entre la visualización cartográfica y la lista de establecimientos.
- **Micro-interacciones y Tipografía Moderna:** Tipografías web de alto rendimiento (`Outfit` para titulares y `Plus Jakarta Sans` para lectura óptima de datos).
- **Cumplimiento de Accesibilidad (WCAG 2.1 Nivel AA):**
  - Contrastes cromáticos superiores a **4.5:1** en todos los elementos interactivos y textos.
  - Indicador de foco visible (`:focus-visible`) para navegación integral mediante teclado accesible.
  - Áreas táctiles mínimas de **44 × 44 px** para interacción cómoda en teléfonos y tablets.
  - Respeto de la preferencia de reducción de movimiento (`prefers-reduced-motion`).

---

## 🧭 Estructura del Proyecto (Arquitectura MVC + Front Controller)

```
productores-sanjose/
├── index.php                 # Front Controller principal y enrutador del sistema
├── style.css                 # Sistema de diseño integral (tokens, modo oscuro, responsive y print)
├── app.js                    # Lógica del mapa Leaflet, georreferenciación y auto-enfoque
├── setup.php                 # Asistente de instalación y migración de base de datos
├── .htaccess                 # Reglas de reescritura, seguridad y cabeceras HTTP
├── .gitignore                # Exclusiones de Git (archivos sensibles, logs y temporales)
│
├── core/                     # Núcleo del framework liviano
│   ├── Database.php          # Singleton de conexión PDO segura a MySQL
│   └── Router.php            # Enrutador HTTP con soporte de rutas dinámicas {slug}
│
├── controllers/              # Controladores de la aplicación
│   ├── PublicController.php  # Controlador de vistas públicas (Home, Mapa, Catálogo, etc.)
│   ├── AdminController.php   # Controlador del panel de administración y sesiones
│   └── ApiController.php     # Controlador de endpoints REST (Productores e Inscripciones)
│
├── models/                   # Capa de acceso a datos y repositorios
│   ├── ProductorRepository.php   # Consultas y persistencia de productores
│   └── CategoriaRepository.php   # Consultas y persistencia de categorías
│
├── views/                    # Plantillas y vistas de la aplicación
│   ├── public/               # Vistas de acceso público
│   │   ├── home.php          # Portal de bienvenida institucional
│   │   ├── mapa.php          # Mapa interactivo Leaflet con soporte de URLs amigables
│   │   ├── catalogo.php      # Catálogo de productores con buscador y filtros
│   │   ├── gondola.php       # Red de góndolas en comercios adheridos
│   │   ├── inscribir.php     # Formulario de postulación en 4 pasos
│   │   └── informe.php       # Informe técnico-legislativo para el Concejo Deliberante
│   └── admin/                # Vistas del panel de administración
│       ├── index.php         # Dashboard principal con métricas y accesos rápidos
│       ├── login.php         # Formulario de autenticación administrativa
│       ├── productores.php   # Padrón administrativo con botones Ver, Editar y QR
│       ├── productor-form.php# Formulario de alta/modificación de productor
│       ├── productor-acciones.php # Procesador de altas, bajas y modificaciones
│       ├── solicitudes.php   # Bandeja de solicitudes de inscripción ciudadana
│       ├── categorias.php    # Gestión de categorías y rubros
│       ├── exportar-csv.php  # Exportador del padrón en formato CSV
│       ├── manual.php        # Manual de operaciones y seguridad
│       ├── header.php        # Barra superior y navegación de administración
│       └── footer.php        # Cierre y scripts de administración
│
├── api/                      # Endpoints de compatibilidad directa
│   ├── productores.php       # Delegación directa a ApiController::getProductores
│   └── inscribir.php         # Delegación directa a ApiController::postInscribir
│
├── config/                   # Configuración del entorno
│   └── db.php                # Conexión y credenciales de base de datos
│
├── sql/                      # Scripts de base de datos
│   └── database.sql          # Estructura y datos iniciales de la base de datos
│
└── assets/                   # Recursos estáticos
    ├── css/
    │   └── normalized.css    # Normalización de estilos y reset tipográfico
    ├── logo-sanjose.png      # Isologotipo oficial de la Municipalidad de San José
    └── productores/          # Galería fotográfica de los establecimientos
```

---

## 🗄️ Esquema de Base de Datos MySQL

El sistema utiliza las siguientes tablas principales para su funcionamiento:

1. **`ps_productores`**: Almacena los emprendimientos activos con coordenadas satelitales (`lat`, `lng`), rubro, categoría, dirección, teléfonos, horarios, biografía comercial y estado de destacado.
2. **`ps_categorias`**: Gestiona las categorías comerciales, asignando colores cromáticos a los pines cartográficos y etiquetas de interfaz.
3. **`ps_solicitudes_inscripcion`**: Registra las solicitudes enviadas desde el formulario público con estado (`pendiente`, `aprobada`, `rechazada`), CUIT/DNI en `notas_admin` y datos de contacto.
4. **`ps_usuarios`**: Usuarios administradores con contraseñas encriptadas mediante `password_hash` (`bcrypt`).
5. **`ps_configuracion`**: Parámetros globales de la plataforma institucional.

---

## 🌰 Padrón de Productores y URLs Semánticas

| N° | Emprendimiento | Rubro / Especialidad | URL Amigable Oficial |
| :-: | :--- | :--- | :--- |
| **01** | **Licores Bard** | Licores Tradicionales (Desde 1908) | `/mapa/licores-bard` |
| **02** | **Establecimiento Los Pecanes** | Plantación Pionera, Casa de Té y Patio | `/mapa/establecimiento-los-pecanes` |
| **03** | **De los Troncos Petrificados** | Reserva Natural, Maderas y Minerales | `/mapa/de-los-troncos-petrificados` |
| **04** | **Artesanías El Palmar** | Cestería en Palma Yatay y Mates | `/mapa/artesanias-el-palmar` |
| **05** | **Nuez Pecán La Reina** | Boutique del Pecán | `/mapa/nuez-pecan-la-reina` |
| **06** | **Apícola La Sanjosesina** | Miel Pura de Monte Nativo y Propóleo | `/mapa/apicola-la-sanjosesina` |
| **07** | **Granja La Administración** | Quesería Tradicional junto al Molino Forclaz | `/mapa/granja-la-administracion` |
| **08** | **Dulces Caseros La Juanita** | Mermeladas en Paila de Cobre | `/mapa/dulces-caseros-la-juanita` |
| **09** | **Viñedos & Bodega Vulliez Sermet**| Enoturismo y Varietales Entrerrianos | `/mapa/vinedos-y-bodega-vulliez-sermet` |
| **10** | **Cervecería Artesanal El Molino**| Microcervecería con Maltas Entrerrianas | `/mapa/cerveceria-artesanal-el-molino` |
| **11** | **Cuchillería Sanjo Tradición** | Forja Criolla en Acero y Platería | `/mapa/cuchilleria-sanjo-tradicion` |
| **12** | **Establecimiento Los Nogales** | Nuez Pecán Seleccionada y Derivados | `/mapa/establecimiento-los-nogales` |
| **13** | **Miel Dorada San José** | Apicultura de Colonia y Subproductos | `/mapa/miel-dorada-san-jose` |

---

## ⚙️ Puesta en Marcha e Instalación

### Requisitos del Entorno
- **PHP:** Versión 8.0 o superior (con extensiones `pdo_mysql`, `mbstring` y `json` activadas).
- **Servidor Web:** Apache con módulo `mod_rewrite` activo (o Nginx con bloque `try_files $uri $uri/ /index.php?$query_string;`).
- **Base de Datos:** MySQL 5.7+ o MariaDB 10.3+.

### Pasos de Instalación

1. **Clonar el Repositorio:**
   ```bash
   git clone https://github.com/ea00d009/productores-sanjose.git
   cd productores-sanjose
   ```

2. **Configuración de Conexión a Base de Datos:**
   Crear un archivo `.env` en la raíz (o `config/.env` o `env.php` según el entorno de hosting):
   ```env
   DB_HOST=localhost
   DB_NAME=productores_sanjose
   DB_USER=usuario_mysql
   DB_PASS=tu_contraseña
   DB_PORT=3306
   ```

3. **Importar la Base de Datos:**
   Importar el archivo `sql/database.sql` en tu gestor de base de datos (phpMyAdmin o CLI):
   ```bash
   mysql -u usuario_mysql -p productores_sanjose < sql/database.sql
   ```
   *Alternativamente, podés ejecutar el asistente web accediendo a `/setup.php` desde el navegador.*

4. **Acceso al Panel de Administración:**
   - Navegar a `/admin` o `/admin/login`.
   - Credenciales predeterminadas de primer inicio:
     - **Usuario:** `admin`
     - **Contraseña:** `admin123` *(debe ser modificada inmediatamente tras el primer ingreso)*.

---

## 🏛️ Créditos Institucionales

- **Iniciativa:** Secretaría de Educación, Cultura y Turismo &bull; Municipalidad de San José, Entre Ríos.
- **Destinatario:** Honorable Concejo Deliberante de la Ciudad de San José.
- **Año:** 2026.
- **Licencia:** Proyecto institucional y de código abierto para fomento de la producción local y el desarrollo comunitario.
