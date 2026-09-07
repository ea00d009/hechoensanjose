/**
 * ==========================================================================
 * HECHO EN SAN JOSÉ - LÓGICA DEL MAPA INTERACTIVO (Leaflet.js)
 * Maqueta Funcional para el Honorable Concejo Deliberante
 * Ciudad de San José, Entre Ríos, Argentina
 * ==========================================================================
 */

// 1. Datos Georreferenciados de Productores Locales de San José (11 Establecimientos Auténticos)
const PRODUCTORES_SAN_JOSE = [
  {
    id: 1,
    nombre: "Licores Bard",
    rubro: "Licores Artesanales Tradicionales",
    categoria: "bebidas",
    tagLabel: "Licores desde 1908",
    tagClass: "tag-licores",
    pinColor: "#7c3aed",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8"/><path d="M10 2v5l-4 5.5v7.5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-7.5L14 7V2"/></svg>`,
    coords: [-32.20780, -58.22510],
    direccion: "Entre Ríos 1046 (e/ 3 de Febrero y Caseros), San José",
    telefono: "+54 9 3447 40-5163",
    whatsapp: "5493447405163",
    horario: "Lun a Sáb: 08:30 a 12:30 y 17:00 a 21:00 hs",
    descripcion: "Fábrica centenaria fundada en 1908. Elaboran licores artesanales tradicionales de yatay, miel de eucalipto, naranja y hierbas sin aditivos ni conservantes químicos.",
    destacado: true
  },
  {
    id: 2,
    nombre: "Establecimiento Los Pecanes",
    rubro: "Producción Agropecuaria & Casa de Té",
    categoria: "pecan",
    tagLabel: "Pecán & Casa de Té",
    tagClass: "tag-pecan",
    pinColor: "#059669",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>`,
    coords: [-32.20350, -58.20320],
    direccion: "Ruta 26 (RP 130) Km. 7, San José",
    telefono: "+54 9 3447 43-3929",
    whatsapp: "5493447433929",
    horario: "Mié a Dom: 10:00 a 20:00 hs",
    descripcion: "Plantación pionera de nogales pecán, casa de té y patio cervecero campestre. Visitas guiadas al monte frutal, degustación de nueces y productos regionales.",
    destacado: true
  },
  {
    id: 3,
    nombre: "De los Troncos Petrificados",
    rubro: "Artesanías & Minerales del Río Uruguay",
    categoria: "artesania",
    tagLabel: "Piedras & Minerales",
    tagClass: "tag-artesania",
    pinColor: "#be123c",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="6 3 18 3 22 9 12 22 2 9 6 3"></polygon><line x1="2" y1="9" x2="22" y2="9"></line><line x1="12" y1="22" x2="16" y2="9"></line><line x1="12" y1="22" x2="8" y2="9"></line></svg>`,
    coords: [-32.19801, -58.15484],
    direccion: "Ruta Prov. 26 Km. 3,5 (Barrio Troncos Petrificados), San José",
    telefono: "+54 9 3447 46-4775",
    whatsapp: "5493447464775",
    horario: "Todos los días: 10:00 a 19:00 hs",
    descripcion: "Reservorio de Selva Gayol. Exposición permanente y venta de maderas petrificadas y piedras semipreciosas (ágatas, amatistas y cuarzos) de las orillas del río Uruguay.",
    destacado: false
  },
  {
    id: 4,
    nombre: "Artesanías El Palmar",
    rubro: "Artesanías Regionales & Fibras Naturales",
    categoria: "artesania",
    tagLabel: "Artesanías & Fibras",
    tagClass: "tag-artesania",
    pinColor: "#e54260",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>`,
    coords: [-32.19409, -58.23921],
    direccion: "Ruta Nacional 14 Km. 158,5, Colonia San José",
    telefono: "+54 9 3447 45-5239",
    whatsapp: "5493447455239",
    horario: "Lun a Sáb: 10:00 a 18:00 hs",
    descripcion: "Establecimiento tradicional con plantación de mates orgánicos, cestería en fibra de palma yatay, tallados en maderas nativas y piezas criollas tejidas.",
    destacado: false
  },
  {
    id: 5,
    nombre: "Nuez Pecán La Reina",
    rubro: "Frutos Secos & Agroindustria",
    categoria: "pecan",
    tagLabel: "Pecán Premiado",
    tagClass: "tag-pecan",
    pinColor: "#059669",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 3c3 4 3 14 0 18"/><path d="M3 12c4-3 14-3 18 0"/></svg>`,
    coords: [-32.202766, -58.202412],
    direccion: "Doctor Luis Cettour, San José, Entre Ríos",
    telefono: "+54 9 3447 45-2947",
    whatsapp: "5493447452947",
    horario: "Lun a Dom: 09:00 a 13:00 y 16:00 a 20:00 hs",
    descripcion: "Establecimiento Los Pecanes - La Boutique de la Nuez Pecán. Emprendimiento emblemático distinguido con el Sello de Turismo Industrial y Productivo. Nueces seleccionadas en mitades, garrapiñadas, saladas y bombones rellenos.",
    destacado: true
  },
  {
    id: 6,
    nombre: "Apícola La Sanjosesina",
    rubro: "Apicultura & Miel Pura",
    categoria: "alimentos",
    tagLabel: "Miel Pura de Monte",
    tagClass: "tag-miel",
    pinColor: "#d97706",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8"/><rect width="14" height="15" x="5" y="5" rx="3"/><path d="M5 10h14"/><path d="M12 13v4"/></svg>`,
    coords: [-32.20860, -58.22050],
    direccion: "Centenario 1580 (e/ Ituzaingó y Yrigoyen), San José",
    telefono: "+54 9 3447 52-1144",
    whatsapp: "5493447521144",
    horario: "Lun a Vie: 08:30 a 12:30 y 16:30 a 20:00 hs",
    descripcion: "Miel pura de abejas de monte nativo y praderas entrerrianas, propóleo puro, polen y cera cosechados de forma artesanal y sustentable por apicultores locales.",
    destacado: false
  },
  {
    id: 7,
    nombre: "Granja Histórica La Administración",
    rubro: "Quesería & Tradición Colonial",
    categoria: "alimentos",
    tagLabel: "Quesos & Campo",
    tagClass: "tag-quesos",
    pinColor: "#0284c7",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>`,
    coords: [-32.21947, -58.19212],
    direccion: "Camino de los Primeros Colonos s/n (Junto al Molino Forclaz), Colonia San José",
    telefono: "+54 9 3447 47-0220",
    whatsapp: "5493447470220",
    horario: "Mar a Dom: 09:30 a 19:00 hs",
    descripcion: "Predio histórico de la colonización de 1857 y antigua administración de Alejo Peyret. Quesos artesanales gouda y sardo, ricota fresca de campo y picadas coloniales.",
    destacado: true
  },
  {
    id: 8,
    nombre: "Dulces Caseros La Juanita",
    rubro: "Dulces Caseros & Conservas",
    categoria: "alimentos",
    tagLabel: "Dulces & Mermeladas",
    tagClass: "tag-dulces",
    pinColor: "#ea580c",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 3h10v3H7z"/><rect x="5" y="6" width="14" height="15" rx="3"/><circle cx="12" cy="13" r="3"/></svg>`,
    coords: [-32.21240, -58.22000],
    direccion: "Urquiza 1127 (Frente a Plaza Urquiza / Museo), San José",
    telefono: "+54 9 3447 44-3322",
    whatsapp: "5493447443322",
    horario: "Lun a Sáb: 09:00 a 13:00 y 17:00 a 20:30 hs",
    descripcion: "Mermeladas tradicionales de frutos locales: higos, naranja amarga, frutos del yatay y zapallos en almíbar elaborados a leña en paila de cobre sin aditivos.",
    destacado: false
  },
  {
    id: 9,
    nombre: "Viñedos & Bodega Vulliez Sermet",
    rubro: "Enoturismo & Vinos de Entre Ríos",
    categoria: "bebidas",
    tagLabel: "Vinos & Enoturismo",
    tagClass: "tag-vinos",
    pinColor: "#991b1b",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h4v4H8z"/><path d="M7 6h6l2 4v11a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V10l2-4z"/><circle cx="10" cy="14" r="2"/><path d="M18 10v7a2 2 0 0 1-2 2h0a2 2 0 0 1-2-2v-7h4z"/><path d="M16 19v3"/></svg>`,
    coords: [-32.23824, -58.15890],
    direccion: "Ruta Nacional 135 Km 8 (Circuito San José - Colón)",
    telefono: "+54 9 3447 50-5095",
    whatsapp: "5493447505095",
    horario: "Visitas guiadas y degustaciones diarias a las 11:00 y 16:30 hs",
    descripcion: "Pioneros del renacer vitivinícola entrerriano. Viñedos históricos, cavas centenarias y elaboración de varietales Tannat, Malbec, Chardonnay y espumantes.",
    destacado: true
  },
  {
    id: 10,
    nombre: "Cervecería Artesanal El Molino",
    rubro: "Cervecería & Bebidas",
    categoria: "bebidas",
    tagLabel: "Cerveza Artesanal",
    tagClass: "tag-cerveza",
    pinColor: "#b45309",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 11h1a3 3 0 0 1 0 6h-1"/><path d="M9 12v6"/><path d="M13 12v6"/><path d="M5 8v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8"/></svg>`,
    coords: [-32.21020, -58.21980],
    direccion: "Centenario 1361 (Zona Céntrica), San José",
    telefono: "+54 9 3447 48-3344",
    whatsapp: "5493447483344",
    horario: "Mié a Dom: 18:00 a 01:00 hs",
    descripcion: "Punto cervecero artesanal en el centro de San José con maltas entrerrianas y aguas puras de la cuenca. Estilos propios premiados: Dorada Pampeana, Honey con miel isleña y Red Ale.",
    destacado: true
  },
  {
    id: 11,
    nombre: "Cuchillería & Talabartería Sanjo Tradición",
    rubro: "Artesanías & Tradición Criolla",
    categoria: "artesania",
    tagLabel: "Cuchillos & Cuero",
    tagClass: "tag-artesania",
    pinColor: "#e54260",
    iconoSvg: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>`,
    coords: [-32.21215, -58.21715],
    direccion: "Mitre 1150 (Frente a Plaza Urquiza), San José",
    telefono: "+54 9 3447 43-9911",
    whatsapp: "5493447439911",
    horario: "Lun a Sáb: 09:00 a 13:00 y 17:00 a 20:30 hs",
    descripcion: "Cuchillos artesanales forjados a mano en acero al carbono con cabos de guayacán, asta de ciervo y alpaca. Platería criolla y trabajos artesanales en cuero crudo sobado.",
    destacado: false
  }
];

// 2. Estado Global de la Aplicación
let mapInstance = null;
let markerLayerGroup = null;
let currentTileLayer = null;
let currentFilter = 'todos';
let searchQuery = '';
const markerMap = new Map(); // id -> L.marker

// 3. Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
  initThemeToggle();
  initMobileNav();
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

  // Coordenadas céntricas de San José, Entre Ríos (Plaza Gral. Urquiza / Casco Urbano)
  const SAN_JOSE_CENTER = [-32.2123, -58.2191];
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

  // Capa base dinámica según modo claro / oscuro
  applyMapTileLayer();

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
  const tabCounter = document.getElementById('tab-counter');
  if (!container) return;

  const filtered = getFilteredProducers();

  if (countBadge) {
    countBadge.textContent = `${filtered.length} ${filtered.length === 1 ? 'productor' : 'productores'}`;
  }
  if (tabCounter) {
    tabCounter.textContent = filtered.length;
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

  // Si estamos en vista móvil, alternar automáticamente al mapa para ver el pin
  if (window.innerWidth <= 768 && window.switchMapTab) {
    window.switchMapTab('map');
  }

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

/**
 * Control del Menú Móvil Desplegable
 */
function initMobileNav() {
  const toggleBtn = document.getElementById('mobile-menu-btn');
  const navActions = document.getElementById('main-nav-actions') || document.querySelector('.nav-actions');

  if (!toggleBtn || !navActions) return;

  toggleBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = navActions.classList.contains('is-open');
    if (isOpen) {
      navActions.classList.remove('is-open');
      toggleBtn.classList.remove('active');
      toggleBtn.setAttribute('aria-expanded', 'false');
    } else {
      navActions.classList.add('is-open');
      toggleBtn.classList.add('active');
      toggleBtn.setAttribute('aria-expanded', 'true');
    }
  });

  // Cerrar menú al hacer clic en cualquier enlace interno
  navActions.querySelectorAll('a, button').forEach(el => {
    el.addEventListener('click', () => {
      navActions.classList.remove('is-open');
      toggleBtn.classList.remove('active');
      toggleBtn.setAttribute('aria-expanded', 'false');
    });
  });

  // Cerrar menú al hacer clic fuera
  document.addEventListener('click', (e) => {
    if (!navActions.contains(e.target) && !toggleBtn.contains(e.target)) {
      navActions.classList.remove('is-open');
      toggleBtn.classList.remove('active');
      toggleBtn.setAttribute('aria-expanded', 'false');
    }
  });
}

/**
 * Conmutador de vista en Mapa para Celulares (Pestaña Mapa / Pestaña Lista)
 */
function switchMapTab(tab) {
  const layout = document.querySelector('.map-app-layout');
  const btnMap = document.getElementById('tab-btn-map');
  const btnList = document.getElementById('tab-btn-list');

  if (!layout) return;

  if (tab === 'map') {
    layout.classList.remove('layout-show-list');
    layout.classList.add('layout-show-map');
    if (btnMap) btnMap.classList.add('active');
    if (btnList) btnList.classList.remove('active');

    if (mapInstance) {
      setTimeout(() => {
        mapInstance.invalidateSize();
      }, 100);
    }
  } else if (tab === 'list') {
    layout.classList.remove('layout-show-map');
    layout.classList.add('layout-show-list');
    if (btnList) btnList.classList.add('active');
    if (btnMap) btnMap.classList.remove('active');
  }
}

/**
 * Aplica la capa de mapa estándar de OpenStreetMap (el tema oscuro se gestiona por CSS sin requerir API Keys)
 */
function applyMapTileLayer() {
  if (!mapInstance) return;

  if (!currentTileLayer) {
    currentTileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors | Hecho en San José'
    });
    currentTileLayer.addTo(mapInstance);
  }
}

/**
 * Alterna entre Modo Claro y Modo Oscuro
 */
function toggleTheme() {
  const current = document.documentElement.getAttribute('data-theme') || 'light';
  const newTheme = current === 'dark' ? 'light' : 'dark';

  document.documentElement.setAttribute('data-theme', newTheme);
  try {
    localStorage.setItem('sanjose-theme', newTheme);
  } catch (e) {
    // Almacenamiento no disponible o navegación privada estricta
  }

  // Actualizar teselas del mapa si está activo
  applyMapTileLayer();
}

/**
 * Inicializa el sistema de Modo Oscuro y escucha eventos
 */
function initThemeToggle() {
  try {
    const saved = localStorage.getItem('sanjose-theme');
    if (saved) {
      document.documentElement.setAttribute('data-theme', saved);
    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      document.documentElement.setAttribute('data-theme', 'dark');
    }
  } catch (e) {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      document.documentElement.setAttribute('data-theme', 'dark');
    }
  }

  // Asociar evento a todos los botones .theme-toggle-btn
  document.querySelectorAll('.theme-toggle-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleTheme();
    });
  });
}

window.focusProducer = focusProducer;
window.switchMapTab = switchMapTab;
window.initMobileNav = initMobileNav;
window.toggleTheme = toggleTheme;
window.initThemeToggle = initThemeToggle;
