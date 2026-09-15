<?php
/**
 * ==============================================================================
 * HECHO EN SAN JOSÉ • PIE DE PÁGINA DEL PANEL DE ADMINISTRACIÓN
 * ==============================================================================
 */
?>
  </main>

  <footer style="margin-top: 4rem; padding: 2rem 1.5rem; text-align: center; border-top: 1px solid var(--border-light, #e2e8f0); color: var(--text-muted, #64748b); font-size: 0.82rem;">
    <div>&copy; 2026 Municipalidad de San José, Entre Ríos &bull; Sistema de Gestión de Productores</div>
    <div style="margin-top: 4px; opacity: 0.8;">Secretaría de Educación, Cultura y Turismo</div>
  </footer>

  <!-- Script de modo oscuro para el panel -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const toggleBtn = document.getElementById('admin-theme-toggle');
      if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
          const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
          const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
          document.documentElement.setAttribute('data-theme', newTheme);
          try {
            localStorage.setItem('sanjose-theme', newTheme);
          } catch(e) {}
        });
      }
    });
  </script>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</body>
</html>
