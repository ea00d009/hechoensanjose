# Hecho en San José &bull; Mapa Productivo de la Ciudad

Plataforma interactiva y maqueta funcional para la integración del sector productivo local en el portal turístico oficial [sanjose.tur.ar/hechoensanjose](https://sanjose.tur.ar/hechoensanjose/), diseñada como propuesta de desarrollo económico y turístico para ser presentada ante el **Honorable Concejo Deliberante de la Ciudad de San José, Entre Ríos, Argentina**.

🌐 **Sitio web en vivo (GitHub Pages):** [https://ea00d009.github.io/productores-sanjose/](https://ea00d009.github.io/productores-sanjose/)  
📍 **Mapa Productivo Interactivo:** [https://ea00d009.github.io/productores-sanjose/mapa.html](https://ea00d009.github.io/productores-sanjose/mapa.html)  
🛍️ **Catálogo de Negocios:** [https://ea00d009.github.io/productores-sanjose/catalogo.html](https://ea00d009.github.io/productores-sanjose/catalogo.html)  
🛒 **Encontrá la Góndola:** [https://ea00d009.github.io/productores-sanjose/gondola.html](https://ea00d009.github.io/productores-sanjose/gondola.html)  
📝 **Inscribí tu Negocio:** [https://ea00d009.github.io/productores-sanjose/inscribir.html](https://ea00d009.github.io/productores-sanjose/inscribir.html)  
🏛️ **Informe Oficial HCD (PDF A4):** [https://ea00d009.github.io/productores-sanjose/informe.html](https://ea00d009.github.io/productores-sanjose/informe.html)

---

## 🎯 Objetivos de la Propuesta

- **Articulación Turismo + Producción:** Visibilizar a pequeños y medianos productores (agroecología, nuez pecán, cerveza artesanal, miel, queserías y cuchillería entrerriana) para que turistas y vecinos accedan a productos con identidad de origen.
- **Georreferenciación Precisa:** Ubicación en tiempo real de cada establecimiento en el plano de la ciudad y colonias aledañas.
- **Contacto Directo:** Enlace inmediato a WhatsApp para consultar disponibilidad y botón "Cómo llegar" integrado con el GPS de Google Maps.
- **Soberanía y Ahorro Tecnológico:** Construido con tecnologías libres (**Leaflet.js** y **OpenStreetMap**), sin costos de suscripción ni consumo de cuotas de APIs pagas.
- **Elevación Institucional:** Generación automática de informe técnico-legislativo membretado y exportable en formato A4 / PDF para el Honorable Concejo Deliberante.

---

## 🧭 Estructura del Proyecto

El repositorio está organizado de forma desacoplada y modular para facilitar su incorporación a cualquier entorno web o CMS (ej. WordPress / Elementor):

```
productores-sanjose/
├── index.html          # Portal principal con grilla institucional Hecho en San José
├── catalogo.html       # Catálogo completo de productores con buscador y filtros
├── gondola.html        # Puntos de venta del programa "Góndolas Hecho en San José"
├── inscribir.html      # Formulario interactivo en 4 pasos para registro de productores
├── informe.html        # Documento técnico-legislativo HCD con salida membretada A4/PDF
├── mapa.html           # Subpágina interactiva con mapa Leaflet.js y panel lateral
├── style.css           # Sistema de diseño integral, variables y estilos de impresión A4
├── app.js              # Lógica del mapa Leaflet, datos de productores y filtros
├── assets/
│   ├── logo-sanjose.png # Isologotipo oficial de la Municipalidad de San José
│   ├── qr-plataforma.svg # Código QR vectorial para escaneo en sesión del HCD
│   └── productores/    # Fotografías auténticas de los 11 productores locales
├── .github/
│   └── workflows/
│       └── deploy.yml  # Automatización de despliegue continuo en GitHub Pages (gh-pages)
└── README.md           # Documentación general del proyecto en español
```

---

## 💻 Características Técnicas

### 1. Componente UI: Grilla de Navegación (`index.html`)
- Replica la estructura del portal de turismo con los botones existentes:
  - **Catálogo de Negocios**
  - **Encontrá la Góndola**
  - **Inscribí tu Negocio**
- **Nuevo Recuadro Destacado:** *"Mapa productivo de la ciudad de San José"* con distintivo animado `¡NUEVO!`, microanimación hover e interactividad accesible.

### 2. Visor Cartográfico Interactivo (`mapa.html` & `app.js`)
- **Centro geográfico:** San José, Entre Ríos (`-32.2123, -58.2191` &bull; Plaza General Urquiza).
- **Pines personalizados:** Iconografía SVG temática con color según rubro.
- **Popups interactivos:** Información detallada del productor, horarios, botón directo de WhatsApp y trazado de ruta en Google Maps.
- **Sincronización:** Hacer clic en un productor de la lista enfoca suavemente el mapa (`flyTo`) y despliega su popup.
- **Filtros por Rubro:** Selección por categorías (*Pecán, Cerveza, Miel/Conservas, Artesanías*).
- **Búsqueda en Tiempo Real:** Filtrado predictivo por nombre, rubro o dirección.

---

## 🌰 Productores Locales Georreferenciados (11 Establecimientos)

### Solicitados:
1. **Licores Bard** &bull; *Licores Artesanales desde 1908* (Entre Ríos 1046 e/ 3 de Febrero y Caseros)
2. **Establecimiento Los Pecanes** &bull; *Plantación, Casa de Té y Patio Cervecero* (Ruta 26 / RP 130 Km. 7)
3. **De los Troncos Petrificados** &bull; *Piedras Semipreciosas del Río Uruguay y Maderas Petrificadas* (Ruta Prov. 26 Km. 3,5, Barrio Troncos Petrificados)
4. **Artesanías El Palmar** &bull; *Cestería en fibra de palma yatay, mates orgánicos y obras tradicionales* (Ruta Nacional 14 Km. 158,5, Colonia San José)

### Investigados e Incorporados del Ecosistema Turístico:
5. **Nuez Pecán La Reina** &bull; *Establecimiento Los Pecanes - La Boutique de la Nuez Pecán, Sello de Turismo Industrial y Productivo* (Doctor Luis Cettour)
6. **Apícola La Sanjosesina** &bull; *Miel pura de monte nativo, polen y propóleo artesanal* (Centenario 1580 e/ Ituzaingó y Yrigoyen)
7. **Granja y Museo Histórico La Administración** &bull; *Quesería tradicional, chacinados y picadas coloniales* (Camino de los Primeros Colonos s/n, junto al Molino Forclaz)
8. **Dulces Caseros La Juanita** &bull; *Mermeladas de higo, naranja amarga y yatay en paila de cobre* (Urquiza 1127, frente a Plaza Urquiza / Museo)
9. **Viñedos & Bodega Vulliez Sermet** &bull; *Enoturismo, viñedos históricos y vinos varietales* (Ruta Nacional 135 Km 8)
10. **Cervecería Artesanal El Molino** &bull; *Microcervecería con maltas entrerrianas y estilos premiados* (Centenario 1361, Zona Céntrica)
11. **Cuchillería & Talabartería Sanjo Tradición** &bull; *Cuchillos forjados a mano en acero y platería criolla* (Mitre 1150, frente a Plaza Urquiza)

---

## 🚀 Puesta en Marcha Local

Para probar el proyecto localmente sin necesidad de instalar dependencias pesadas:

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/ea00d009/productores-sanjose.git
   cd productores-sanjose
   ```

2. Iniciar un servidor web estático sencillo:
   - Con Python:
     ```bash
     python -m http.server 8080
     ```
   - O con Node.js / NPX:
     ```bash
     npx serve .
     ```

3. Abrir en el navegador:
   `http://localhost:8080`

---

## 🏛️ Créditos y Presentación Institucional

- **Iniciativa:** Secretaría de Educación, Cultura y Turismo &bull; Municipalidad de San José, Entre Ríos.
- **Ámbito:** Maqueta de presentación oficial para el Honorable Concejo Deliberante.
- **Año:** 2026.
