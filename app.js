/**
 * ==========================================================================
 * HECHO EN SAN JOSÉ - LÓGICA DEL MAPA INTERACTIVO (Leaflet.js)
 * Maqueta Funcional para el Honorable Concejo Deliberante
 * Ciudad de San José, Entre Ríos, Argentina
 * ==========================================================================
 */

// 1. Datos Georreferenciados de Productores Locales de San José
const PRODUCTORES_SAN_JOSE = [
  {
    id: 1,
    nombre: "Nueces del Río Uruguay - Finca La Casona",
    rubro: "Agroecología & Frutos Secos",
    categoria: "pecan",
    tagLabel: "Pecán & Agroecología",
    tagClass: "tag-pecan",
    pinColor: "#059669",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>`,
    coords: [-32.1935, -58.2140],
    direccion: "Camino Vecinal a Primero de Mayo km 2.5",
    telefono: "+54 9 3447 45-1122",
    whatsapp: "5493447451122",
    horario: "Lun a Sáb: 09:00 a 18:00 hs",
    descripcion: "Producción agroecológica de nuez pecán sanjosesina, pelada en mitades, nueces caramelizadas, harinas proteicas y aceites prensados en frío. Pioneros en la colonia.",
    destacado: true
  },
  {
    id: 2,
    nombre: "Cervecería Artesanal El Molino",
    rubro: "Cervecería & Bebidas",
    categoria: "cerveza",
    tagLabel: "Cerveza Artesanal",
    tagClass: "tag-cerveza",
    pinColor: "#d97706",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 11h1a3 3 0 0 1 0 6h-1"/><path d="M9 12v6"/><path d="M13 12v6"/><path d="M14 7.5c-1 0-1.44.5-3 .5s-2-.5-3-.5-1.72.5-2.5.5a2.5 2.5 0 0 1 0-5c.78 0 1.57.5 2.5.5s1.44-.5 3-.5 2 .5 3 .5 1.72-.5 2.5-.5a2.5 2.5 0 0 1 0 5c-.78 0-1.5-.5-2.5-.5Z"/><path d="M5 8v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8"/></svg>`,
    coords: [-32.2045, -58.2225],
    direccion: "Urquiza y Centenario, San José",
    telefono: "+54 9 3447 48-3344",
    whatsapp: "5493447483344",
    horario: "Mié a Dom: 18:00 a 01:00 hs",
    descripcion: "Microcervecería local con maltas entrerrianas y aguas puras de vertiente. Estilos galardonados: Dorada Pampeana, Honey con miel isleña y Red Ale con carácter.",
    destacado: true
  },
  {
    id: 3,
    nombre: "Conservas & Miel Los Abuelos de la Colonia",
    rubro: "Conservas & Alimentos Caseros",
    categoria: "conservas",
    tagLabel: "Miel & Conservas",
    tagClass: "tag-conservas",
    pinColor: "#7c3aed",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8"/><path d="M9 2v3"/><path d="M15 2v3"/><rect width="14" height="15" x="5" y="5" rx="3"/><path d="M5 10h14"/></svg>`,
    coords: [-32.2082, -58.2178],
    direccion: "Calle 9 de Julio 1420",
    telefono: "+54 9 3447 51-2288",
    whatsapp: "5493447512288",
    horario: "Lun a Vie: 08:30 a 12:30 y 16:30 a 20:00 hs",
    descripcion: "Miel pura de pradera y eucalipto, mermeladas de higo y naranja amarga sin aditivos, escabeches tradicionales y licores artesanales con recetas centenarias de la inmigración.",
    destacado: false
  },
  {
    id: 4,
    nombre: "Cuchillería & Talabartería Sanjo Tradición",
    rubro: "Artesanías & Tradición Criolla",
    categoria: "artesania",
    tagLabel: "Artesanías & Cuero",
    tagClass: "tag-artesania",
    pinColor: "#e54260",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>`,
    coords: [-32.2018, -58.2260],
    direccion: "Mitre 1150 (Frente a Plaza Urquiza)",
    telefono: "+54 9 3447 43-9911",
    whatsapp: "5493447439911",
    horario: "Lun a Sáb: 09:00 a 13:00 y 17:00 a 20:30 hs",
    descripcion: "Cuchillos de acero al carbono forjados a mano con cabos de guayacán, asta de ciervo y alpaca. Trabajos a medida en cuero crudo sobado y platería entrerriana.",
    destacado: true
  },
  {
    id: 5,
    nombre: "Quesería & Granja La Suiza de Entre Ríos",
    rubro: "Lácteos & Chacinados Artesanales",
    categoria: "conservas",
    tagLabel: "Quesos & Lácteos",
    tagClass: "tag-conservas",
    pinColor: "#0284c7",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>`,
    coords: [-32.1970, -58.2285],
    direccion: "Acceso Dr. Bastian 830",
    telefono: "+54 9 3447 47-8890",
    whatsapp: "5493447478890",
    horario: "Todos los días de 08:00 a 13:00 hs",
    descripcion: "Elaboración de quesos gouda, sardo de campo, ricota artesanal y provoletas condimentadas con hierbas autóctonas, manteniendo el legado quesero de la Colonia San José.",
    destacado: false
  }
];

// 2. Estado Global de la Aplicación
let mapInstance = null;
let markerLayerGroup = null;
let currentFilter = 'todos';
let searchQuery = '';
const markerMap = new Map(); // id -> L.marker

// 3. Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
  initMap();
  renderProducersList();
  setupFilterListeners();
  setupSearchListener();
});

/**
 * Inicializa el Mapa Leaflet centrado en San José, Entre Ríos
 */
function initMap() {
  const mapElement = document.getElementById('map');
  if (!mapElement) return;

  // Coordenadas céntricas de San José, Entre Ríos (Plaza Gral. Urquiza / Zona Urbana)
  const SAN_JOSE_CENTER = [-32.2025, -58.2215];
  const INITIAL_ZOOM = 14;

  // Instanciar mapa
  mapInstance = L.map('map', {
    center: SAN_JOSE_CENTER,
    zoom: INITIAL_ZOOM,
    zoomControl: false,
    attributionControl: true
  });

  // Control de zoom en la esquina superior derecha para no tapar el panel lateral
  L.control.zoom({ position: 'topright' }).addTo(mapInstance);

  // Capa base: OpenStreetMap estándar con alta definición
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors | Hecho en San José'
  }).addTo(mapInstance);

  // Grupo de marcadores
  markerLayerGroup = L.layerGroup().addTo(mapInstance);

  // Renderizar marcadores iniciales
  updateMarkers();
}

/**
 * Crea un Marcador HTML personalizado (DivIcon) con diseño de pin moderno
 */
function createCustomPin(productor) {
  const html = `
    <div class="custom-pin-marker" data-id="${productor.id}">
      <div class="pin-bubble" style="background-color: ${productor.pinColor}; color: ${productor.pinColor};">
        ${productor.iconoSvg}
      </div>
    </div>
  `;

  return L.divIcon({
    html: html,
    className: 'leaflet-custom-div-icon',
    iconSize: [38, 48],
    iconAnchor: [19, 46],
    popupAnchor: [0, -42]
  });
}

/**
 * Genera el contenido HTML interactivo del Popup para cada productor
 */
function createPopupContent(p) {
  const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${p.coords[0]},${p.coords[1]}`;
  const whatsappMsg = encodeURIComponent(`Hola! Los contacto a través del Mapa Productivo "Hecho en San José" (Turismo). Me gustaría consultar sobre sus productos.`);
  const whatsappUrl = `https://wa.me/${p.whatsapp}?text=${whatsappMsg}`;

  return `
    <div class="popup-card">
      <div class="popup-header">
        <span class="category-tag ${p.tagClass}">${p.tagLabel}</span>
      </div>
      <h4 class="popup-title">${p.nombre}</h4>
      <p class="popup-desc">${p.descripcion}</p>
      
      <div class="popup-details">
        <div class="detail-row">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
          </svg>
          <span><strong>Dirección:</strong> ${p.direccion}</span>
        </div>
        <div class="detail-row">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
          </svg>
          <span>${p.horario}</span>
        </div>
      </div>

      <div class="popup-actions">
        <a href="${whatsappUrl}" target="_blank" rel="noopener" class="btn-popup-action btn-whatsapp">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>
          <span>WhatsApp</span>
        </a>
        <a href="${googleMapsUrl}" target="_blank" rel="noopener" class="btn-popup-action btn-directions">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polygon points="3 11 22 2 13 21 11 13 3 11"/>
          </svg>
          <span>Cómo llegar</span>
        </a>
      </div>
    </div>
  `;
}

/**
 * Filtra los datos según la categoría y el texto de búsqueda
 */
function getFilteredProducers() {
  return PRODUCTORES_SAN_JOSE.filter(p => {
    const matchCategory = currentFilter === 'todos' || p.categoria === currentFilter;
    const query = searchQuery.trim().toLowerCase();
    const matchSearch = query === '' || 
      p.nombre.toLowerCase().includes(query) || 
      p.rubro.toLowerCase().includes(query) || 
      p.descripcion.toLowerCase().includes(query) ||
      p.direccion.toLowerCase().includes(query);

    return matchCategory && matchSearch;
  });
}

/**
 * Actualiza los marcadores en el mapa interactivo
 */
function updateMarkers() {
  if (!mapInstance || !markerLayerGroup) return;

  markerLayerGroup.clearLayers();
  markerMap.clear();

  const filtered = getFilteredProducers();
  const bounds = [];

  filtered.forEach(productor => {
    const pinIcon = createCustomPin(productor);
    const marker = L.marker(productor.coords, { icon: pinIcon });
    
    // Popup
    marker.bindPopup(createPopupContent(productor), {
      maxWidth: 320,
      className: 'custom-leaflet-popup'
    });

    // Evento al abrir popup: sincronizar selección en la barra lateral
    marker.on('click', () => {
      selectProducerInList(productor.id);
    });

    markerLayerGroup.addLayer(marker);
    markerMap.set(productor.id, marker);
    bounds.push(productor.coords);
  });

  // Ajustar vista si hay marcadores y el usuario no está en zoom manual estricto
  if (bounds.length > 0) {
    const latLngBounds = L.latLngBounds(bounds);
    mapInstance.fitBounds(latLngBounds, { padding: [50, 50], maxZoom: 15 });
  }
}

/**
 * Renderiza la lista de productores en el panel lateral
 */
function renderProducersList() {
  const container = document.getElementById('producers-list');
  const countBadge = document.getElementById('producers-counter');
  if (!container) return;

  const filtered = getFilteredProducers();

  if (countBadge) {
    countBadge.textContent = `${filtered.length} ${filtered.length === 1 ? 'productor' : 'productores'}`;
  }

  if (filtered.length === 0) {
    container.innerHTML = `
      <div style="text-align: center; padding: 2.5rem 1rem; color: #94a3b8;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 0.5rem; opacity: 0.7;">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <p style="font-size: 0.95rem; font-weight: 600; color: #475569;">No se encontraron productores</p>
        <p style="font-size: 0.8rem;">Intenta con otro rubro o término de búsqueda.</p>
      </div>
    `;
    return;
  }

  container.innerHTML = filtered.map(p => `
    <article class="producer-item-card" data-id="${p.id}" id="card-item-${p.id}" onclick="focusProducer(${p.id})">
      <div class="item-badge-row">
        <span class="category-tag ${p.tagClass}">${p.tagLabel}</span>
        ${p.destacado ? '<span style="font-size: 0.7rem; font-weight: 700; color: #d97706;">★ Destacado</span>' : ''}
      </div>
      <h4 class="producer-name">${p.nombre}</h4>
      <p class="producer-desc">${p.descripcion}</p>
      <div class="producer-address">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
        </svg>
        <span>${p.direccion}</span>
      </div>
    </article>
  `).join('');
}

/**
 * Centra el mapa en el productor seleccionado y abre su popup
 */
function focusProducer(id) {
  selectProducerInList(id);

  const marker = markerMap.get(id);
  const productor = PRODUCTORES_SAN_JOSE.find(p => p.id === id);

  if (marker && productor && mapInstance) {
    mapInstance.flyTo(productor.coords, 16, {
      animate: true,
      duration: 1.0
    });

    setTimeout(() => {
      marker.openPopup();
    }, 400);
  }
}

/**
 * Resalta visualmente la tarjeta en el panel lateral
 */
function selectProducerInList(id) {
  document.querySelectorAll('.producer-item-card').forEach(el => {
    el.classList.remove('selected');
  });

  const card = document.getElementById(`card-item-${id}`);
  if (card) {
    card.classList.add('selected');
    card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
}

/**
 * Configura los botones de filtro por rubro
 */
function setupFilterListeners() {
  const filterButtons = document.querySelectorAll('.filter-chip');
  filterButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      filterButtons.forEach(b => b.classList.remove('active'));
      const target = e.currentTarget;
      target.classList.add('active');

      currentFilter = target.getAttribute('data-filter') || 'todos';
      updateMarkers();
      renderProducersList();
    });
  });
}

/**
 * Configura el buscador en tiempo real
 */
function setupSearchListener() {
  const searchInput = document.getElementById('search-producer');
  if (!searchInput) return;

  searchInput.addEventListener('input', (e) => {
    searchQuery = e.target.value;
    updateMarkers();
    renderProducersList();
  });
}

/**
 * Función utilitaria expuesta globalmente para reiniciar la vista del mapa
 */
window.resetMapBounds = function() {
  if (!mapInstance || !PRODUCTORES_SAN_JOSE.length) return;
  const allBounds = PRODUCTORES_SAN_JOSE.map(p => p.coords);
  mapInstance.fitBounds(allBounds, { padding: [50, 50], maxZoom: 15 });
};

window.focusProducer = focusProducer;
