-- ==============================================================================
-- HECHO EN SAN JOSÉ • BASE DE DATOS OFICIAL (MySQL / MariaDB)
-- Ciudad de San José, Entre Ríos, Argentina
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------------------------
-- 1. Tabla de Categorías / Rubros
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `ps_categorias`;
CREATE TABLE `ps_categorias` (
  `id` VARCHAR(50) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `tag_label` VARCHAR(100) NOT NULL,
  `tag_class` VARCHAR(50) NOT NULL,
  `pin_color` VARCHAR(20) NOT NULL,
  `icono_svg` TEXT NOT NULL,
  `orden` INT DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ps_categorias` (`id`, `nombre`, `tag_label`, `tag_class`, `pin_color`, `icono_svg`, `orden`) VALUES
('pecan', 'Agroecología & Nuez Pecán', 'Pecán & Campo', 'tag-pecan', '#059669', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>', 1),
('bebidas', 'Licores, Vinos & Cerveza Artesanal', 'Bebidas Artesanales', 'tag-licores', '#7c3aed', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8"/><path d="M10 2v5l-4 5.5v7.5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-7.5L14 7V2"/></svg>', 2),
('alimentos', 'Alimentos de Origen, Miel, Quesos & Conservas', 'Sabores de Origen', 'tag-miel', '#d97706', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8"/><rect width="14" height="15" x="5" y="5" rx="3"/><path d="M5 10h14"/><path d="M12 13v4"/></svg>', 3),
('artesania', 'Artesanías, Cuero, Fibras & Minerales', 'Artesanía & Identidad', 'tag-artesania', '#be123c', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="6 3 18 3 22 9 12 22 2 9 6 3"></polygon><line x1="2" y1="9" x2="22" y2="9"></line><line x1="12" y1="22" x2="8" y2="9"></line></svg>', 4);

-- ------------------------------------------------------------------------------
-- 2. Tabla de Productores Oficiales
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `ps_productores`;
CREATE TABLE `ps_productores` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(150) NOT NULL,
  `rubro` VARCHAR(200) NOT NULL,
  `categoria_id` VARCHAR(50) NOT NULL,
  `tag_label` VARCHAR(100) NULL,
  `tag_class` VARCHAR(50) NULL,
  `pin_color` VARCHAR(20) NULL,
  `imagen` VARCHAR(255) NOT NULL,
  `icono_svg` TEXT NULL,
  `lat` DECIMAL(10, 8) NOT NULL,
  `lng` DECIMAL(11, 8) NOT NULL,
  `direccion` VARCHAR(255) NOT NULL,
  `telefono` VARCHAR(50) NULL,
  `whatsapp` VARCHAR(50) NOT NULL,
  `horario` VARCHAR(150) NULL,
  `descripcion` TEXT NOT NULL,
  `destacado` TINYINT(1) DEFAULT 0,
  `activo` TINYINT(1) DEFAULT 1,
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX (`categoria_id`),
  INDEX (`activo`),
  CONSTRAINT `fk_ps_productores_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `ps_categorias` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 3. Tabla de Solicitudes de Inscripción (Bandeja de Entrada)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `ps_solicitudes_inscripcion`;
CREATE TABLE `ps_solicitudes_inscripcion` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre_emprendimiento` VARCHAR(150) NOT NULL,
  `nombre_titular` VARCHAR(150) NOT NULL,
  `whatsapp` VARCHAR(50) NOT NULL,
  `email` VARCHAR(150) NULL,
  `rubro` VARCHAR(100) NOT NULL,
  `direccion` VARCHAR(255) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `interes_catalogo` TINYINT(1) DEFAULT 1,
  `interes_mapa` TINYINT(1) DEFAULT 1,
  `interes_gondola` TINYINT(1) DEFAULT 0,
  `interes_ferias` TINYINT(1) DEFAULT 0,
  `estado` ENUM('pendiente', 'aprobada', 'desestimada') DEFAULT 'pendiente',
  `notas_admin` TEXT NULL,
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 4. Tabla de Usuarios Administradores
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `ps_usuarios_admin`;
CREATE TABLE `ps_usuarios_admin` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NULL,
  `ultimo_login` DATETIME NULL,
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 5. Carga de los 11 Productores Auténticos de San José
-- ------------------------------------------------------------------------------
INSERT INTO `ps_productores` (`id`, `nombre`, `rubro`, `categoria_id`, `tag_label`, `tag_class`, `pin_color`, `imagen`, `icono_svg`, `lat`, `lng`, `direccion`, `telefono`, `whatsapp`, `horario`, `descripcion`, `destacado`, `activo`) VALUES
(1, 'Licores Bard', 'Licores Artesanales Tradicionales', 'bebidas', 'Licores desde 1908', 'tag-licores', '#7c3aed', 'assets/productores/licores-bard.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8"/><path d="M10 2v5l-4 5.5v7.5a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-7.5L14 7V2"/></svg>', -32.20780000, -58.22510000, 'Entre Ríos 1046 (e/ 3 de Febrero y Caseros), San José', '+54 9 3447 40-5163', '5493447405163', 'Lun a Sáb: 08:30 a 12:30 y 17:00 a 21:00 hs', 'Fábrica centenaria fundada en 1908. Elaboran licores artesanales tradicionales de yatay, miel de eucalipto, naranja y hierbas sin aditivos ni conservantes químicos.', 1, 1),

(2, 'Establecimiento Los Pecanes', 'Producción Agropecuaria & Casa de Té', 'pecan', 'Pecán & Casa de Té', 'tag-pecan', '#059669', 'assets/productores/establecimiento-los-pecanes.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>', -32.20350000, -58.20320000, 'Ruta 26 (RP 130) Km. 7, San José', '+54 9 3447 43-3929', '5493447433929', 'Mié a Dom: 10:00 a 20:00 hs', 'Plantación pionera de nogales pecán, casa de té y patio cervecero campestre. Visitas guiadas al monte frutal, degustación de nueces y productos regionales.', 1, 1),

(3, 'De los Troncos Petrificados', 'Artesanías & Minerales del Río Uruguay', 'artesania', 'Piedras & Minerales', 'tag-artesania', '#be123c', 'assets/productores/troncos-petrificados.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="6 3 18 3 22 9 12 22 2 9 6 3"></polygon><line x1="2" y1="9" x2="22" y2="9"></line><line x1="12" y1="22" x2="8" y2="9"></line></svg>', -32.19801000, -58.15484000, 'Ruta Prov. 26 Km. 3,5 (Barrio Troncos Petrificados), San José', '+54 9 3447 46-4775', '5493447464775', 'Todos los días: 10:00 a 19:00 hs', 'Reservorio de Selva Gayol. Exposición permanente y venta de maderas petrificadas y piedras semipreciosas (ágatas, amatistas y cuarzos) de las orillas del río Uruguay.', 0, 1),

(4, 'Artesanías El Palmar', 'Artesanías Regionales & Fibras Naturales', 'artesania', 'Artesanías & Fibras', 'tag-artesania', '#e54260', 'assets/productores/artesanias-el-palmar.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>', -32.19409000, -58.23921000, 'Ruta Nacional 14 Km. 158,5, Colonia San José', '+54 9 3447 45-5239', '5493447455239', 'Lun a Sáb: 10:00 a 18:00 hs', 'Establecimiento tradicional con plantación de mates orgánicos, cestería en fibra de palma yatay, tallados en maderas nativas y piezas criollas tejidas.', 0, 1),

(5, 'Nuez Pecán La Reina', 'Frutos Secos & Agroindustria', 'pecan', 'Pecán Premiado', 'tag-pecan', '#059669', 'assets/productores/nuez-pecan-la-reina.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 3c3 4 3 14 0 18"/><path d="M3 12c4-3 14-3 18 0"/></svg>', -32.20276600, -58.20241200, 'Doctor Luis Cettour, San José, Entre Ríos', '+54 9 3447 45-2947', '5493447452947', 'Lun a Dom: 09:00 a 13:00 y 16:00 a 20:00 hs', 'Establecimiento Los Pecanes - La Boutique de la Nuez Pecán. Emprendimiento emblemático distinguido con el Sello de Turismo Industrial y Productivo. Nueces seleccionadas en mitades, garrapiñadas, saladas y bombones rellenos.', 1, 1),

(6, 'Apícola La Sanjosesina', 'Apicultura & Miel Pura', 'alimentos', 'Miel Pura de Monte', 'tag-miel', '#d97706', 'assets/productores/apicola-la-sanjosesina.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8"/><rect width="14" height="15" x="5" y="5" rx="3"/><path d="M5 10h14"/><path d="M12 13v4"/></svg>', -32.20860000, -58.22050000, 'Centenario 1580 (e/ Ituzaingó y Yrigoyen), San José', '+54 9 3447 52-1144', '5493447421144', 'Lun a Vie: 08:30 a 12:30 y 16:30 a 20:00 hs', 'Miel pura de abejas de monte nativo y praderas entrerrianas, propóleo puro, polen y cera cosechados de forma artesanal y sustentable por apicultores locales.', 0, 1),

(7, 'Granja Histórica La Administración', 'Quesería & Tradición Colonial', 'alimentos', 'Quesos & Campo', 'tag-quesos', '#0284c7', 'assets/productores/granja-la-administracion.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/></svg>', -32.21947000, -58.19212000, 'Camino de los Primeros Colonos s/n (Junto al Molino Forclaz), Colonia San José', '+54 9 3447 47-0220', '5493447470220', 'Mar a Dom: 09:30 a 19:00 hs', 'Predio histórico de la colonización de 1857 y antigua administración de Alejo Peyret. Quesos artesanales gouda y sardo, ricota fresca de campo y picadas coloniales.', 1, 1),

(8, 'Dulces Caseros La Juanita', 'Dulces Caseros & Conservas', 'alimentos', 'Dulces & Mermeladas', 'tag-dulces', '#ea580c', 'assets/productores/dulces-la-juanita.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 3h10v3H7z"/><rect x="5" y="6" width="14" height="15" rx="3"/><circle cx="12" cy="13" r="3"/></svg>', -32.21240000, -58.22000000, 'Urquiza 1127 (Frente a Plaza Urquiza / Museo), San José', '+54 9 3447 44-3322', '5493447443322', 'Lun a Sáb: 09:00 a 13:00 y 17:00 a 20:30 hs', 'Mermeladas tradicionales de frutos locales: higos, naranja amarga, frutos del yatay y zapallos en almíbar elaborados a leña en paila de cobre sin aditivos.', 0, 1),

(9, 'Viñedos & Bodega Vulliez Sermet', 'Enoturismo & Vinos de Entre Ríos', 'bebidas', 'Vinos & Enoturismo', 'tag-vinos', '#991b1b', 'assets/productores/bodega-vulliez-sermet.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h4v4H8z"/><path d="M7 6h6l2 4v11a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V10l2-4z"/><circle cx="10" cy="14" r="2"/><path d="M18 10v7a2 2 0 0 1-2 2h0a2 2 0 0 1-2-2v-7h4z"/><path d="M16 19v3"/></svg>', -32.23824000, -58.15890000, 'Ruta Nacional 135 Km 8 (Circuito San José - Colón)', '+54 9 3447 50-5095', '5493447505095', 'Visitas guiadas y degustaciones diarias a las 11:00 y 16:30 hs', 'Pioneros del renacer vitivinícola entrerriano. Viñedos históricos, cavas centenarias y elaboración de varietales Tannat, Malbec, Chardonnay y espumantes.', 1, 1),

(10, 'Cervecería Artesanal El Molino', 'Cervecería & Bebidas', 'bebidas', 'Cerveza Artesanal', 'tag-cerveza', '#b45309', 'assets/productores/cerveceria-el-molino.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 11h1a3 3 0 0 1 0 6h-1"/><path d="M9 12v6"/><path d="M13 12v6"/><path d="M5 8v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8"/></svg>', -32.21020000, -58.21980000, 'Centenario 1361 (Zona Céntrica), San José', '+54 9 3447 48-3344', '5493447483344', 'Mié a Dom: 18:00 a 01:00 hs', 'Punto cervecero artesanal en el centro de San José con maltas entrerrianas y aguas puras de la cuenca. Estilos propios premiados: Dorada Pampeana, Honey con miel isleña y Red Ale.', 1, 1),

(11, 'Cuchillería & Talabartería Sanjo Tradición', 'Artesanías & Tradición Criolla', 'artesania', 'Cuchillos & Cuero', 'tag-artesania', '#e54260', 'assets/productores/sanjo-tradicion-cuchilleria.jpg', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>', -32.21215000, -58.21715000, 'Mitre 1150 (Frente a Plaza Urquiza), San José', '+54 9 3447 43-9911', '5493447439911', 'Lun a Sáb: 09:00 a 13:00 y 17:00 a 20:30 hs', 'Cuchillos artesanales forjados a mano en acero al carbono con cabos de guayacán, asta de ciervo y alpaca. Platería criolla y trabajos artesanales en cuero crudo sobado.', 0, 1);

SET FOREIGN_KEY_CHECKS = 1;

