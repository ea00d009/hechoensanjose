# Hecho en San José &bull; Manual de Usuario y Guía de Operaciones

**Plataforma Oficial de Turismo y Articulación del Sector Productivo Local**  
**Municipalidad de San José, Entre Ríos, Argentina** &bull; Secretaría de Educación, Cultura y Turismo  
*Versión 2.0 &bull; Arquitectura MVC, URLs Semánticas, Cartografía Satelital Leaflet y Homologación Digital*

---

## 📋 Índice General

1. [Visión y Objetivos del Programa](#1-visión-y-objetivos-del-programa)
2. [Ecosistema Público y Navegación Turística](#2-ecosistema-público-y-navegación-turística)
   - [2.1. Portal Principal / Home (`/`)](#21-portal-principal--home-)
   - [2.2. Mapa Productivo Interactivo (`/mapa` y `/mapa/{slug}`)](#22-mapa-productivo-interactivo-mapa-y-mapaslug)
   - [2.3. Catálogo Digital de Productores (`/catalogo`)](#23-catálogo-digital-de-productores-catalogo)
   - [2.4. Red de Góndolas Oficiales (`/gondola`)](#24-red-de-góndolas-oficiales-gondola)
   - [2.5. Formulario de Postulación Ciudadana (`/inscribir`)](#25-formulario-de-postulación-ciudadana-inscribir)
3. [Panel de Gestión y Backoffice Administrativo (`/admin`)](#3-panel-de-gestión-y-backoffice-administrativo-admin)
   - [3.1. Acceso y Autenticación de Operadores](#31-acceso-y-autenticación-de-operadores)
   - [3.2. Dashboard Principal y Métricas en Tiempo Real](#32-dashboard-principal-y-métricas-en-tiempo-real)
4. [Gestión del Padrón de Productores](#4-gestión-del-padrón-de-productores)
   - [4.1. Listado y Acciones Rápidas (Ver, QR, Destacar, Activar/Pausar, Eliminar)](#41-listado-y-acciones-rápidas)
   - [4.2. Formulario de Alta y Edición (`productor-form.php`)](#42-formulario-de-alta-y-edición)
   - [4.3. Selector Geográfico Satelital Interactivo](#43-selector-geográfico-satelital-interactivo)
   - [4.4. Carga y Validación de Fotografías](#44-carga-y-validación-de-fotografías)
   - [4.5. Configuración de Enlaces a WhatsApp](#45-configuración-de-enlaces-a-whatsapp)
   - [4.6. Asignación a Góndolas Municipales (Sinergia Padrón Web ↔ Puntos Físicos)](#46-asignación-a-góndolas-municipales)
5. [Red de Góndolas Oficiales (Módulo ABM y Sinergia)](#5-red-de-góndolas-oficiales-módulo-abm-y-sinergia)
   - [5.1. Iniciativa Municipal y Concepto de Góndola](#51-iniciativa-municipal-y-concepto-de-góndola)
   - [5.2. Regla Institucional: Requisito de Padrón Web](#52-regla-institucional-requisito-de-padrón-web)
   - [5.3. Padrón y Acciones Rápidas (`/admin/gondolas`)](#53-padrón-y-acciones-rápidas)
   - [5.4. Formulario de Alta y Edición (`/admin/gondola-form`)](#54-formulario-de-alta-y-edición-de-góndolas)
   - [5.5. Integración Dinámica en la Web Pública (`/gondola`, `/catalogo` y `/mapa`)](#55-integración-dinámica-en-la-web-pública)
6. [Bandeja de Solicitudes y Homologación en 1 Clic](#6-bandeja-de-solicitudes-y-homologación-en-1-clic)
   - [6.1. Ciclo de Vida de una Solicitud (Pendiente &bull; Aprobada &bull; Desestimada)](#61-ciclo-de-vida-de-una-solicitud)
   - [6.2. Verificación de Datos e Identificación Fiscal (CUIT/DNI)](#62-verificación-de-datos-e-identificación-fiscal)
   - [6.3. Circuito Automatizado «Aprobar y Asignar a Góndolas»](#63-circuito-automatizado-aprobar-y-asignar-a-góndolas)
   - [6.4. Contacto Institucional Previo por WhatsApp](#64-contacto-institucional-previo-por-whatsapp)
7. [URLs Semánticas y Marketing Territorial con Códigos QR](#7-urls-semánticas-y-marketing-territorial-con-códigos-qr)
   - [7.1. Estructura de URLs Amigables (`/mapa/<slug>`)](#71-estructura-de-urls-amigables)
   - [7.2. Generación e Impresión de Códigos QR para Packaging y Señalética](#72-generación-e-impresión-de-códigos-qr)
8. [Categorías, Rubros y Simbología Cartográfica](#8-categorías-rubros-y-simbología-cartográfica)
9. [Exportación de Datos y Estadísticas Comunitarias (CSV / Excel)](#9-exportación-de-datos-y-estadísticas-comunitarias)
10. [Seguridad del Sistema, Resguardos y Buenas Prácticas](#10-seguridad-del-sistema-resguardos-y-buenas-prácticas)
11. [Preguntas Frecuentes y Soporte Operativo](#11-preguntas-frecuentes-y-soporte-operativo)

---

## 1. Visión y Objetivos del Programa

El programa municipal **«Hecho en San José»** surge con el propósito de conectar de manera directa el flujo turístico que visita San José (termas, playas del río Uruguay, circuito histórico de la colonización y fiestas populares) con la producción genuina del ejido urbano y colonias rurales.

### Pilares Fundamentales:
* **Soberanía Tecnológica:** Construido íntegramente con tecnologías de código abierto (**Leaflet.js**, **OpenStreetMap**, **PHP 8** y **MySQL**), eliminando costos de licenciamiento recurrentes y prescindiendo de APIs de pago.
* **Comercialización Directa:** Fomento del consumo de cercanía mediante contacto directo vía WhatsApp y navegación GPS guiada paso a paso, sin intermediarios comerciales ni comisiones.
* **Identidad de Origen:** Resguardo de oficios tradicionales: apicultura de monte nativo, plantaciones pioneras de nuez pecán, licores centenarios, queserías tradicionales, vitivinicultura entrerriana y forja criolla.
* **Transparencia y Respaldo Institucional:** Registro formal de solicitudes ciudadanas y homologación municipal del padrón productivo.

---

## 2. Ecosistema Público y Navegación Turística

La plataforma opera bajo una arquitectura moderna **MVC (Front Controller)** con URLs limpias y amigables (sin extensiones `.php` en la barra del navegador).

```
        USUARIO TURISTA / VECINO
                   │
                   ▼
┌────────────────────────────────────────────────────────┐
│                      index.php                         │
│                  (Front Controller)                    │
└──────┬────────────┬────────────┬───────────┬───────────┘
       │            │            │           │
       ▼            ▼            ▼           ▼
  / (Home)       /mapa        /catalogo   /inscribir
              /mapa/{slug}
```

### 2.1. Portal Principal / Home (`/`)
* **Hero Institucional:** Mensaje de bienvenida, contextualización del programa y accesos inmediatos a las secciones principales.
* **Métricas en Vivo:** Contadores dinámicos sincronizados con la base de datos municipal (productores registrados, rubros artesanales, puntos de góndola).
* **Productores Destacados:** Muestra rotativa de establecimientos priorizados por la Secretaría.
* **Llamado a la Acción para Emprendedores:** Acceso directo al formulario de inscripción para vecinos interesados en sumarse al padrón.

### 2.2. Mapa Productivo Interactivo (`/mapa` y `/mapa/{slug}`)
* **Cartografía Dinámica (Leaflet):** Centrada sobre San José y sus colonias productivas con marcadores clasificados por colores temáticos.
* **URLs Amigables y Canónicas (`/mapa/{slug}`):**
  * Cada productor posee una URL única, legible y apta para compartir en redes sociales y WhatsApp (ej. `/mapa/licores-bard`, `/mapa/apicola-la-sanjosesina`).
  * **Auto-Enfoque Satelital Inteligente (`flyTo`):** Al abrir una URL con slug, el mapa se desplaza suavemente hacia el establecimiento, enfoca el marcador correspondiente y despliega automáticamente su tarjeta informativa.
* **Filtros por Rubro:** Barra superior con pastillas de categoría para filtrar establecimientos en un solo toque.
* **Ruta GPS Guiada («Cómo llegar»):** Abre automáticamente Google Maps o la app de mapas predeterminada del teléfono inteligente para guiar al visitante paso a paso hasta el establecimiento.
* **Contacto Directo por WhatsApp:** Dispara una conversación directa con el productor con un mensaje de consulta preconfigurado.

### 2.3. Catálogo Digital de Productores (`/catalogo`)
* **Buscador en Tiempo Real:** Filtra instantáneamente por nombre del establecimiento, rubro comercial o materias primas locales.
* **Chips de Filtrado con Contadores Dinámicos:** Los filtros por categoría calculan y muestran en vivo la cantidad exacta de productores disponibles (ej. *«Mostrando 13 de 13 productores»*).
* **Fichas Informativas Completas:** Cada tarjeta incluye fotografía real, distintivo de rubro, dirección física, horarios de atención al público, reseña histórica del emprendimiento, botón de WhatsApp y acceso directo a su posición en el mapa.

### 2.4. Red de Góndolas Oficiales (`/gondola`)
* **Puntos de Venta Adheridos:** Directorio de vinotecas, almacenes de campo y centros turísticos de San José que disponen de un exhibidor exclusivo identificado con la marca institucional del programa.
* **Información Comercial:** Dirección, teléfonos de contacto y listado de rubros disponibles en cada punto de venta.

### 2.5. Formulario de Postulación Ciudadana (`/inscribir`)
Formulario interactivo en **4 pasos** diseñado para facilitar el registro de productores y microemprendedores locales:
1. **Paso 1: Datos del Negocio:** Nombre comercial y rubro de especialidad.
2. **Paso 2: Contacto y Titular:** Nombre del responsable, número de WhatsApp, correo electrónico y **DNI / CUIT** (almacenado para posterior validación fiscal y bromatológica).
3. **Paso 3: Materias Primas y Producción:** Reseña del proceso productivo e insumos de origen local utilizados.
4. **Paso 4: Canales de Interés:** Selección de módulos en los que desea participar (Catálogo Web, Mapa Productivo, Góndolas en Comercios, Ferias y Eventos Municipales).

> [!NOTE]
> Al enviarse el formulario, la solicitud se almacena de forma inmediata en la base de datos municipal con estado `pendiente` y queda disponible en el panel administrativo.

---

## 3. Panel de Gestión y Backoffice Administrativo (`/admin`)

El panel de control permite a los operadores autorizados de la Municipalidad gestionar todo el ecosistema de datos de manera intuitiva y segura.

```
                   PANEL DE ADMINISTRACIÓN (/admin)
                                 │
    ┌──────────────┬─────────────┼─────────────┬──────────────┬──────────────┐
    ▼              ▼             ▼             ▼              ▼              ▼
Dashboard    Productores     Góndolas     Solicitudes    Categorías      Manual
 (/admin)   (/admin/prod)  (/admin/gond) (/admin/sol)   (/admin/cat)   Operativo
```

### 3.1. Acceso y Autenticación de Operadores
* **URL de Ingreso:** `/admin/login` o `/admin`.
* **Credenciales Iniciales:**
  * **Usuario:** `admin`
  * **Contraseña predeterminada:** `admin123` *(Se recomienda modificar tras el primer inicio)*.
* **Mecanismos de Protección:**
  * Hashing de contraseñas mediante algoritmo `bcrypt` de sentido único.
  * Regeneración de identificadores de sesión (`session_regenerate_id`) para evitar fijación de sesiones.
  * Protección con cookies de estricta seguridad (`HttpOnly`, `SameSite=Lax`).
* **Cierre de Sesión:** Al finalizar la jornada, pulsar el enlace **«Cerrar Sesión»** en la barra superior derecha para invalidar la sesión activa.

### 3.2. Dashboard Principal y Métricas en Tiempo Real
Al iniciar sesión, el sistema presenta un tablero de control con indicadores cuantitativos del programa:
* **Total de Productores Activos:** Emprendimientos visibles en el mapa y catálogo.
* **Productores Destacados:** Emprendimientos con insignia de prioridad comercial.
* **Categorías Productivas:** Rubros configurados en la plataforma.
* **Solicitudes Pendientes:** Conteo de postulaciones ciudadanas que aguardan revisión de la Secretaría.

---

## 4. Gestión del Padrón de Productores

Módulo central para la administración del padrón oficial municipal (`/admin/productores`).

### 4.1. Listado y Acciones Rápidas

La tabla de productores cuenta con buscador por texto, filtro por categoría y filtro por estado (Activo/Inactivo), ofreciendo botones de acción rápida en cada fila:

| Botón | Función | Descripción Operativa |
| :--- | :---: | :--- |
| **👁️ Ver** | Previsualización Canónica | Abre la URL pública amigable (`/mapa/{slug}`) en una nueva pestaña para auditar el mapa y la ficha en tiempo real. |
| **📱 QR** | Código QR Vectorial | Despliega una ventana modal con el código QR oficial de alta resolución listo para descargar o imprimir. |
| **✏️ Editar** | Modificación Completa | Abre el formulario con todos los campos, mapa de coordenadas y selector de imágenes. |
| **⭐ Destacado** | Toggle en 1 Clic | Activa o desactiva la insignia dorada de prioridad sin necesidad de entrar al formulario. |
| **👁️‍🗨️ Activo / Inactivo** | Pausa Temporal | Oculta o visibiliza al productor en la web pública de manera instantánea sin borrar sus datos. |
| **🗑️ Eliminar** | Baja Definitiva | Remueve el registro tras una confirmación del operador, protegido con token criptográfico CSRF. |

### 4.2. Formulario de Alta y Edición (`productor-form.php`)
Para incorporar un nuevo productor manualmente, acceder a **«+ Nueva Alta»** en la barra de navegación del panel.

**Campos Requeridos:**
1. **Nombre del Emprendimiento:** Denominación comercial o de fantasía (ej. *Licores Bard*).
2. **Rubro / Especialidad:** Breve descripción de la actividad (ej. *Licores Tradicionales Desde 1908*).
3. **Categoría:** Selección del sector productivo. Al elegirla, el sistema asigna automáticamente el color del pin, el ícono SVG y la clase de etiqueta.
4. **Dirección / Ubicación:** Domicilio físico, paraje o referencia de acceso (ej. *Centenario 1234, San José*).
5. **Teléfono y WhatsApp:** Número de contacto comercial.
6. **Horarios de Atención:** Días y franjas horarias de visita o venta al público.
7. **Biografía / Descripción:** Historia del emprendimiento, métodos de elaboración y materias primas entrerrianas empleadas.
8. **Coordenadas Satelitales (Latitud / Longitud):** Determinadas mediante el mapa interactivo.

### 4.3. Selector Geográfico Satelital Interactivo

Para garantizar máxima exactitud sin requerir conocimientos técnicos de GPS:
1. En el formulario de alta/edición se visualiza un mapa interactivo de San José.
2. **Colocar Pin:** Hacer clic sobre el punto exacto de la ciudad o zona rural donde se encuentra el establecimiento.
3. **Ajuste Fino:** Mantener presionado el marcador y arrastrarlo hasta la entrada del predio o taller.
4. Las casillas numéricas de **Latitud** y **Longitud** se sincronizan instantáneamente con el marcador.

```
       [ MAPA SATELITAL DE SAN JOSÉ ]
    ┌─────────────────────────────────┐
    │                                 │
    │          📍 (Clic / Arrastre)   │
    │                                 │
    └─────────────────────────────────┘
                     │
                     ▼
  Latitud: -32.2123000  Longitud: -58.2191000  (Calculadas automáticamente)
```

### 4.4. Carga y Validación de Fotografías
* **Subida Local:** Permite adjuntar un archivo fotográfico representativo desde la computadora.
* **Formatos Admitidos:** JPG, JPEG, PNG y WebP.
* **Límite de Tamaño:** Hasta 5 MB por imagen.
* **Seguridad MIME en Servidor:** El sistema inspecciona los encabezados binarios del archivo para bloquear ejecutables disfrazados.
* **Renombrado Automático:** La imagen se almacena con un nombre normalizado y sanitizado en `assets/productores/`.
* **Ruta Alternativa:** Si la foto ya está alojada en un servidor externo, se puede consignar la URL directa.

### 4.5. Configuración de Enlaces a WhatsApp
* **Formato Correcto:** Ingresar el número con código de país y área sin el signo `+` ni el prefijo `15` (ejemplo para San José: `5493447412345`).
* **Comportamiento en la Web:** Al hacer clic en el botón de WhatsApp del portal público, el sistema abre la aplicación en teléfonos móviles o WhatsApp Web en computadoras con un texto institucional prearmado.

### 4.6. Asignación a Góndolas Municipales (Sinergia Padrón Web ↔ Puntos Físicos)
En la **Sección 5** del formulario de edición del productor (`productor-form.php`), el sistema presenta la lista dinámica de todas las góndolas municipales activas con casillas de verificación (checkboxes):
* **Marcación Múltiple:** Se pueden tildar uno, varios o todos los puntos de venta donde este productor tiene mercadería en exhibición.
* **Sincronización Inmediata:** Al guardar el formulario, la tabla relacional `ps_gondola_productores` se actualiza al instante.
* **Insignias en el Padrón:** En la tabla de productores (`/admin/productores`), cada fila exhibe la insignia `🛒 X góndolas` indicando la cantidad de exhibidores físicos donde participa.

---

## 5. Red de Góndolas Oficiales (Módulo ABM y Sinergia)

Las **Góndolas «Hecho en San José»** son una **Iniciativa Municipal** que brinda un espacio exclusivo para el trabajo local. Son exhibidores especialmente identificados con cartelería y diseño institucional ubicados en los principales comercios, supermercados y centros turísticos de nuestra ciudad.

Su propósito fundamental es:
* **Precios justos y productos genuinamente sanjosesinos.**
* **Fácil acceso para turistas y residentes sin tener que recorrer toda la colonia.**

### 5.1. Iniciativa Municipal y Concepto de Góndola
Cada punto adherido cuenta con un mueble o exhibidor oficial provisto por el municipio donde los productores colocan miel, nueces pecán, dulces coloniales, licores centenarios, embutidos y artesanías locales.

### 5.2. Regla Institucional: Requisito de Padrón Web
> [!IMPORTANT]
> **Norma de Homologación Municipal:** Para que un productor local pueda colocar y vender sus productos en las Góndolas Municipales instaladas en comercios y supermercados, **es condición obligatoria e ineludible estar inscripto, homologado y publicado en el padrón web oficial de «Hecho en San José»**.
> Esta directriz garantiza trazabilidad de origen, calidad artesanal, habilitaciones correspondientes y asegura que cualquier turista o vecino frente a la góndola física pueda escanear el QR institucional y acceder a la historia, proceso y contacto directo del productor.

### 5.3. Padrón y Acciones Rápidas (`/admin/gondolas`)
* **URL:** `/admin/gondolas` o `/admin/gondolas.php`.
* **Métricas y Badges en Vivo:** Cada tarjeta de góndola muestra la pastilla `👨‍🌾 X productores asignados` con enlace directo a su gestión.
* **Filtros por Búsqueda y Estado:** Permite filtrar rápidamente por nombre del local, dirección o productos, y por estado (*Habilitadas*, *Pausadas*, *Destacadas*).
* **Conmutadores de 1 Clic:**
  * **Habilitada / Pausada:** Alterna la visibilidad pública en el portal web de manera instantánea.
  * **Destacada (★):** Otorga insignia dorada y prioridad visual al exhibidor.
* **Exportación CSV:** Botón para generar reporte en Excel de todos los puntos de venta adheridos.

### 5.4. Formulario de Alta y Edición de Góndolas (`/admin/gondola-form`)
* **Nombre del Comercio / Local:** Denominación física del establecimiento.
* **Tipo / Distintivo:** Góndola Central, Punto Turístico, Almacén de Campo, Complejo Termal, etc.
* **Estilo Visual / Color:** Selección de paleta institucional (Esmeralda, Azul, Ámbar, Acento).
* **Productos Destacados:** Detalle de qué artículos se encuentran exhibidos en ese punto específico.
* **Geolocalización Satelital Interactiva:** Selector sobre mapa satelital Leaflet para arrastrar el pin y obtener automáticamente las coordenadas GPS y el enlace de llegada de Google Maps.
* **Asignación Bidireccional de Productores:** Selector con casillas de verificación para marcar qué productores locales registrados tienen presencia física en ese exhibidor comercial.

### 5.5. Integración Dinámica en la Web Pública (`/gondola`, `/catalogo` y `/mapa`)
La articulación entre góndolas y productores se refleja en toda la plataforma ciudadana:
* **En `/gondola`:** Cada tarjeta de punto de venta enumera a los productores locales participantes mediante chips enlazados que permiten buscar su ficha con un solo clic.
* **En `/catalogo`:** Los productores asignados a góndolas lucen una insignia destacada `🛒 Disponible en Góndola: [Comercios...]`. Al pulsar sobre ella, el catálogo filtra automáticamente mostrando la disponibilidad en dicho comercio.
* **En `/mapa`:** La ventana emergente (popup) del productor y la barra lateral detallan las góndolas municipales donde se consiguen sus elaboraciones.

---

## 6. Bandeja de Solicitudes y Homologación en 1 Clic

El módulo de solicitudes (`/admin/solicitudes`) conecta la participación ciudadana con la gestión municipal, eliminando la duplicación de tareas de carga.

### 6.1. Ciclo de Vida de una Solicitud

```
  Vecino completa formulario      Bandeja de Entrada Admin          Homologación Oficial
     en /inscribir.php         ──►   solicitudes.php         ──►    «Aprobar y Asignar»
   (Estado: 'pendiente')               (Revisión)                   (Estado: 'aprobada')
```

1. **🟡 Pendiente:** Solicitud recién ingresada que aguarda revisión técnica y legal por parte de la Secretaría.
2. **🟢 Aprobada (En Padrón):** Emprendimiento homologado que ya forma parte activa del padrón oficial y mapa interactivo.
3. **⚪ Desestimada:** Postulaciones incompletas, duplicadas o que no se encuadran en los requisitos del programa.

### 6.2. Verificación de Datos e Identificación Fiscal
Cada tarjeta de solicitud presenta los siguientes datos recopilados:
* Nombre del titular y nombre del emprendimiento.
* Dirección física declarada.
* Descripción detallada del proceso productivo e insumos locales.
* **Identificación Fiscal / Notas:** Número de CUIT o DNI informado por el postulante en el formulario para cruce con habilitaciones comerciales y bromatología.
* Módulos de interés (Catálogo, Mapa, Góndolas, Ferias).

### 6.3. Circuito Automatizado «Aprobar y Asignar a Góndolas»

Para dar de alta a un solicitante sin tener que tipear sus datos nuevamente:

1. Ingresar a la pestaña **«Pendientes de Revisión»** en `/admin/solicitudes`.
2. **Detección de Interés en Góndolas:**
   * Si el postulante tildó el módulo de *Venta en Góndolas Municipales*, el sistema resalta el botón en color púrpura: **`✓ Aprobar y Asignar a Góndolas →`**.
   * Si no tildó góndolas, el botón se muestra como **`✓ Aprobar y Convertir en Productor`**.
3. **Transferencia Automática con Guía Asistida:** El sistema abre el formulario de alta de productor con los campos ya completados:
   * Nombre comercial.
   * Rubro y especialidad.
   * Número de WhatsApp.
   * Dirección declarada.
   * Descripción productiva.
   * **Deducción de Categoría Inteligente:** Clasifica automáticamente entre Alimentos, Bebidas, Artesanías, etc. según las palabras clave del rubro.
   * **Llamado de Atención para Asignación de Góndolas:** Aparece un aviso destacado recordando al operador que debe tildar en la **Sección 5** los puntos de góndola acordados.
4. **Completar Ubicación y Foto:** El operador solo ubica el pin satelital, sube una foto y selecciona las góndolas correspondientes.
5. **Guardar y Homologar:** Al pulsar *«Guardar Productor»*, el sistema:
   * Inserta el nuevo productor en `ps_productores`.
   * Guarda las relaciones en `ps_gondola_productores`.
   * **Actualiza automáticamente la solicitud al estado `aprobada`**.
   * El emprendimiento queda visible de inmediato en la web pública, mapa, catálogo y góndolas.

### 6.4. Contacto Institucional Previo por WhatsApp
Antes de homologar, el operador puede hacer clic en el botón **«Enviar WhatsApp»** dentro de la tarjeta de la solicitud. Esto abre un chat directo con el titular con un mensaje de cortesía municipal preconfigurado.

---

## 7. URLs Semánticas y Marketing Territorial con Códigos QR

### 7.1. Estructura de URLs Amigables
La plataforma genera identificadores semánticos limpios (slugs) a partir del nombre comercial de cada productor:

| Productor | URL Amigable Oficial |
| :--- | :--- |
| Licores Bard | `https://sanjose.tur.ar/mapa/licores-bard` |
| Establecimiento Los Pecanes | `https://sanjose.tur.ar/mapa/establecimiento-los-pecanes` |
| Apícola La Sanjosesina | `https://sanjose.tur.ar/mapa/apicola-la-sanjosesina` |
| Viñedos & Bodega Vulliez Sermet | `https://sanjose.tur.ar/mapa/vinedos-y-bodega-vulliez-sermet` |
| Cuchillería Sanjo Tradición | `https://sanjose.tur.ar/mapa/cuchilleria-sanjo-tradicion` |

### 7.2. Generación e Impresión de Códigos QR

Desde el listado del padrón (`/admin/productores`), el botón **«QR»** genera el código bidimensional enlazado a la URL oficial del productor.

#### Aplicaciones Prácticas:
1. **Etiquetado de Envases y Packaging:** Productores de miel, licores, vinos y nueces pueden imprimir el código en sus etiquetas comerciales. El turista que compra el producto en una góndola puede escanearlo y conocer la historia del productor y cómo visitar el taller.
2. **Folletería y Guías Turísticas:** Distribución en oficinas de informes de Plaza Urquiza, Balneario Camping San José y Termas.
3. **Carteles en Tranqueras y Entradas:** Señalética en caminos rurales y colonias para turistas que recorren en vehículo o bicicleta.

---

## 8. Categorías, Rubros y Simbología Cartográfica

El módulo de categorías (`/admin/categorias`) permite organizar los sectores de la economía regional:

* **Nombre de la Categoría:** Denominación formal (ej. *Nuez Pecán, Licores y Vinos, Apicultura, Sabores de Colonia*).
* **Color Cromático del Pin (Hexadecimal):** Define el color del círculo marcador en la cartografía interactiva (ej. `#059669` verde para nueces, `#d97706` ámbar para miel).
* **Ícono Vectorial SVG:** Código SVG incrustado que se renderiza dentro del marcador, garantizando definición visual sin importar la resolución de pantalla.
* **Clase CSS del Tag:** Estilo de la pastilla informativa que aparece en el catálogo digital.
* **Orden Numérico:** Posición de aparición en la barra de filtros del portal público.

---

## 9. Exportación de Datos y Estadísticas Comunitarias

Para tareas de planificación municipal, informes de gestión o articulación turística y comercial:

1. Ingresar a `/admin/productores`, `/admin/gondolas` o `/admin/solicitudes`.
2. Presionar el botón **«⬇️ Exportar CSV»**.
3. El sistema genera un archivo con formato estándar de valores separados por comas:
   * **Compatibilidad Total:** El archivo incorpora marca de orden de bytes (**UTF-8 BOM**), garantizando que **Microsoft Excel** y **LibreOffice Calc** abran el archivo de forma nativa sin corromper tildes, letras «ñ» ni caracteres especiales.
   * **Campos Exportados:** ID, nombre, rubro, categoría, dirección, coordenadas geográficas, teléfonos, horarios, góndolas asignadas, fecha de creación y estado.

---

## 10. Seguridad del Sistema, Resguardos y Buenas Prácticas

El sistema implementa 6 capas de seguridad defensiva para proteger la infraestructura informática municipal:

```
┌─────────────────────────────────────────────────────────────┐
│ 1. BLINDAJE DE CONFIGURACIÓN (env.php / .htaccess)          │
├─────────────────────────────────────────────────────────────┤
│ 2. INMUNIDAD SQLi (Consultas Preparadas con PDO)            │
├─────────────────────────────────────────────────────────────┤
│ 3. PROTECCIÓN CSRF (Tokens criptográficos de un solo uso)   │
├─────────────────────────────────────────────────────────────┤
│ 4. MITIGACIÓN XSS (Sanitización con htmlspecialchars)       │
├─────────────────────────────────────────────────────────────┤
│ 5. SESIONES SEGURAS (Regeneración de ID, HttpOnly, SameSite)│
├─────────────────────────────────────────────────────────────┤
│ 6. AISLAMIENTO Y CABECERAS HTTP (Clickjacking y MIME Sniff) │
└─────────────────────────────────────────────────────────────┘
```

### Reglas de Operación Segura para el Personal Municipal:
1. **Contraseñas Fuertes:** No utilizar contraseñas obvias ni compartirlas por servicios de mensajería no seguros.
2. **Cierre de Turno Obligatorio:** En computadoras de uso compartido de la Secretaría, cerrar la sesión haciendo clic en *«Cerrar Sesión»* antes de abandonar el puesto de trabajo.
3. **Validación de CUIT:** Antes de homologar un productor proveniente del formulario público, verificar que el número de CUIT/DNI registrado en notas coincida con los registros comerciales y bromatológicos municipales.
4. **Resguardo Periódico:** Exportar mensualmente el padrón en formato CSV como copia de respaldo operativa externa.

---

## 11. Preguntas Frecuentes y Soporte Operativo

### ¿Un productor puede participar en una Góndola Municipal sin estar en la web?
**No.** Por disposición municipal del programa Hecho en San José, la presencia física en las góndolas de comercios y supermercados exige estar previamente registrado y homologado en el padrón web oficial. Esto permite a los consumidores acceder a la información del productor mediante el código QR exhibido en el punto de venta.

### ¿Qué hago si un productor cambia de taller o traslada su punto de venta?
Acceder a **Gestión de Productores**, hacer clic en **Editar** en el registro correspondiente y reposicionar el pin en el mapa satelital. Las coordenadas se actualizarán de inmediato en el mapa interactivo.

### ¿Un productor puede estar en el catálogo pero no en el mapa?
Sí. Si un artesano produce en su domicilio particular y no desea recibir visitas presenciales pero sí comercializar por WhatsApp o en góndolas, se puede indicar en el campo *Horario*: *«Atención exclusiva mediante catálogo y envíos»*.

### ¿Cómo pausar a un productor por temporada sin borrarlo?
Hacer clic en el conmutador de estado **Activo / Inactivo** de su fila en el padrón administrativo. El productor dejará de verse en la web pública inmediatamente y podrá reactivarse con un solo clic cuando reinicie actividades.

### ¿Por qué el sistema rechaza una imagen al intentar subirla?
El sistema verifica que el archivo sea efectivamente una imagen real (JPG, PNG o WebP) y que no supere los **5 MB**. Si el archivo fue generado por una cámara profesional en alta resolución, comprimirlo o reducir su escala antes de subirlo.

---

*Manual elaborado y actualizado por la Secretaría de Educación, Cultura y Turismo &bull; Municipalidad de San José, Entre Ríos &bull; República Argentina.*
