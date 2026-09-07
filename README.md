# Hecho en San José &bull; Mapa Productivo de la Ciudad

Plataforma interactiva y maqueta funcional para la integración del sector productivo local en el portal turístico oficial [sanjose.tur.ar/hechoensanjose](https://sanjose.tur.ar/hechoensanjose/), diseñada como propuesta de desarrollo económico y turístico para ser presentada ante el **Honorable Concejo Deliberante de la Ciudad de San José, Entre Ríos, Argentina**.

🌐 **Sitio web en vivo (GitHub Pages):** [https://ea00d009.github.io/productores-sanjose/](https://ea00d009.github.io/productores-sanjose/)  
📍 **Destino directo al Mapa Interactivo:** [https://ea00d009.github.io/productores-sanjose/mapa.html](https://ea00d009.github.io/productores-sanjose/mapa.html)

---

## 🎯 Objetivos de la Propuesta

- **Articulación Turismo + Producción:** Visibilizar a pequeños y medianos productores (agroecología, nuez pecán, cerveza artesanal, miel, queserías y cuchillería entrerriana) para que turistas y vecinos accedan a productos con identidad de origen.
- **Georreferenciación Precisa:** Ubicación en tiempo real de cada establecimiento en el plano de la ciudad y colonias aledañas.
- **Contacto Directo:** Enlace inmediato a WhatsApp para consultar disponibilidad y botón "Cómo llegar" integrado con el GPS de Google Maps.
- **Soberanía y Ahorro Tecnológico:** Construido con tecnologías libres (**Leaflet.js** y **OpenStreetMap**), sin costos de suscripción ni consumo de cuotas de APIs pagas.

---

## 🧭 Estructura del Proyecto

El repositorio está organizado de forma desacoplada y modular para facilitar su incorporación a cualquier entorno web o CMS (ej. WordPress / Elementor):

```
productores-sanjose/
├── index.html          # Página principal con grilla institucional y recuadro destacado
├── mapa.html           # Subpágina interactiva con doble panel (lista + mapa)
├── style.css           # Sistema de diseño, variables de color y estilos responsivos
├── app.js              # Lógica de Leaflet.js, marcadores, popups y filtros dinámicos
├── .github/
│   └── workflows/
│       └── deploy.yml  # Automatización de despliegue continuo en GitHub Pages
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
- **Centro geográfico:** San José, Entre Ríos (`-32.2025, -58.2215`).
- **Pines personalizados:** Iconografía SVG temática con color según rubro.
- **Popups interactivos:** Información detallada del productor, horarios, botón directo de WhatsApp y trazado de ruta en Google Maps.
- **Sincronización:** Hacer clic en un productor de la lista enfoca suavemente el mapa (`flyTo`) y despliega su popup.
- **Filtros por Rubro:** Selección por categorías (*Pecán, Cerveza, Miel/Conservas, Artesanías*).
- **Búsqueda en Tiempo Real:** Filtrado predictivo por nombre, rubro o dirección.

---

## 🌰 Productores Locales de Prueba

1. **Nueces del Río Uruguay - Finca La Casona** (Agroecología & Pecán &bull; Camino Vecinal a 1° de Mayo)
2. **Cervecería Artesanal El Molino** (Cerveza artesanal &bull; Urquiza y Centenario)
3. **Conservas & Miel Los Abuelos de la Colonia** (Miel de pradera y dulces típicos &bull; Calle 9 de Julio 1420)
4. **Cuchillería & Talabartería Sanjo Tradición** (Artesanías en acero y cuero &bull; Mitre 1150)
5. **Quesería & Granja La Suiza de Entre Ríos** (Lácteos coloniales &bull; Acceso Dr. Bastian 830)

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
