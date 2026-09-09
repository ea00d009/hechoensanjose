# Hecho en San José &bull; Plataforma Productiva y Cartográfica

Plataforma web integral, interactiva y de soberanía tecnológica diseñada para articular el sector productivo local con el ecosistema turístico oficial de la ciudad de **San José, Entre Ríos, Argentina** ([sanjose.tur.ar/hechoensanjose](https://sanjose.tur.ar/hechoensanjose/)).

Desarrollada como propuesta de desarrollo socioeconómico, fomento del consumo de cercanía y visualización territorial para ser elevada y tratada ante el **Honorable Concejo Deliberante de la Ciudad de San José**.

---

## 🌐 Accesos Directos a la Plataforma en Vivo

El proyecto se encuentra desplegado de forma continua mediante integración continua (GitHub Actions) en **GitHub Pages**:

| Módulo / Sección | Descripción | Enlace en Vivo |
| :--- | :--- | :--- |
| 🏛️ **Portal Principal** | Grilla institucional, presentación y propuesta HCD | [ea00d009.github.io/productores-sanjose/](https://ea00d009.github.io/productores-sanjose/) |
| 📍 **Mapa Productivo** | Visor cartográfico georreferenciado con Leaflet.js | [ea00d009.github.io/productores-sanjose/mapa.html](https://ea00d009.github.io/productores-sanjose/mapa.html) |
| 🛍️ **Catálogo de Negocios** | Directorio de productores con filtros y enlace a mapa | [ea00d009.github.io/productores-sanjose/catalogo.html](https://ea00d009.github.io/productores-sanjose/catalogo.html) |
| 🛒 **Encontrá la Góndola** | Red de comercialización en comercios y supermercados | [ea00d009.github.io/productores-sanjose/gondola.html](https://ea00d009.github.io/productores-sanjose/gondola.html) |
| 📝 **Inscribí tu Negocio** | Formulario digital en 4 pasos para registro continuo | [ea00d009.github.io/productores-sanjose/inscribir.html](https://ea00d009.github.io/productores-sanjose/inscribir.html) |
| 📄 **Informe Oficial HCD** | Documento técnico-legislativo con salida membretada A4/PDF | [ea00d009.github.io/productores-sanjose/informe.html](https://ea00d009.github.io/productores-sanjose/informe.html) |

---

## 🎯 Objetivos Estratégicos del Programa

1. **Articulación Turismo + Producción Autóctona:** Visibilizar a micro y medianos productores (agroecología, nuez pecán, licores artesanales centenarios, apicultura nativa, queserías de colonia y cuchillería entrerriana) para que turistas y vecinos accedan a productos con sello de identidad de origen.
2. **Georreferenciación Precisa:** Ubicación exacta de cada establecimiento en el ejido urbano y colonias aledañas con coordenadas satelitales comprobadas.
3. **Comercialización Directa sin Intermediarios:** Enlace instantáneo a WhatsApp con mensaje personalizado y botón de ruta guiada paso a paso mediante GPS (Google Maps).
4. **Soberanía y Ahorro Tecnológico:** Construido con tecnologías de código abierto (**Leaflet.js** y **OpenStreetMap**), sin costos recurrentes de licencias ni consumo de cuotas de APIs privativas.
5. **Elevación y Respaldo Institucional:** Módulo integrado para la generación formal del expediente e informe membretado para tratamiento legislativo en el Honorable Concejo Deliberante.

---

## 🧭 Estructura Modular del Repositorio

El proyecto está diseñado bajo una arquitectura desacoplada y estática (JAMstack Vanilla), facilitando su inserción en cualquier CMS (WordPress, Elementor) o portal gubernamental sin dependencias de backend pesadas:

```
productores-sanjose/
├── index.html            # Portal principal con grilla institucional Hecho en San José
├── mapa.html             # Visor cartográfico interactivo full-width con panel lateral
├── catalogo.html         # Directorio completo de productores con buscador y filtros
├── gondola.html          # Puntos de venta del programa "Góndolas Hecho en San José"
├── inscribir.html        # Formulario interactivo en 4 fases para registro de productores
├── informe.html          # Informe técnico-legislativo para el HCD con exportación A4/PDF
├── style.css             # Sistema de diseño integral (tokens, modo oscuro, responsive y print)
├── app.js                # Lógica del mapa Leaflet, datos georreferenciados y sincronización
├── assets/
│   ├── logo-sanjose.png  # Isologotipo oficial de la Municipalidad de San José
│   ├── qr-plataforma.svg # Código QR oficial vectorial para escaneo en sesiones del HCD
│   └── productores/      # Fotografías auténticas y representativas de los 11 productores
│       ├── apicola-la-sanjosesina.jpg
│       ├── artesanias-el-palmar.jpg
│       ├── bodega-vulliez-sermet.jpg
│       ├── cerveceria-el-molino.jpg
│       ├── dulces-la-juanita.jpg
│       ├── establecimiento-los-pecanes.jpg
│       ├── granja-la-administracion.jpg
│       ├── licores-bard.jpg
│       ├── nuez-pecan-la-reina.jpg
│       ├── sanjo-tradicion-cuchilleria.jpg
│       └── troncos-petrificados.jpg
├── .github/
│   └── workflows/
│       └── deploy.yml    # Pipeline CI/CD automático de despliegue a GitHub Pages (gh-pages)
└── README.md             # Documentación exhaustiva del proyecto en español
```

---

## 💻 Funcionalidades Detalladas por Módulo

### 1. Portal Principal (`index.html`)
- **Cabecera Institucional:** Isologotipo oficial municipal, enlaces minimalistas a redes (Instagram y Facebook) y conmutador de modo oscuro con efecto cero parpadeo (Zero FOUC).
- **Hero de Impacto Turístico:** Métricas en tiempo real (+45 productores relevados, 4 góndolas activas, 100% identidad local).
- **Tarjeta de Elevación HCD:** Recuadro institucional exclusivo para los integrantes del Concejo Deliberante con botón de acción directo hacia `informe.html`.
- **Grilla de Navegación de Servicios:**
  - *Catálogo de Negocios* (acceso al padrón con filtros).
  - *Encontrá la Góndola* (localización de puntos de venta urbanos).
  - *Inscribí tu Negocio* (formulario de adhesión municipal).
  - *Mapa Productivo* (**Recuadro destacado** con distintivo animado `¡NUEVO!`).
- **Pie de Página Institucional:** Respaldo de la Secretaría de Educación, Cultura y Turismo y datos de contacto oficiales.

---

### 2. Visor Cartográfico Interactivo (`mapa.html` & `app.js`)
- **Centro Cartográfico Estratégico:** Centrado en Plaza General Urquiza (`-32.2123, -58.2191`), corazón cívico de San José.
- **Pines Temáticos SVG (DivIcon):** Cada categoría dispone de un color e iconografía vectorial distintiva:
  - *Pecán & Agro:* Verde esmeralda (`#059669`)
  - *Bebidas & Licores:* Púrpura artesanal (`#7c3aed`)
  - *Miel & Conservas:* Ámbar cálido (`#d97706`)
  - *Artesanías & Minerales:* Rubí / Rosa acento (`#be123c`)
- **Popups Interactivos Ricos:**
  - Fotografía del establecimiento.
  - Título, especialidad y horario de atención.
  - Botón directo de **WhatsApp** con saludo personalizado.
  - Botón **Cómo llegar** integrado con la API de rutas de Google Maps.
- **Sincronización Bidireccional:**
  - Al hacer clic en una tarjeta del panel lateral, el mapa se desplaza suavemente (`flyTo`) y abre el popup.
  - Al seleccionar un pin en el mapa, la tarjeta correspondiente en el sidebar se resalta (`.selected`) y se desplaza automáticamente a la vista del usuario (`scrollIntoView`).
- **Navegación Cruzada vía URL (`?id=X`):** Soporta parámetros en la query string (ej. `mapa.html?id=2`), permitiendo que enlaces desde el catálogo o códigos QR abran directamente al productor enfocado.
- **Buscador Predictivo en Tiempo Real:** Filtrado simultáneo sobre el panel y los marcadores por nombre, rubro o calle.
- **Filtros por Rubro (Chips):** Selección instantánea de categorías (*Pecán, Bebidas, Alimentos, Artesanías*).
- **Herramienta "Centrar todo":** Botón de reinicio que recalcula los límites de todos los marcadores (`fitBounds`).
- **Modo Móvil con Pestañas (Tabs):** En pantallas pequeñas, el usuario alterna fluidamente entre la vista de mapa y la lista de establecimientos.

---

### 3. Catálogo de Negocios (`catalogo.html`)
- **Grilla Visual Responsiva:** Tarjetas de diseño premium con fotografías panorámicas 16:9 y badges de rubro.
- **Buscador en Vivo y Filtros:** Búsqueda combinada por texto libre y chips de rubro con contadores numéricos actualizados en tiempo real.
- **Doble Llamada a la Acción (CTA):**
  - Botón verde de contacto directo por WhatsApp.
  - Botón **"Ver en Mapa"** con enlace paramétrico (`mapa.html?id=${p.id}`) que transporta al usuario a la ubicación geográfica exacta.

---

### 4. Red de Góndolas Municipales (`gondola.html`)
- **Puntos de Venta Urbanos:** Muestra los 4 comercios y supermercados que disponen de la góndola física exclusiva con productos locales:
  1. *Supermercado San José* (Av. Centenario 1240).
  2. *Autoservicio Colón* (Urquiza 850).
  3. *Almacén de Sabores* (9 de Julio 1420).
  4. *Despensa El Molino* (Acceso Bastidas s/n, RP 130).
- **Detalle de Comercialización:** Ficha técnica de cada punto con dirección, horarios de atención, stock de productos disponibles y botón de ruta GPS.
- **Sección de Adhesión para Comerciantes:** Beneficios e invitación para sumar nuevos comercios al programa como *"Comercio Amigo de la Producción Local"*.

---

### 5. Formulario de Inscripción (`inscribir.html`)
- **Estructura Guiada en 4 Pasos:**
  1. *Paso 1: Datos del Titular* (Nombre, DNI/CUIT, teléfono y correo).
  2. *Paso 2: Datos del Emprendimiento* (Razón social, domicilio físico, coordenadas estimadas y horarios de atención).
  3. *Paso 3: Rubro y Capacidad Productiva* (Selección de rubro, descripción de productos y habilitaciones).
  4. *Paso 4: Canales de Comercialización* (Venta al público, visitas guiadas, interés en góndolas municipales y redes sociales).
- **Validación y Feedback Inmediato:** Confirmación visual sin recarga de página tras el envío satisfactorio.

---

### 6. Módulo de Informe para el Concejo Deliberante (`informe.html`)
- **Diseño Editorial Gubernamental:** Aspecto de expediente formal con membrete del Municipio de San José y distinción del *Honorable Concejo Deliberante (Período Legislativo 2026)*.
- **Cuadro de Metadatos Legislativos:** Número de expediente (`2026-PSJ-044-PROD`), iniciador, destinatario, fecha de elevación y estado en comisión.
- **Diagnóstico y Balance Cuantitativo:** Síntesis del impacto territorial, fomento del arraigo y soberanía tecnológica.
- **Padrón Formal de Productores:** Tabla detallada de los 11 establecimientos con fotos, coordenadas catastrales y vías de contacto.
- **Barra de Control de Visualización:**
  - Filtros de vista rápida (*Informe Completo*, *Solo Padrón*, *Anteproyecto*).
  - Conmutador para mostrar u ocultar fotografías en la tabla (ideal para ahorro de tinta en impresiones monocromáticas).
  - Botón de alternancia de tema claro/oscuro.
- **Código QR Vectorial Integrado:** Gráfico SVG de alta definición (`assets/qr-plataforma.svg`) listo para ser escaneado por los concejales en papel durante las sesiones.
- **Anteproyecto de Ordenanza Municipal:** Articulado modelo con Visto, Considerando y 5 Artículos (Declaración de Interés, señalética vial unificada en RP 26, RP 130 y RN 14, y prioridad en ferias).
- **Protocolo de Rúbricas:** Bloque de firmas para la Secretaría de Turismo, Departamento Ejecutivo Municipal y Presidencia del H.C.D.
- **Salida para Impresión / Exportación a PDF (A4):** Suite completa de estilos `@media print` que oculta barras de navegación, ajusta márgenes a hoja A4 y previene cortes indebidos en tablas o firmas.

---

## 🌰 Padrón Oficial de los 11 Productores Georreferenciados

| N° | Establecimiento | Rubro / Especialidad | Categoría | Ubicación Catastral | Coordenadas Satelitales |
| :-: | :--- | :--- | :--- | :--- | :--- |
| **01** | **Licores Bard** | Licores Tradicionales (Desde 1908) | Bebidas | Entre Ríos 1046 (e/ 3 de Febrero y Caseros) | `-32.20780, -58.22510` |
| **02** | **Establecimiento Los Pecanes** | Plantación Pionera, Casa de Té y Patio | Pecán & Té | Ruta Prov. 26 (RP 130) Km. 7 | `-32.20350, -58.20320` |
| **03** | **De los Troncos Petrificados** | Reserva Natural, Maderas y Minerales | Artesanías | RP 26 Km. 3,5 (B° Troncos Petrificados) | `-32.19801, -58.15484` |
| **04** | **Artesanías El Palmar** | Cestería en Palma Yatay y Mates Orgánicos | Artesanías | Ruta Nacional 14 Km. 158,5, Colonia San José | `-32.19409, -58.23921` |
| **05** | **Nuez Pecán La Reina** | Boutique del Pecán (Sello Turismo Industrial) | Pecán | Doctor Luis Cettour, San José | `-32.20277, -58.20241` |
| **06** | **Apícola La Sanjosesina** | Miel Pura de Monte Nativo y Propóleo | Alimentos | Centenario 1580 (e/ Ituzaingó y Yrigoyen) | `-32.20950, -58.21620` |
| **07** | **Granja La Administración** | Quesería Tradicional junto al Molino Forclaz | Alimentos | Camino de los Primeros Colonos s/n | `-32.18890, -58.21450` |
| **08** | **Dulces Caseros La Juanita** | Mermeladas en Paila de Cobre (Frente a Plaza) | Alimentos | Urquiza 1127 (frente al Museo Histórico) | `-32.21280, -58.21850` |
| **09** | **Viñedos & Bodega Vulliez Sermet** | Enoturismo, Viñedos Históricos y Varietales | Bebidas | Ruta Nacional 135 Km. 8, Colón - San José | `-32.22150, -58.17890` |
| **10** | **Cervecería Artesanal El Molino** | Microcervecería con Maltas Entrerrianas | Bebidas | Centenario 1361 (Zona Céntrica) | `-32.21110, -58.21780` |
| **11** | **Cuchillería Sanjo Tradición** | Forja Criolla en Acero y Platería Tradicional | Artesanías | Mitre 1150 (frente a Plaza Urquiza) | `-32.21200, -58.21950` |

---

## 🎨 Sistema de Diseño (Design System) y Accesibilidad (WCAG 2.1 AA)

- **Escala de Espaciado:** Cuadrícula estricta de 4 y 8 píxeles (`--space-1: 4px` hasta `--space-16: 64px`).
- **Tipografías:**
  - *Títulos y Display:* `Outfit` (sans-serif contemporánea y de gran personalidad).
  - *Cuerpo y Datos:* `Plus Jakarta Sans` (diseñada para legibilidad óptima en interfaces digitales).
- **Paleta Cromática Semántica:**
  - *Primario (Turismo San José):* `#0077b6` (Modo claro) / `#38bdf8` (Modo oscuro).
  - *Acento Identitario:* `#c92a48` (Modo claro) / `#fb7185` (Modo oscuro).
  - *Secundario (Pecán & Agroecología):* `#059669` (Modo claro) / `#34d399` (Modo oscuro).
- **Cumplimiento WCAG 2.1 Nivel AA:**
  - Ratios de contraste superiores a **4.5:1** en textos principales y badges temáticos.
  - Indicador de foco visible universal (`:focus-visible`) para navegación integral mediante teclado accesible.
  - Áreas táctiles mínimas de **44 × 44 px** para dispositivos móviles y pantallas táctiles (`@media (pointer: coarse)`).
  - Soporte de reducción de animaciones para usuarios con sensibilidad vestibular (`prefers-reduced-motion`).
- **Zero FOUC (Sin Parpadeo):** Script síncrono al inicio del `<head>` que previene el destello blanco al cargar la página en modo oscuro, sincronizado con las preferencias del sistema y persistido en `localStorage`.

---

## 🚀 Puesta en Marcha Local

Para ejecutar el proyecto en un entorno local sin dependencias pesadas:

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/ea00d009/productores-sanjose.git
   cd productores-sanjose
   ```

2. **Iniciar un servidor HTTP estático:**
   - Mediante Python:
     ```bash
     python -m http.server 8080
     ```
   - O mediante Node.js:
     ```bash
     npx serve .
     ```

3. **Abrir en el navegador:**
   Ingresar a `http://localhost:8080` (o el puerto indicado por la terminal).

---

## 🏛️ Créditos Institucionales

- **Iniciativa:** Secretaría de Educación, Cultura y Turismo &bull; Municipalidad de San José, Entre Ríos.
- **Destinatario:** Honorable Concejo Deliberante de la Ciudad de San José.
- **Año:** 2026.
- **Licencia:** Proyecto institucional y de código abierto para fomento del desarrollo local.

