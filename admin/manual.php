<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • MANUAL DE USUARIO INSTITUCIONAL
 * ==============================================================================
 */
require_once 'auth.php';
$currentPage = 'manual.php';
?>
<?php include 'header.php'; ?>

<main class="admin-main">
  <div class="admin-topbar">
    <div>
      <h2 class="admin-page-title">Manual de Usuario y Seguridad</h2>
      <p class="admin-page-desc">Documentación oficial del sistema de gestión turística y productiva de la Municipalidad de San José.</p>
    </div>
  </div>

  <div class="admin-content-grid" style="grid-template-columns: 1fr; max-width: 900px; margin: 0 auto;">
    
    <!-- Seguridad del Sistema -->
    <div class="admin-card">
      <h3 class="admin-card-title" style="display: flex; align-items: center; gap: 8px;">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-primary);"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Seguridad de la Plataforma
      </h3>
      <div class="admin-card-body" style="font-size: 0.95rem; line-height: 1.6; color: var(--text-muted);">
        <p style="margin-bottom: 1rem;">El sistema <strong>Hecho en San José</strong> cuenta con múltiples capas de seguridad de nivel empresarial para garantizar la integridad de los datos públicos y municipales:</p>
        
        <ul style="list-style-type: none; padding: 0; display: flex; flex-direction: column; gap: 1rem;">
          <li>
            <strong>1. Protección de Credenciales (Blindaje env.php):</strong><br>
            Las contraseñas de la base de datos están alojadas en un archivo ejecutable (<code>env.php</code>) blindado contra accesos web directos. No pueden ser expuestas mediante errores de configuración del servidor.
          </li>
          <li>
            <strong>2. Inmunidad contra Inyecciones SQL (SQLi):</strong><br>
            Absolutamente todas las consultas utilizan <em>Consultas Preparadas (PDO)</em>. Cualquier intento de inyección de código malicioso en el buscador o formularios es bloqueado sistemáticamente, tratando los inputs como texto inofensivo.
          </li>
          <li>
            <strong>3. Bloqueo contra Secuestro de Formularios (Protección CSRF):</strong><br>
            Cada acción de modificación de datos utiliza tokens criptográficos de un solo uso. Esto imposibilita que agentes externos o sitios maliciosos realicen acciones en nombre de un administrador autenticado.
          </li>
          <li>
            <strong>4. Protección Avanzada de Sesiones:</strong><br>
            Se implementa mitigación contra fijación de sesiones mediante regeneración de ID (<code>session_regenerate_id</code>), y las cookies de autenticación están configuradas con banderas de estricta seguridad (<code>HttpOnly</code>, <code>SameSite=Lax</code>).
          </li>
          <li>
            <strong>5. Contraseñas Cifradas (Hashing):</strong><br>
            Las credenciales de los administradores se almacenan cifradas en un solo sentido con los algoritmos más modernos. Ningún administrador de sistemas puede conocer las contraseñas reales.
          </li>
          <li>
            <strong>6. Defensa contra XSS (Cross-Site Scripting):</strong><br>
            Toda la información proveniente de productores o usuarios es sanitizada rigurosamente con <code>htmlspecialchars()</code> antes de ser renderizada en el portal público, protegiendo a todos los visitantes.
          </li>
        </ul>
      </div>
    </div>

    <!-- Gestión del Mapa y Catálogo -->
    <div class="admin-card" style="margin-top: 1.5rem;">
      <h3 class="admin-card-title">Gestión de Productores (Mapa y Catálogo)</h3>
      <div class="admin-card-body" style="font-size: 0.95rem; line-height: 1.6; color: var(--text-muted);">
        <p>El módulo de Gestión de Productores permite mantener actualizada la cartografía interactiva y el catálogo digital de la ciudad.</p>
        <ul style="margin-top: 0.8rem; padding-left: 1.2rem; display: flex; flex-direction: column; gap: 0.5rem;">
          <li><strong>Alta de Productor:</strong> Permite ingresar los datos comerciales, ubicación geográfica (con un mapa interactivo para posicionar el pin) y subir una fotografía representativa que se escalará automáticamente.</li>
          <li><strong>Destacar Productores:</strong> La opción "Productor Destacado" otorga prioridad visual en el Catálogo Digital, ubicando al productor al principio de la lista.</li>
          <li><strong>Estado (Activo/Inactivo):</strong> Permite ocultar temporalmente un productor sin necesidad de eliminar sus datos permanentemente de la base.</li>
        </ul>
      </div>
    </div>

    <!-- Gestión de Categorías -->
    <div class="admin-card" style="margin-top: 1.5rem;">
      <h3 class="admin-card-title">Categorías y Simbología Geográfica</h3>
      <div class="admin-card-body" style="font-size: 0.95rem; line-height: 1.6; color: var(--text-muted);">
        <p>Las categorías dictaminan cómo se representa cada productor tanto visual como lógicamente.</p>
        <ul style="margin-top: 0.8rem; padding-left: 1.2rem; display: flex; flex-direction: column; gap: 0.5rem;">
          <li><strong>Color del Pin:</strong> Código de color hexadecimal que definirá el marcador en el Mapa Interactivo.</li>
          <li><strong>Ícono SVG:</strong> Código vectorial (HTML) que se renderiza dentro del marcador geográfico.</li>
          <li><strong>Clase Etiqueta:</strong> Clase CSS utilizada para estilar los distintivos (tags) en la visualización del Catálogo y Góndolas.</li>
        </ul>
      </div>
    </div>

    <!-- Gestión de Solicitudes -->
    <div class="admin-card" style="margin-top: 1.5rem; margin-bottom: 3rem;">
      <h3 class="admin-card-title">Solicitudes de Inscripción Ciudadana</h3>
      <div class="admin-card-body" style="font-size: 0.95rem; line-height: 1.6; color: var(--text-muted);">
        <p>Bandeja de entrada para las postulaciones provenientes del formulario público de "Inscribí tu Negocio".</p>
        <ul style="margin-top: 0.8rem; padding-left: 1.2rem; display: flex; flex-direction: column; gap: 0.5rem;">
          <li><strong>Revisión:</strong> Las solicitudes ingresan con estado "Pendiente". El personal municipal debe revisar los antecedentes antes de proceder a la homologación oficial.</li>
          <li><strong>Transición:</strong> Una vez homologado, el administrador deberá dar de alta manualmente al productor utilizando los datos provistos en la solicitud. La plataforma no publica automáticamente sin mediación municipal.</li>
        </ul>
      </div>
    </div>

  </div>
</main>

<?php include 'footer.php'; ?>
