<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • MANUAL DE USUARIO Y OPERACIONES INSTITUCIONALES
 * ==============================================================================
 * Documentación oficial para operadores de la Secretaría de Educación,
 * Cultura y Turismo de la Municipalidad de San José, Entre Ríos.
 */

require_once __DIR__ . '/auth.php';
requireAdmin();

$pageTitle = 'Manual de Usuario y Operaciones';
require_once __DIR__ . '/header.php';
?>

<div style="max-width: 1000px; margin: 0 auto; padding-bottom: 3rem;">

  <!-- Encabezado del Manual -->
  <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
      <div>
        <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(0, 150, 199, 0.1); color: var(--color-primary, #0096c7); font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; margin-bottom: 0.5rem; text-transform: uppercase;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
          Documentación Oficial &bull; Versión 2.0 (MVC &amp; Cartografía Satelital)
        </div>
        <h2 style="font-size: 1.85rem; color: var(--text-main, #0f172a); margin: 0 0 0.4rem 0; font-weight: 800; letter-spacing: -0.02em;">
          Manual de Usuario y Operaciones
        </h2>
        <p style="color: var(--text-muted, #64748b); margin: 0; font-size: 0.98rem; max-width: 750px; line-height: 1.5;">
          Guía operativa integral del sistema municipal <strong>Hecho en San José</strong> para la gestión del padrón productivo, cartografía interactiva, homologación de solicitudes y seguridad institucional.
        </p>
      </div>

      <div style="display: flex; gap: 0.5rem;">
        <a href="exportar-csv.php" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 6px; color: #059669; border-color: #059669;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Exportar Padrón CSV
        </a>
        <button onclick="window.print()" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          Imprimir / Guardar PDF
        </button>
      </div>
    </div>

    <!-- Barra de Accesos Rápidos (Índice) -->
    <div style="margin-top: 1.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
      <a href="#ecosistema" class="btn btn-outline btn-sm" style="font-size: 0.78rem; text-decoration: none;">🌐 1. Ecosistema Público</a>
      <a href="#padron" class="btn btn-outline btn-sm" style="font-size: 0.78rem; text-decoration: none;">👨‍🌾 2. Padrón y Mapa</a>
      <a href="#gondolas" class="btn btn-outline btn-sm" style="font-size: 0.78rem; text-decoration: none;">🛒 3. Red de Góndolas (ABM)</a>
      <a href="#solicitudes" class="btn btn-outline btn-sm" style="font-size: 0.78rem; text-decoration: none;">📬 4. Solicitudes de Vecinos</a>
      <a href="#qr-urls" class="btn btn-outline btn-sm" style="font-size: 0.78rem; text-decoration: none;">📱 5. URLs Amigables y QR</a>
      <a href="#categorias" class="btn btn-outline btn-sm" style="font-size: 0.78rem; text-decoration: none;">🏷️ 6. Categorías y Simbología</a>
      <a href="#seguridad" class="btn btn-outline btn-sm" style="font-size: 0.78rem; text-decoration: none;">🛡️ 7. Seguridad y Resguardo</a>
      <a href="#faq" class="btn btn-outline btn-sm" style="font-size: 0.78rem; text-decoration: none;">❓ 8. Preguntas Frecuentes</a>
    </div>
  </div>

  <div style="display: flex; flex-direction: column; gap: 1.75rem;">

    <!-- ==========================================
         SECCIÓN 1: ECOSISTEMA PÚBLICO
         ========================================== -->
    <section id="ecosistema" class="card-admin" style="scroll-margin-top: 2rem;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
        <span style="font-size: 1.5rem;">🌐</span>
        <div>
          <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
            1. Ecosistema Público y Navegación Turística
          </h3>
          <p style="margin: 2px 0 0 0; font-size: 0.82rem; color: var(--text-muted);">
            Vistas públicas optimizadas para turistas, vecinos y consumidores de cercanía.
          </p>
        </div>
      </div>

      <div style="font-size: 0.92rem; line-height: 1.6; color: var(--text-muted);">
        <p style="margin-top: 0;">
          El portal institucional fue refactorizado bajo arquitectura <strong>MVC (Modelo-Vista-Controlador)</strong> con enrutamiento limpio, eliminando extensiones obsoletas y garantizando velocidad de carga sin latencia (Zero Latency).
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin-top: 1rem;">
          <div style="background: var(--bg-hover, #f8fafc); padding: 1rem; border-radius: 10px; border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main); display: flex; align-items: center; gap: 6px;">
              <code style="color: var(--color-primary); font-size: 0.85rem;">/</code> Portal de Bienvenida (Home)
            </strong>
            <p style="font-size: 0.85rem; margin: 0.5rem 0 0 0;">
              Presentación institucional del programa municipal, estadísticas en vivo del padrón y vitrina de <strong>Productores Destacados</strong> seleccionados por la Secretaría.
            </p>
          </div>

          <div style="background: var(--bg-hover, #f8fafc); padding: 1rem; border-radius: 10px; border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main); display: flex; align-items: center; gap: 6px;">
              <code style="color: var(--color-primary); font-size: 0.85rem;">/mapa</code> y <code style="color: var(--color-primary); font-size: 0.85rem;">/mapa/{slug}</code>
            </strong>
            <p style="font-size: 0.85rem; margin: 0.5rem 0 0 0;">
              Cartografía interactiva con tecnología <strong>Leaflet.js</strong>. Cada productor cuenta con su dirección semántica propia (ej. <code>/mapa/licores-bard</code>) con enfoque satelital automático (<code style="font-size: 0.8rem;">flyTo</code>), tarjeta interactiva, botón GPS «Cómo llegar» y contacto por WhatsApp.
            </p>
          </div>

          <div style="background: var(--bg-hover, #f8fafc); padding: 1rem; border-radius: 10px; border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main); display: flex; align-items: center; gap: 6px;">
              <code style="color: var(--color-primary); font-size: 0.85rem;">/catalogo</code> Catálogo Digital
            </strong>
            <p style="font-size: 0.85rem; margin: 0.5rem 0 0 0;">
              Directorio con buscador en tiempo real y chips de filtrado temático por rubro. Los contadores de productores activos se calculan dinámicamente desde la base de datos.
            </p>
          </div>

          <div style="background: var(--bg-hover, #f8fafc); padding: 1rem; border-radius: 10px; border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main); display: flex; align-items: center; gap: 6px;">
              <code style="color: var(--color-primary); font-size: 0.85rem;">/gondola</code> Red de Góndolas
            </strong>
            <p style="font-size: 0.85rem; margin: 0.5rem 0 0 0;">
              Puntos de venta físicos (vinotecas, almacenes y centros turísticos) que comercializan productos locales con la identificación oficial del programa.
            </p>
          </div>

          <div style="background: var(--bg-hover, #f8fafc); padding: 1rem; border-radius: 10px; border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main); display: flex; align-items: center; gap: 6px;">
              <code style="color: var(--color-primary); font-size: 0.85rem;">/inscribir</code> Postulación Ciudadana
            </strong>
            <p style="font-size: 0.85rem; margin: 0.5rem 0 0 0;">
              Formulario guiado en 4 pasos para que nuevos emprendedores soliciten incorporarse al programa. Conecta directamente con la bandeja de solicitudes administrativas.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ==========================================
         SECCIÓN 2: PADRÓN DE PRODUCTORES Y MAPA
         ========================================== -->
    <section id="padron" class="card-admin" style="scroll-margin-top: 2rem;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
        <span style="font-size: 1.5rem;">👨‍🌾</span>
        <div>
          <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
            2. Padrón Oficial de Productores (Gestión Operativa)
          </h3>
          <p style="margin: 2px 0 0 0; font-size: 0.82rem; color: var(--text-muted);">
            Altas, modificaciones, geolocalización satelital y control de visibilidad pública.
          </p>
        </div>
      </div>

      <div style="font-size: 0.92rem; line-height: 1.6; color: var(--text-muted);">
        <p>
          Desde la sección <a href="productores" style="color: #0284c7; font-weight: 700;">Gestión de Productores</a>, el personal administrativo cuenta con las siguientes herramientas de control:
        </p>

        <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
          
          <div style="border-left: 4px solid #0284c7; padding-left: 1rem;">
            <strong style="color: var(--text-main); font-size: 0.95rem;">👁️ Botón «Ver» (Previsualización Canónica):</strong>
            <p style="margin: 0.25rem 0 0 0;">
              Cada fila del padrón incluye un botón directo <strong>«Ver»</strong>. Al pulsarlo, el sistema abre la URL pública amigable (<code>/mapa/{slug}</code>) en una nueva pestaña. Esto permite al operador verificar en tiempo real que el marcador satelital, los horarios y las descripciones se vean impecables antes de difundirlos.
            </p>
          </div>

          <div style="border-left: 4px solid #059669; padding-left: 1rem;">
            <strong style="color: var(--text-main); font-size: 0.95rem;">📱 Botón «QR PDF» (PDF para Imprimir):</strong>
            <p style="margin: 0.25rem 0 0 0;">
              Descarga un PDF A4 de una sola página con el nombre y rubro del productor, su dirección, WhatsApp, teléfono y horario de atención cuando estén cargados, junto a un código QR grande de 12 cm. El QR conserva su URL pública en el mapa (ej. <code>https://sanjose.tur.ar/mapa/licores-bard</code>) y se incluye en formato vectorial para una impresión nítida.
            </p>
          </div>

          <div style="border-left: 4px solid #f59e0b; padding-left: 1rem;">
            <strong style="color: var(--text-main); font-size: 0.95rem;">⭐ Toggle «Destacado» (1 Clic):</strong>
            <p style="margin: 0.25rem 0 0 0;">
              Permite rotar o destacar productores de temporada (ej. cosecha de nuez pecán, vendimia de bodegas o fiesta de la miel). El productor destacado recibe una insignia dorada y aparece al inicio del Catálogo y en la sección destacada del portal principal.
            </p>
          </div>

          <div style="border-left: 4px solid #64748b; padding-left: 1rem;">
            <strong style="color: var(--text-main); font-size: 0.95rem;">👁️‍🗨️ Toggle «Activo / Inactivo» (Pausa Temporal):</strong>
            <p style="margin: 0.25rem 0 0 0;">
              Si un productor cierra temporalmente por vacaciones, remodelación de su taller o falta de stock estacional, se puede ocultar del mapa y catálogo con un solo clic. Sus datos quedan perfectamente guardados en la base de datos sin necesidad de borrarlos.
            </p>
          </div>

          <div style="border-left: 4px solid #10b981; padding-left: 1rem;">
            <strong style="color: var(--text-main); font-size: 0.95rem;">📍 Selector Geográfico Interactivo en Formulario:</strong>
            <p style="margin: 0.25rem 0 0 0;">
              Al ingresar a <strong>+ Nueva Alta</strong> o <strong>Editar</strong>, se despliega un mapa satelital interactivo de San José. El operador puede:
            </p>
            <ul style="margin: 0.5rem 0 0 0; padding-left: 1.2rem;">
              <li>Hacer clic en cualquier punto del ejido urbano o zonas rurales para colocar el pin.</li>
              <li>Arrastrar el marcador directamente hasta la entrada del establecimiento o taller.</li>
              <li>Las coordenadas de <strong>Latitud</strong> y <strong>Longitud</strong> se calculan y completan de forma 100% automática.</li>
            </ul>
          </div>

          <div style="border-left: 4px solid #7c3aed; padding-left: 1rem;">
            <strong style="color: var(--text-main); font-size: 0.95rem;">🖼️ Gestor de Imágenes y Seguridad MIME:</strong>
            <p style="margin: 0.25rem 0 0 0;">
              Permite subir imágenes directamente desde la computadora (formatos válidos: JPG, PNG o WebP, peso máximo: 5 MB). El servidor valida el tipo MIME real, genera un nombre seguro y almacena el archivo en <code>assets/productores/</code>. También se puede utilizar una URL web externa.
            </p>
          </div>

          <div style="border-left: 4px solid #059669; padding-left: 1rem;">
            <strong style="color: var(--text-main); font-size: 0.95rem;">💬 Configuración de WhatsApp Comercial:</strong>
            <p style="margin: 0.25rem 0 0 0;">
              Ingresar el número telefónico en formato internacional argentino sin guiones ni espacios (ej: <code>5493447123456</code>). La plataforma genera automáticamente el botón que abre el chat directo entre el turista y el productor.
            </p>
          </div>

          <div style="border-left: 4px solid #8b5cf6; padding-left: 1rem;">
            <strong style="color: var(--text-main); font-size: 0.95rem;">🛒 Asignación a Góndolas Municipales (Sección 5 del Formulario):</strong>
            <p style="margin: 0.25rem 0 0 0;">
              Al editar o dar de alta un productor, la <strong>Sección 5</strong> lista todas las góndolas municipales activas con casillas de verificación (checkboxes). El operador puede tildar los puntos de venta adheridos donde el productor tiene mercadería en exhibición. Al guardar, el padrón mostrará la insignia <code>🛒 X góndolas</code> y en el catálogo público aparecerá el badge <em>«Disponible en Góndola»</em>.
            </p>
          </div>

        </div>
      </div>
    </section>

    <!-- ==========================================
         SECCIÓN 3: RED DE GÓNDOLAS OFICIALES (ABM)
         ========================================== -->
    <section id="gondolas" class="card-admin" style="scroll-margin-top: 2rem;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
        <span style="font-size: 1.5rem;">🛒</span>
        <div>
          <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
            3. Red de Góndolas «Hecho en San José» (Módulo ABM y Sinergia)
          </h3>
          <p style="margin: 2px 0 0 0; font-size: 0.82rem; color: var(--text-muted);">
            Iniciativa Municipal: Exhibidores exclusivos ubicados en comercios y centros turísticos para acercar el trabajo local a residentes y turistas.
          </p>
        </div>
      </div>

      <div style="font-size: 0.92rem; line-height: 1.6; color: var(--text-muted);">
        <div style="background: #fdf4ff; border: 1px solid #f0abfc; color: #86198f; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.88rem;">
          <strong>⚖️ Requisito Institucional Obligatorio:</strong> Para que un productor local pueda colocar sus productos en los exhibidores municipales instalados en comercios, supermercados y centros turísticos, <strong>debe estar previamente homologado y publicado en el padrón web oficial</strong> de <em>Hecho en San José</em>. Esto garantiza trazabilidad bromatológica, identidad de origen y permite que cualquier persona frente a la góndola escanee el QR para conocer su historia y contactarlo directamente.
        </div>

        <p>
          Las góndolas oficiales son muebles exhibidores identificados institucionalmente instalados en supermercados, autoservicios, vinotecas y centros turísticos de San José. Desde la sección <a href="gondolas.php" style="color: #0284c7; font-weight: 700;">Góndolas</a>, los operadores pueden realizar:
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin: 1rem 0;">
          <div style="background: var(--bg-hover, #f8fafc); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main); font-size: 0.95rem;">➕ Alta y Edición con Geolocalización:</strong>
            <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem;">
              Cargar nuevos comercios adheridos indicando nombre, tipo de punto (Góndola Central, Punto Turístico, Almacén de Campo, etc.), descripción, horarios, dirección física y pin interactivo sobre mapa satelital para generar el enlace de llegada con GPS.
            </p>
          </div>

          <div style="background: var(--bg-hover, #f8fafc); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main); font-size: 0.95rem;">👨‍🌾 Asignación Bidireccional de Productores:</strong>
            <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem;">
              En el formulario de cada góndola se seleccionan con casillas de verificación qué productores del padrón ofrecen sus elaboraciones allí. La tabla de administración muestra la insignia en vivo <code>👨‍🌾 X productores asignados</code>.
            </p>
          </div>

          <div style="background: var(--bg-hover, #f8fafc); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main); font-size: 0.95rem;">⚡ Control de Visibilidad y Puntos Destacados:</strong>
            <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem;">
              Activar o pausar de inmediato la publicación de una góndola con un solo clic, así como asignarle la insignia de punto destacado (★) para priorizarla visualmente en el portal.
            </p>
          </div>

          <div style="background: var(--bg-hover, #f8fafc); padding: 1rem; border-radius: 8px; border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main); font-size: 0.95rem;">⬇️ Exportación de Puntos a CSV:</strong>
            <p style="margin: 0.25rem 0 0 0; font-size: 0.85rem;">
              Descargar en cualquier momento el padrón completo de góndolas en formato Excel compatible (UTF-8 con BOM) para informes de gestión de la Secretaría.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ==========================================
         SECCIÓN 4: BANDEJA DE SOLICITUDES
         ========================================== -->
    <section id="solicitudes" class="card-admin" style="scroll-margin-top: 2rem;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
        <span style="font-size: 1.5rem;">📬</span>
        <div>
          <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
            4. Bandeja de Solicitudes y Homologación en 1 Clic
          </h3>
          <p style="margin: 2px 0 0 0; font-size: 0.82rem; color: var(--text-muted);">
            Circuito de postulación ciudadana, contacto institucional y conversión directa a productor con asignación a góndolas.
          </p>
        </div>
      </div>

      <div style="font-size: 0.92rem; line-height: 1.6; color: var(--text-muted);">
        <p>
          Cuando un vecino completa el formulario de inscripción en <code>/inscribir</code>, la solicitud ingresa de forma inmediata en la base de datos municipal con estado <strong>«Pendiente»</strong> y se activa un badge numérico rojo en el menú superior del panel.
        </p>

        <div style="background: var(--bg-hover, #f8fafc); padding: 1.25rem; border-radius: 10px; border: 1px solid var(--border-light); margin: 1rem 0;">
          <h4 style="margin: 0 0 0.75rem 0; color: var(--text-main); font-size: 1rem; font-weight: 800; display: flex; align-items: center; gap: 8px;">
            <span>⚡</span> Flujo de Homologación Digital en 1 Clic:
          </h4>
          <ol style="margin: 0; padding-left: 1.3rem; display: flex; flex-direction: column; gap: 0.65rem;">
            <li>
              <strong>Revisión de Antecedentes:</strong> En <a href="solicitudes.php" style="color: #0284c7; font-weight: 700;">Solicitudes de Inscripción</a>, revisar el nombre del titular, la dirección, la descripción de materias primas locales y el <strong>DNI / CUIT</strong> registrado en las notas de administración.
            </li>
            <li>
              <strong>Contacto Previo por WhatsApp:</strong> Presionar el botón <em>«Enviar WhatsApp»</em> en la tarjeta de la solicitud para iniciar una conversación oficial con el emprendedor mediante un mensaje institucional prediseñado.
            </li>
            <li>
              <strong>Conversión Asistida (Góndolas / Catálogo):</strong>
              <ul style="margin: 0.25rem 0 0.25rem 1rem; padding: 0;">
                <li>Si el postulante marcó interés en <strong>Venta en Góndolas</strong>, el sistema ofrece el botón prioritario: <strong style="color: #8b5cf6;">«✓ Aprobar y Asignar a Góndolas →»</strong>. Al pulsarlo, transfiere los datos al formulario y emite una alerta para tildar las góndolas convenidas en la Sección 5.</li>
                <li>Si no marcó góndolas, presenta el botón verde estándar <strong style="color: #059669;">«✓ Aprobar y Convertir en Productor»</strong>.</li>
              </ul>
              <div style="background: #ecfdf5; color: #065f46; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.84rem; margin-top: 0.4rem; border: 1px solid #a7f3d0;">
                💡 <strong>Automatización Inteligente:</strong> El sistema transfiere automáticamente el nombre del emprendimiento, rubro, WhatsApp, dirección y descripción, y deduce la categoría adecuada (Alimentos, Bebidas, Artesanías, etc.).
              </div>
            </li>
            <li>
              <strong>Georreferenciación y Publicación:</strong> El operador solo verifica la posición del pin satelital, asocia una fotografía y pulsa <em>«Guardar Productor»</em>.
            </li>
            <li>
              <strong>Cierre del Circuito:</strong> Al guardarse el productor, la solicitud cambia automáticamente su estado a <strong>«Aprobada»</strong> y el emprendimiento queda publicado de inmediato en el mapa, catálogo oficial y góndolas vinculadas.
            </li>
          </ol>
        </div>

        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap; margin-top: 1rem;">
          <span style="font-size: 0.8rem; padding: 4px 10px; border-radius: 6px; background: #fef3c7; color: #b45309; font-weight: 700;">
            🟡 Pendiente: Requiere análisis municipal
          </span>
          <span style="font-size: 0.8rem; padding: 4px 10px; border-radius: 6px; background: #ecfdf5; color: #059669; font-weight: 700;">
            🟢 Aprobada: Homologado y activo en el padrón
          </span>
          <span style="font-size: 0.8rem; padding: 4px 10px; border-radius: 6px; background: #f1f5f9; color: #64748b; font-weight: 700;">
            ⚪ Desestimada: No cumple requisitos o descartada
          </span>
        </div>
      </div>
    </section>

    <!-- ==========================================
         SECCIÓN 5: CÓDIGOS QR Y URLS AMIGABLES
         ========================================== -->
    <section id="qr-urls" class="card-admin" style="scroll-margin-top: 2rem;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
        <span style="font-size: 1.5rem;">📱</span>
        <div>
          <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
            5. URLs Semánticas y Códigos QR Oficiales
          </h3>
          <p style="margin: 2px 0 0 0; font-size: 0.82rem; color: var(--text-muted);">
            Integración de marketing territorial para packaging, folletería y cartelería turística.
          </p>
        </div>
      </div>

      <div style="font-size: 0.92rem; line-height: 1.6; color: var(--text-muted);">
        <p>
          Uno de los hitos tecnológicos de la plataforma es la implementación de <strong>URLs amigables y canónicas</strong> por productor. Esto permite crear códigos QR limpios que funcionan permanentemente sin depender de identificadores numéricos confusos.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin: 1rem 0;">
          <div style="padding: 1rem; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main);">Etiquetas y Packaging de Productos:</strong>
            <p style="font-size: 0.85rem; margin: 0.35rem 0 0 0;">
              Impresión de códigos QR en botellas de licores artesanales, vinos locales, frascos de miel o bolsas de nuez pecán. El consumidor escanea el envase y visualiza de dónde provino la materia prima y su historia productiva.
            </p>
          </div>

          <div style="padding: 1rem; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main);">Cartelería en Tranqueras y Talleres:</strong>
            <p style="font-size: 0.85rem; margin: 0.35rem 0 0 0;">
              Identificación visual en el acceso de las chacras y talleres con el isologotipo de Hecho en San José y el código QR de ruta guiada GPS para turistas de paso.
            </p>
          </div>

          <div style="padding: 1rem; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main);">Oficinas de Información Turística:</strong>
            <p style="font-size: 0.85rem; margin: 0.35rem 0 0 0;">
              Folletería y carteles en los centros de atención al visitante (Plaza Urquiza, Balneario Camping, Termas San José) para que los turistas lleven la guía georreferenciada en sus celulares.
            </p>
          </div>
        </div>

        <div style="background: rgba(0, 150, 199, 0.08); padding: 1rem; border-radius: 8px; border-left: 4px solid var(--color-primary);">
          <strong style="color: var(--text-main);">¿Cómo descargar el PDF con QR de un productor?</strong>
          <p style="margin: 0.3rem 0 0 0; font-size: 0.88rem;">
            En <a href="productores" style="color: #0284c7; font-weight: 700;">Gestión de Productores</a>, hacé clic en el botón <strong>«QR PDF»</strong> del productor deseado. Se descargará el PDF A4 con su nombre, los datos de contacto disponibles y el QR grande en la misma página, listo para imprimir o compartir. Si actualizás la ficha del productor, volvé a descargar el PDF para obtener los datos nuevos. Al imprimir, conservá el margen blanco alrededor del código para facilitar su lectura.
          </p>
        </div>
      </div>
    </section>

    <!-- ==========================================
         SECCIÓN 6: CATEGORÍAS Y SIMBOLOGÍA
         ========================================== -->
    <section id="categorias" class="card-admin" style="scroll-margin-top: 2rem;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
        <span style="font-size: 1.5rem;">🏷️</span>
        <div>
          <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
            6. Categorías y Simbología Cartográfica
          </h3>
          <p style="margin: 2px 0 0 0; font-size: 0.82rem; color: var(--text-muted);">
            Configuración de colores, íconos vectoriales y filtros temáticos.
          </p>
        </div>
      </div>

      <div style="font-size: 0.92rem; line-height: 1.6; color: var(--text-muted);">
        <p>
          En el módulo <a href="categorias" style="color: #0284c7; font-weight: 700;">Categorías</a>, la Secretaría puede administrar cómo se visualiza cada sector económico en la cartografía y en el catálogo digital.
        </p>

        <ul style="padding-left: 1.2rem; display: flex; flex-direction: column; gap: 0.6rem; margin-top: 0.5rem;">
          <li>
            <strong>Color del Pin (Hexadecimal):</strong> Determina el color cromático del marcador circular sobre el mapa satelital (ej. verde olivo para pecán, ámbar para miel, púrpura para viñedos).
          </li>
          <li>
            <strong>Ícono SVG Vectorial:</strong> Código vectorial incrustado que se dibuja en el centro del marcador de Leaflet, garantizando nitidez perfecta en cualquier nivel de zoom.
          </li>
          <li>
            <strong>Clase CSS de Etiqueta (Tag):</strong> Define el estilo del distintivo (pastilla de color) que acompaña al productor en las tarjetas del catálogo y góndolas.
          </li>
          <li>
            <strong>Orden Numérico:</strong> Controla la posición relativa de la categoría en la barra de filtros del portal público.
          </li>
        </ul>
      </div>
    </section>

    <!-- ==========================================
         SECCIÓN 7: SEGURIDAD Y RESGUARDO
         ========================================== -->
    <section id="seguridad" class="card-admin" style="scroll-margin-top: 2rem;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
        <span style="font-size: 1.5rem;">🛡️</span>
        <div>
          <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
            7. Arquitectura de Seguridad y Resguardo de Datos
          </h3>
          <p style="margin: 2px 0 0 0; font-size: 0.82rem; color: var(--text-muted);">
            Estándares empresariales implementados para proteger los sistemas de la Municipalidad.
          </p>
        </div>
      </div>

      <div style="font-size: 0.92rem; line-height: 1.6; color: var(--text-muted);">
        <p>
          La plataforma cuenta con 6 capas de seguridad diseñadas para operar con máxima estabilidad en servidores compartidos, VPS o infraestructura municipal:
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; margin-top: 1rem;">
          <div style="padding: 0.85rem; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main);">1. Blindaje de Credenciales (env.php)</strong>
            <p style="margin: 0.3rem 0 0 0; font-size: 0.83rem;">
              Las credenciales de base de datos residen en archivos ejecutables protegidos contra lectura web mediante reglas <code>.htaccess</code>.
            </p>
          </div>

          <div style="padding: 0.85rem; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main);">2. Inmunidad SQLi (PDO Prepared)</strong>
            <p style="margin: 0.3rem 0 0 0; font-size: 0.83rem;">
              El 100% de las consultas utilizan sentencias preparadas con parámetros tipados. Ningún dato provisto por usuarios puede alterar la estructura SQL.
            </p>
          </div>

          <div style="padding: 0.85rem; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main);">3. Protección contra Ataques CSRF</strong>
            <p style="margin: 0.3rem 0 0 0; font-size: 0.83rem;">
              Tokens criptográficos de un solo uso en cada formulario POST impiden peticiones no autorizadas desde sitios de terceros.
            </p>
          </div>

          <div style="padding: 0.85rem; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main);">4. Mitigación de Cross-Site Scripting (XSS)</strong>
            <p style="margin: 0.3rem 0 0 0; font-size: 0.83rem;">
              Sanitización rigurosa de texto y atributos con <code>htmlspecialchars(..., ENT_QUOTES, 'UTF-8')</code> antes de cualquier renderizado HTML.
            </p>
          </div>

          <div style="padding: 0.85rem; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main);">5. Contraseñas Cifradas (Bcrypt)</strong>
            <p style="margin: 0.3rem 0 0 0; font-size: 0.83rem;">
              Las claves de administración se almacenan mediante <code>password_hash</code> con costos de derivación modernos. Son irrecuperables en texto plano.
            </p>
          </div>

          <div style="padding: 0.85rem; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border-light);">
            <strong style="color: var(--text-main);">6. Aislamiento y Cabeceras HTTP</strong>
            <p style="margin: 0.3rem 0 0 0; font-size: 0.83rem;">
              Cabeceras <code>X-Frame-Options</code>, <code>X-Content-Type-Options</code> y cookies seguras (<code>HttpOnly</code>, <code>SameSite=Lax</code>).
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ==========================================
         SECCIÓN 8: PREGUNTAS FRECUENTES
         ========================================== -->
    <section id="faq" class="card-admin" style="scroll-margin-top: 2rem;">
      <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; border-bottom: 1px solid var(--border-light); padding-bottom: 0.75rem;">
        <span style="font-size: 1.5rem;">❓</span>
        <div>
          <h3 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--text-main);">
            8. Preguntas Frecuentes y Guía Rápida de Soporte
          </h3>
          <p style="margin: 2px 0 0 0; font-size: 0.82rem; color: var(--text-muted);">
            Respuestas a las situaciones más comunes del día a día administrativo.
          </p>
        </div>
      </div>

      <div style="font-size: 0.92rem; line-height: 1.6; color: var(--text-muted); display: flex; flex-direction: column; gap: 1.2rem;">
        
        <div>
          <strong style="color: var(--text-main);">¿Un productor puede participar en una Góndola Municipal sin estar en la web?</strong>
          <p style="margin: 0.25rem 0 0 0;">
            <strong>No.</strong> Por disposición de la iniciativa municipal, es requisito obligatorio estar publicado en el padrón web oficial de <em>Hecho en San José</em>. De esta forma se asegura la calidad artesanal, trazabilidad y se permite que cualquier cliente frente a la góndola física escanee el código QR oficial del producto para conocer la historia del productor.
          </p>
        </div>

        <div>
          <strong style="color: var(--text-main);">¿Cómo cambio las coordenadas de un productor si se mudó de taller?</strong>
          <p style="margin: 0.25rem 0 0 0;">
            Ingresá a <a href="productores" style="color: #0284c7;">Gestión de Productores</a>, hacé clic en <strong>Editar</strong> en la fila del establecimiento. En el mapa interactivo del formulario, simplemente hacé clic sobre el nuevo domicilio o arrastrá el marcador hasta la ubicación exacta y guardá los cambios.
          </p>
        </div>

        <div>
          <strong style="color: var(--text-main);">¿Puedo exportar el padrón a Excel para armar un informe de gestión?</strong>
          <p style="margin: 0.25rem 0 0 0;">
            Sí. Hacé clic en el botón verde <strong>«⬇️ Exportar CSV»</strong> ubicado en la esquina superior de la tabla de productores o de solicitudes. El archivo generado cuenta con codificación UTF-8 con BOM, lo que garantiza que abre directamente en Microsoft Excel o LibreOffice sin deformar tildes ni caracteres especiales.
          </p>
        </div>

        <div>
          <strong style="color: var(--text-main);">¿Por qué no puedo subir imágenes de más de 5 MB?</strong>
          <p style="margin: 0.25rem 0 0 0;">
            El límite de 5 MB protege la velocidad de carga de la plataforma en teléfonos celulares de turistas que navegan con datos móviles 4G. Si una foto es demasiado pesada, se recomienda reducir su resolución o comprimirla antes de subirla.
          </p>
        </div>

        <div>
          <strong style="color: var(--text-main);">¿Qué ocurre si un productor no atiende al público en su taller?</strong>
          <p style="margin: 0.25rem 0 0 0;">
            Se puede aclarar en el campo <em>Horarios</em> («Atención con cita previa» o «Puntos de venta en Góndolas oficiales»), o bien activar únicamente su presencia en el Catálogo Web e indicar el número de WhatsApp para entregas o envíos a domicilio.
          </p>
        </div>

        <div>
          <strong style="color: var(--text-main);">¿Cómo cerrar sesión de forma segura al terminar el turno?</strong>
          <p style="margin: 0.25rem 0 0 0;">
            Hacé clic en el enlace <strong>«Cerrar Sesión»</strong> en la barra superior derecha. Esto destruye la sesión activa en el servidor y limpia las cookies de autenticación, protegiendo el sistema de accesos no autorizados en terminales compartidas.
          </p>
        </div>

      </div>
    </section>

  </div>

</div>

<?php require_once __DIR__ . '/footer.php'; ?>
