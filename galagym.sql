-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-11-2026 a las 21:42:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `galagym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_membresia` int(11) DEFAULT NULL,
  `estado` int(1) DEFAULT 1,
  `id_rol` int(11) DEFAULT 2,
  `racha_actual` int(11) NOT NULL DEFAULT 0,
  `fecha_ultimo_entrenamiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `cedula`, `nombre`, `apellido`, `telefono`, `correo`, `contrasena`, `id_membresia`, `estado`, `id_rol`, `racha_actual`, `fecha_ultimo_entrenamiento`) VALUES
(38, '32600068', 'Jesus', 'Cordero', '04142345656', 'jesus@gmail.com', '$2y$10$EN66ZCZ4Asy.FPY6RfR5quf13yCWH2Plqq5LhIXJh2u81qwNn6NBS', 1, 1, 2, 1, '2026-11-02'),
(39, '33560098', 'Luis', 'Alvarado', '04127389712', 'luisalvarad@gmail.com', '$2y$10$/GDmk7Pbg6fxkgmnfhtFoOEcKnuMwRjv24FOXhDiakQ6rzOpnRkCG', 1, 1, 2, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleRutina`
--

CREATE TABLE `detalleRutina` (
  `id_detalle` int(11) NOT NULL,
  `id_rutina` int(11) NOT NULL,
  `id_ejercicio` int(11) NOT NULL,
  `series` int(11) NOT NULL,
  `repeticiones` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalleRutina`
--

INSERT INTO `detalleRutina` (`id_detalle`, `id_rutina`, `id_ejercicio`, `series`, `repeticiones`) VALUES
(7, 17, 1, 3, '10'),
(8, 17, 6, 3, '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio`
--

CREATE TABLE `ejercicio` (
  `id_ejercicio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ejercicio`
--

INSERT INTO `ejercicio` (`id_ejercicio`, `nombre`, `imagen`, `descripcion`) VALUES
(1, 'Press Banca', NULL, NULL),
(2, 'Sentadilla', NULL, NULL),
(3, 'Peso Muerto', NULL, NULL),
(4, 'Dominadas', NULL, NULL),
(5, 'Remo con barra', NULL, NULL),
(6, 'Press Militar', NULL, NULL),
(7, 'Zancadas', NULL, NULL),
(8, 'Curl Biceps', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `id_rol` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `cedula`, `nombre`, `apellido`, `telefono`, `correo`, `contrasena`, `estado`, `id_rol`) VALUES
(4, '99999999', 'Iron', 'Man', '04128574648', 'sisisi@gmail.com', '$2y$10$RNF39NXbKCJ9qbX0tkWLBeLvTis7DviXNWDG//GCxKKhB/hlGW2Di', 0, 2),
(5, '31560098', 'luisillo', 'elpillo', '04128675678', 'luiselpillo@gmail.com', '$2y$10$EffFLHZGF4V/.MpKOx.qdul7PaS/4uGCxDCNnTEBnAbMoF0yOTthS', 0, 2),
(6, '32046165', 'jose', 'uribe', '04245783165', 'joseuribe@gmail.com', '$2y$10$s5FhnVqyxKvKckeRlU2EOOHebbyF9SdMEZIYFQdyRCVGSzOfeU3vm', 0, 2),
(7, '31560043', 'cristianito', 'ronaldinhjo', '01287873377', 'sisasisas@gmail.com', '$2y$10$qFo1W1k30Pkke.WncgPBhe7GnJcZD4Pp.BCw5F4V/0N/szI..0qQe', 0, 2),
(8, '31560041', 'Franchesco', 'Ereu', '04128574348', 'ereublade@gmail.com', '$2y$10$gNraKz4t1/YJSEP0iZLkt.aWYmV3jXxLFoH6bhTAIedgOG5ZgQmH2', 1, 1),
(9, '31560008', 'administrador', 'admin', '04128675940', 'correo@gmail.com', '$2y$10$L7a1AbBqtyYmdu/A8W.42.R4XO6eRln9eIVZOzzfP..LLSkxOodo2', 0, 1),
(10, '11254789', 'maria', 'perez', '04128574563', 'maria2026@gmail.com', '$2y$10$VvrKIVw98zz6W5QC/q0WvOua7vUKtsIA66/Y09S976VRzvgaZLwVq', 0, 1),
(11, '31560042', 'Bruce', 'Wayne', '04129573523', 'batman@gmail.com', '$2y$10$LhQfETPnEpew2tkCV50YpeF8P6mvQ0/Pn0FtoH14lnp6YmNhGtePK', 1, 5),
(12, '32560987', 'Jolyne', 'Kujo', '04248573526', 'jolyne@gmail.com', '$2y$10$HFTk1Lp4G/RgkZhPI46kwOrew7lRbm.Hbu0dC9mBLrqYSgvbZMOCG', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membresia`
--

CREATE TABLE `membresia` (
  `id_membresia` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `membresia`
--

INSERT INTO `membresia` (`id_membresia`, `tipo`, `monto`) VALUES
(1, 'Mensualidad Estándar', 30.00),
(2, 'Semanal Estándar', 10.00),
(3, 'Diario Estándar', 3.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id_metodo` int(11) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id_metodo`, `banco`, `cedula`, `telefono`, `status`) VALUES
(2, 'Venezuela', '31560041', '04128574348', 1),
(3, 'Venezuela', '32600068', '04245174317', 0),
(9, 'Zelle', 'galagym@gmail.com', 'Gala Gym', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_membresia` int(11) NOT NULL,
  `referencia` varchar(20) NOT NULL,
  `id_metodo` int(11) NOT NULL,
  `cantidad_periodos` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `fecha`, `monto`, `id_cliente`, `id_membresia`, `referencia`, `id_metodo`, `cantidad_periodos`) VALUES
(12, '2026-10-28', 90.00, 38, 1, '123456789111', 2, 3),
(13, '2026-10-28', 6.00, 38, 3, '123123123123', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`, `descripcion`) VALUES
(1, 'Administrador', 'Acceso a todo el sistema'),
(2, 'Usuario', 'Solo vista sin acceso a gestiones'),
(4, 'Recepcionista', 'Acceso a reportes y gestion de dinero'),
(5, 'Entrenador', 'Gestiona los ejercicios y rutinas de los clientes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutina`
--

CREATE TABLE `rutina` (
  `id_rutina` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rutina`
--

INSERT INTO `rutina` (`id_rutina`, `nombre`, `id_empleado`, `id_cliente`) VALUES
(17, 'Pecho', NULL, 38);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_cliente_membresia` (`id_membresia`),
  ADD KEY `fk_cliente_rol` (`id_rol`);

--
-- Indices de la tabla `detalleRutina`
--
ALTER TABLE `detalleRutina`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_rutina` (`id_rutina`),
  ADD KEY `id_ejercicio` (`id_ejercicio`);

--
-- Indices de la tabla `ejercicio`
--
ALTER TABLE `ejercicio`
  ADD PRIMARY KEY (`id_ejercicio`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_empleado_rol` (`id_rol`);

--
-- Indices de la tabla `membresia`
--
ALTER TABLE `membresia`
  ADD PRIMARY KEY (`id_membresia`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id_metodo`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_cliente_pago` (`id_cliente`),
  ADD KEY `fk_membresia_pago` (`id_membresia`),
  ADD KEY `fk_pago_metodo` (`id_metodo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `rutina`
--
ALTER TABLE `rutina`
  ADD PRIMARY KEY (`id_rutina`),
  ADD KEY `id_empleado_entrenador` (`id_empleado`),
  ADD KEY `fk_rutina_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `detalleRutina`
--
ALTER TABLE `detalleRutina`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ejercicio`
--
ALTER TABLE `ejercicio`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `membresia`
--
ALTER TABLE `membresia`
  MODIFY `id_membresia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_metodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `rutina`
--
ALTER TABLE `rutina`
  MODIFY `id_rutina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_membresia` FOREIGN KEY (`id_membresia`) REFERENCES `membresia` (`id_membresia`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cliente_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `detalleRutina`
--
ALTER TABLE `detalleRutina`
  ADD CONSTRAINT `detalleRutina_ibfk_1` FOREIGN KEY (`id_rutina`) REFERENCES `rutina` (`id_rutina`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalleRutina_ibfk_2` FOREIGN KEY (`id_ejercicio`) REFERENCES `ejercicio` (`id_ejercicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_cliente_pago` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_membresia_pago` FOREIGN KEY (`id_membresia`) REFERENCES `membresia` (`id_membresia`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pago_metodo` FOREIGN KEY (`id_metodo`) REFERENCES `metodos_pago` (`id_metodo`);

--
-- Filtros para la tabla `rutina`
--
ALTER TABLE `rutina`
  ADD CONSTRAINT `fk_rutina_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rutina_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
