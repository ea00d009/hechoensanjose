<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscribí tu Negocio - Hecho en San José &bull; Registro de Productores</title>
  <meta name="description" content="Formulario de inscripción para emprendedores y productores de San José, Entre Ríos. Sumate al catálogo oficial, al mapa productivo y a las góndolas municipales.">
  
  <!-- Tipografía Google Fonts optimizada -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap">

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="assets/css/normalized.css">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📝</text></svg>">
  <!-- Script para prevenir parpadeo de modo oscuro (Zero FOUC) -->
  <script>
    (function() {
      try {
        const savedTheme = localStorage.getItem('sanjose-theme');
        if (savedTheme) {
          document.documentElement.setAttribute('data-theme', savedTheme);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
          document.documentElement.setAttribute('data-theme', 'dark');
        }
      } catch (e) {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
          document.documentElement.setAttribute('data-theme', 'dark');
        }
      }
    })();
  </script>
</head>
<body>

  <!-- Barra Superior Institucional -->
  <header class="site-header">

    <!-- Navegación Principal -->
    <div class="header-main">
      <div class="logo-group">
        <a href="./" class="logo-link-wrap" title="Municipalidad de San José, Entre Ríos">
          <img src="assets/logo-sanjose.png" alt="Municipalidad de San José, Entre Ríos" class="municipal-logo">
        </a>
        <div class="logo-divider"></div>
        <div class="logo-titles">
          <h1>Hecho en <span>San José</span></h1>
          <div class="logo-subtitle">Secretaría de Educación, Cultura y Turismo</div>
        </div>
      </div>

      <div class="header-right-group">
        <nav class="nav-actions" id="main-nav-actions">
          <div class="s-b131259d nav-subpages-links">
            <a href="./" class="btn btn-outline s-894fcfb8">Inicio</a>
            <a href="catalogo" class="btn btn-outline s-894fcfb8">Catálogo</a>
            <a href="gondola" class="btn btn-outline s-894fcfb8">Góndolas</a>
            <a href="mapa" class="btn btn-accent s-cdd7a746">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon>
                <line x1="9" y1="3" x2="9" y2="18"></line>
                <line x1="15" y1="6" x2="15" y2="21"></line>
              </svg>
              <span>Ver Mapa</span>
            </a>
          </div>

          <div class="social-links-minimal">
            <a href="https://www.instagram.com/turismosanjose/" target="_blank" rel="noopener" class="social-btn-minimal social-instagram" title="Instagram Oficial @turismosanjose" aria-label="Instagram">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
            </a>
            <a href="http://www.facebook.com/turismosanjose" target="_blank" rel="noopener" class="social-btn-minimal social-facebook" title="Facebook Oficial @turismosanjose" aria-label="Facebook">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
            </a>
          </div>
        </nav>

        <div class="header-ctrl-btns">
          <button class="theme-toggle-btn" id="theme-toggle-btn" aria-label="Cambiar entre modo claro y oscuro" title="Cambiar tema">
            <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
            </svg>
            <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="4"></circle>
              <path d="M12 2v2"></path>
              <path d="M12 20v2"></path>
              <path d="m4.93 4.93 1.41 1.41"></path>
              <path d="m17.66 17.66 1.41 1.41"></path>
              <path d="M2 12h2"></path>
              <path d="M20 12h2"></path>
              <path d="m6.34 17.66-1.41 1.41"></path>
              <path d="m19.07 4.93-1.41 1.41"></path>
            </svg>
          </button>

          <button class="mobile-menu-toggle" id="mobile-menu-btn" aria-label="Abrir menú de navegación" aria-expanded="false">
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Hero de Inscripción -->
  <section class="hero-section s-32f514d0">
    <div class="hero-container s-7b1c691d">
      <div class="s-e5ccebc6">
        <div class="hero-badge-initiative s-703efecc">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M7 7h10"></path><path d="M7 12h10"></path><path d="M7 17h6"></path></svg>
          <span>Convocatoria Abierta Permanente</span>
        </div>
        <h1 class="page-hero-title">
          Inscribí tu Emprendimiento en <span class="highlight">«Hecho en San José»</span>
        </h1>
        <p class="page-hero-desc">
          Si producís en San José o sus colonias, sumate a la plataforma oficial. Impulsamos tu visibilidad turística, incorporamos tus productos en las góndolas municipales y te integramos en el mapa productivo interactivo.
        </p>
      </div>
    </div>
  </section>

  <!-- Contenedor Principal: Beneficios + Formulario -->
  <main class="s-869dbcd9">
    
    <!-- Cuadrícula de Beneficios -->
    <div class="s-fb88b799">
      <div class="s-c2f0f551">
        <div class="s-365d1716">🌐</div>
        <h4 class="s-a372f16a">Difusión Oficial</h4>
        <p class="s-f7fea560">Presencia destacada en el portal de turismo y redes municipales sin costo.</p>
      </div>
      <div class="s-c2f0f551">
        <div class="s-365d1716">🗺️</div>
        <h4 class="s-a372f16a">Mapa Interactivo</h4>
        <p class="s-f7fea560">Georreferenciación en el mapa con contacto directo a WhatsApp y GPS.</p>
      </div>
      <div class="s-c2f0f551">
        <div class="s-365d1716">🛒</div>
        <h4 class="s-a372f16a">Góndolas Exclusivas</h4>
        <p class="s-f7fea560">Acceso a espacios de venta en supermercados y centros turísticos.</p>
      </div>
      <div class="s-c2f0f551">
        <div class="s-365d1716">🎗️</div>
        <h4 class="s-a372f16a">Sello de Origen</h4>
        <p class="s-f7fea560">Certificación oficial de calidad y producción autóctona sanjosesina.</p>
      </div>
    </div>

    <!-- Formulario de Adhesión -->
    <div class="form-card-box s-857c447c" id="form-card-container">
      
      <div class="s-9ca62dfb">
        <h2 class="s-d1273b10">Formulario de Registro y Adhesión</h2>
        <p class="s-10a9a526">Completá los datos de tu emprendimiento para ser evaluado por el equipo técnico municipal.</p>
      </div>

      <form id="registro-form" onsubmit="handleFormSubmit(event)">

        <!-- Sección 1: Datos del Titular -->
        <div class="s-2579959f">
          <h3 class="s-94257d2d">
            <span class="s-9c542b74">1</span>
            <span>Datos del Titular / Responsable</span>
          </h3>
          <div class="form-two-col s-f76dfa49">
            <div>
              <label class="s-65bd4b79">Nombre y Apellido *</label>
              <input type="text" name="nombre_titular" required placeholder="Ej. Martina Baccón" class="search-input s-50ca1596">
            </div>
            <div>
              <label class="s-65bd4b79">DNI o CUIT *</label>
              <input type="text" name="dni_cuit" required placeholder="Ej. 20-34567890-4" class="search-input s-50ca1596">
            </div>
            <div>
              <label class="s-65bd4b79">Teléfono Celular / WhatsApp *</label>
              <input type="tel" name="whatsapp" required placeholder="Ej. +54 9 3447 45-1234" class="search-input s-50ca1596">
            </div>
            <div>
              <label class="s-65bd4b79">Correo Electrónico</label>
              <input type="email" name="email" placeholder="nombre@ejemplo.com" class="search-input s-50ca1596">
            </div>
          </div>
        </div>

        <!-- Sección 2: Datos del Emprendimiento -->
        <div class="s-447af6b5">
          <h3 class="s-94257d2d">
            <span class="s-9c542b74">2</span>
            <span>Datos del Emprendimiento o Marca</span>
          </h3>
          <div class="form-two-col s-f76dfa49">
            <div>
              <label class="s-65bd4b79">Nombre del Emprendimiento / Marca *</label>
              <input type="text" name="nombre_emprendimiento" required placeholder="Ej. Alfajores y Dulces La Colonia" class="search-input s-50ca1596">
            </div>
            <div>
              <label class="s-65bd4b79">Rubro Productivo *</label>
              <select name="rubro" required class="search-input s-3e4d5f5d">
                <option value="">Seleccioná un rubro...</option>
                <option value="Agroecología & Nuez Pecán">Agroecología & Nuez Pecán</option>
                <option value="Licores, Vinos & Cerveza Artesanal">Licores, Vinos & Cerveza Artesanal</option>
                <option value="Apicultura & Miel Pura">Apicultura & Miel Pura</option>
                <option value="Quesería & Lácteos de Campo">Quesería & Lácteos de Campo</option>
                <option value="Dulces Caseros & Conservas">Dulces Caseros & Conservas</option>
                <option value="Artesanías, Cuero & Cuchillería">Artesanías, Cuero & Cuchillería</option>
                <option value="Piedras Semipreciosas & Fibras">Piedras Semipreciosas & Fibras</option>
                <option value="Otro rubro artesanal">Otro rubro artesanal</option>
              </select>
            </div>
            <div class="s-e86cdd0b">
              <label class="s-65bd4b79">Dirección del Establecimiento / Taller en San José *</label>
              <input type="text" name="direccion" required placeholder="Calle, número o camino rural de referencia" class="search-input s-50ca1596">
            </div>
            <div class="s-e86cdd0b">
              <label class="s-65bd4b79">Descripción de los Productos y Materias Primas Locales *</label>
              <textarea name="descripcion" required rows="4" placeholder="Contanos qué producís, qué insumos utilizás de nuestra región y cómo elaborás tus productos..." class="search-input s-1706339d"></textarea>
            </div>
          </div>
        </div>

        <!-- Sección 3: Interés en el Programa -->
        <div class="s-447af6b5">
          <h3 class="s-94257d2d">
            <span class="s-9c542b74">3</span>
            <span>¿En qué módulos te interesa participar?</span>
          </h3>
          <div class="s-e4b1745b">
            <label class="form-interest-label s-0f0488e7">
              <input type="checkbox" name="interes_catalogo" value="1" checked class="s-f595019a">
              <span>Publicación en el <strong>Catálogo Web Oficial</strong> con contacto directo a WhatsApp</span>
            </label>
            <label class="form-interest-label s-0f0488e7">
              <input type="checkbox" name="interes_mapa" value="1" checked class="s-f595019a">
              <span>Georreferenciación en el <strong>Mapa Productivo Interactivo</strong> de Turismo</span>
            </label>
            <label class="form-interest-label s-0f0488e7">
              <input type="checkbox" name="interes_gondola" value="1" checked class="s-f595019a">
              <span>Venta en las <strong>Góndolas Municipales</strong> en comercios y supermercados</span>
            </label>
            <label class="form-interest-label s-0f0488e7">
              <input type="checkbox" name="interes_ferias" value="1" class="s-f595019a">
              <span>Participación en <strong>Ferias de Emprendedores y Fiestas Tradicionales</strong></span>
            </label>
          </div>
        </div>

        <!-- Botón de Envío -->
        <div class="s-545f76ce">
          <button type="submit" class="btn btn-accent s-c711011d">
            <span>Enviar Solicitud de Registro &rarr;</span>
          </button>
        </div>
      </form>

      <!-- Mensaje de Ã‰xito Oculto por defecto -->
      <div id="mensaje-exito" class="s-cf8b9e09">
        <div class="s-c65b13db">
          <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h3 class="s-7acbb626">¿Solicitud enviada con éxito!</h3>
        <p class="s-df0fb330">
          Tu inscripción al programa <strong>«Hecho en San José»</strong> fue registrada. El equipo de la Secretaría de Educación, Cultura y Turismo revisará la información y se comunicará vía WhatsApp para coordinar la visita y validación del sello de origen.
        </p>
        <div class="s-d3e82f29">
          <a href="catalogo" class="btn btn-outline">Ver Catálogo de Negocios</a>
          <a href="mapa" class="btn btn-primary">Ver Mapa Productivo</a>
        </div>
      </div>

    </div>
  </main>

  <!-- Pie de Página Institucional -->
  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-brand">
        <div class="footer-logo-card">
          <img src="assets/logo-sanjose.png" alt="Municipalidad de San José, Entre Ríos">
        </div>
        <h4>Turismo San José &bull; Hecho en San José</h4>
        <p>
          Iniciativa de la Municipalidad de San José, Entre Ríos. Programa de fomento del consumo de cercanía y fortalecimiento del sector productivo y artesanal en armonía con el desarrollo turístico.
        </p>
        <div class="footer-social-wrap">
          <span class="footer-social-title">Redes Oficiales:</span>
          <div class="social-links-minimal">
            <a href="https://www.instagram.com/turismosanjose/" target="_blank" rel="noopener" class="social-btn-minimal social-btn-footer social-instagram" title="Instagram @turismosanjose" aria-label="Instagram">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
            </a>
            <a href="http://www.facebook.com/turismosanjose" target="_blank" rel="noopener" class="social-btn-minimal social-btn-footer social-facebook" title="Facebook @turismosanjose" aria-label="Facebook">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
            </a>
          </div>
        </div>
      </div>
      <div class="footer-col">
        <h5>Módulos del Programa</h5>
        <ul class="footer-links">
          <li><a href="./">Inicio</a></li>
          <li><a href="catalogo">Catálogo de Negocios</a></li>
          <li><a href="gondola">Encontrá la Góndola</a></li>
          <li><a href="inscribir">Inscribí tu Negocio</a></li>
          <li><a href="mapa">Mapa Productivo Interactivo</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Contacto Municipal</h5>
        <ul class="footer-links">
          <li><a href="#">Secretaría de Turismo</a></li>
          <li><a href="#">Centenario y Entre Ríos</a></li>
          <li><a href="#">turismo@sanjose.tur.ar</a></li>
          <li><a href="#">San José, Entre Ríos (CP 3280)</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <div>&copy; 2026 Municipalidad de San José, Entre Ríos. Todos los derechos reservados.</div>
      <div class="s-b512c985">
        <span class="s-b32654dc">Gestión Municipal</span>
        <a href="admin/login" class="btn-admin-access" title="Acceso al Panel de Gestión" class="s-de742dc8">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
          </svg>
          <span>Panel de Gestión</span>
        </a>
      </div>
    </div>
  </footer>

  <script src="app.js"></script>
  <script>
    async function handleFormSubmit(e) {
      e.preventDefault();
      const form = document.getElementById('registro-form');
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;

      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span>Enviando solicitud...</span>';

      const formData = new FormData(form);

      try {
        let res = await fetch('api/inscribir', {
          method: 'POST',
          body: formData
        });

        // Fallback a api/inscribir.php si el servidor no tiene mod_rewrite activo
        if (!res.ok && res.status === 404) {
          res = await fetch('api/inscribir.php', {
            method: 'POST',
            body: formData
          });
        }

        let data = {};
        try {
          data = await res.json();
        } catch (jsonErr) {
          throw new Error('Respuesta inválida del servidor.');
        }

        if (res.ok && data.success) {
          document.getElementById('registro-form').style.display = 'none';
          document.getElementById('mensaje-exito').style.display = 'block';
          document.getElementById('mensaje-exito').scrollIntoView({ behavior: 'smooth' });
        } else {
          alert(data.error || 'Hubo un inconveniente al enviar la solicitud. Por favor verificá los datos ingresados.');
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalText;
        }
      } catch (err) {
        console.error('Error al enviar la solicitud de inscripción:', err);
        alert('No se pudo completar el envío de la solicitud. Por favor verificá tu conexión a internet e intentalo nuevamente.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
      }
    }
  </script>
</body>
</html>
