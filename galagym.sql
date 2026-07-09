-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 09-07-2026 a las 21:36:23
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
-- Estructura de tabla para la tabla `asignacionRutina`
--

CREATE TABLE `asignacionRutina` (
  `id_asignacion` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_rutina` int(11) DEFAULT NULL,
  `fecha_asignacion` date DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_membresia` int(11) DEFAULT NULL,
  `estado` int(1) DEFAULT 1,
  `id_rol` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `cedula`, `nombre`, `apellido`, `telefono`, `correo`, `contrasena`, `id_membresia`, `estado`, `id_rol`) VALUES
(18, '15095615', 'luis', 'alvarado', '04243371838', 'luisalvarado@gmail.com', '$2y$10$F99C10YGeQ.MXNa1wynEp.hf7RN6wDEKurNm4dP1Z9abMjrOLEBD2', NULL, 1, 2),
(28, '11001009', 'Elena', 'Ruizz', '04145556677', 'elena.r@mail.com', '$2y$10$DJOcrYGphGiKNM1CMYgpPuDTHLOE..47upH2a07H2mI.UeijMnClu', 1, 0, 2),
(33, '32600069', 'elena', 'de ereu', '04125734567', 'elenajevadeereu@gmail.com', '$2y$10$F44SGbn8HTB6FAtEoCdAr.Y1W.Rr5gtJvKeIoZrmjYXTD2cbTSq9e', 2, 1, 2),
(34, '11264587', 'LERIDA', 'FIGUEROA', '04128574522', 'uptaeb.lerida.figueroa@gmail.com', '$2y$10$mEHNK0oVM4WIsO2ul73K4.PT.C136Spe.LPCnisC.hpt06IYeHcAe', 1, 1, 2),
(37, '14859745', 'ANA', 'PEREZ', '04125845632', 'anaperez1197@gmail.com', '$2y$10$6eafhAPjwJFPUYfzZUATN.sSFigDdQFERRx5dzGCzjSlTW7Yi.Tme', 3, 0, 2);

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
(1, 1, 1, 4, '10'),
(2, 1, 2, 4, '8'),
(3, 2, 3, 3, '12'),
(4, 3, 4, 3, '10'),
(5, 4, 5, 4, '10'),
(6, 5, 6, 3, '15'),
(7, 6, 7, 4, '10'),
(8, 7, 8, 3, '15'),
(9, 8, 9, 3, '12'),
(10, 9, 10, 4, '20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicio`
--

CREATE TABLE `ejercicio` (
  `id_ejercicio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ejercicio`
--

INSERT INTO `ejercicio` (`id_ejercicio`, `nombre`) VALUES
(1, 'Press Banca'),
(2, 'Sentadilla'),
(3, 'Peso Muerto'),
(4, 'Dominadas'),
(5, 'Remo con barra'),
(6, 'Press Militar'),
(7, 'Zancadas'),
(8, 'Curl Biceps'),
(9, 'Extensiones'),
(10, 'Abdominales'),
(11, 'fondos');

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
(4, '99999999', 'Iron', 'Man', '04128574648', 'sisisi@gmail.com', '$2y$10$RNF39NXbKCJ9qbX0tkWLBeLvTis7DviXNWDG//GCxKKhB/hlGW2Di', 1, 2),
(5, '31560098', 'luisillo', 'elpillo', '04128675678', 'luiselpillo@gmail.com', '$2y$10$EffFLHZGF4V/.MpKOx.qdul7PaS/4uGCxDCNnTEBnAbMoF0yOTthS', 0, 2),
(6, '32046165', 'jose', 'uribe', '04245783165', 'joseuribe@gmail.com', '$2y$10$s5FhnVqyxKvKckeRlU2EOOHebbyF9SdMEZIYFQdyRCVGSzOfeU3vm', 0, 2),
(7, '31560043', 'cristianito', 'ronaldinhjo', '01287873377', 'sisasisas@gmail.com', '$2y$10$qFo1W1k30Pkke.WncgPBhe7GnJcZD4Pp.BCw5F4V/0N/szI..0qQe', 0, 2),
(8, '31560041', 'franchesco', 'ereu', '04128574348', 'ereublade@gmail.com', '$2y$10$xMDhvpuOHmZIINFqgstOw.LHjp1fUpf3bRspYXnOD4brmoumAAuN6', 1, 1),
(9, '31560008', 'administrador', 'admin', '04128675940', 'correo@gmail.com', '$2y$10$L7a1AbBqtyYmdu/A8W.42.R4XO6eRln9eIVZOzzfP..LLSkxOodo2', 1, 1);

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
  `id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rutina`
--

INSERT INTO `rutina` (`id_rutina`, `nombre`, `id_empleado`) VALUES
(1, 'Fuerza A', 4),
(2, 'Hipertrofia B', 4),
(3, 'Resistencia C', 4),
(4, 'Fuerza A', 4),
(5, 'Definicion', 4),
(6, 'Fuerza B', 4),
(7, 'Principiante', 4),
(8, 'Avanzado', 4),
(9, 'Funcional', 4),
(10, 'Pierna', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacionRutina`
--
ALTER TABLE `asignacionRutina`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_rutina` (`id_rutina`),
  ADD KEY `fk_asignacion_empleado` (`id_empleado`);

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
  ADD KEY `id_empleado_entrenador` (`id_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignacionRutina`
--
ALTER TABLE `asignacionRutina`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `detalleRutina`
--
ALTER TABLE `detalleRutina`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ejercicio`
--
ALTER TABLE `ejercicio`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `membresia`
--
ALTER TABLE `membresia`
  MODIFY `id_membresia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_metodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rutina`
--
ALTER TABLE `rutina`
  MODIFY `id_rutina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacionRutina`
--
ALTER TABLE `asignacionRutina`
  ADD CONSTRAINT `asignacionRutina_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `asignacionRutina_ibfk_2` FOREIGN KEY (`id_rutina`) REFERENCES `rutina` (`id_rutina`),
  ADD CONSTRAINT `fk_asignacion_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `rutina_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
