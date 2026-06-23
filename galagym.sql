-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-06-2026 a las 14:59:32
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
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `nombre_cargo`) VALUES
(1, 'Administrador'),
(2, 'Entrenador'),
(3, 'Recepcionista');

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
(3, '32600068', 'jesus', 'corderoo', '044444', 'jesus@hotmail.com', 'CONSULTAR Eliminar', 2, 0, 2),
(12, '31560041', 'franchesco', 'ereuu', '04128574348', 'ereublade@gmail.com', '', 2, 1, 2),
(14, '31560042', 'franchesco', 'ereu', '04128574348', 'nosenose@gmail.com', 'sisisisi', NULL, 0, 2),
(15, '34560098', 'elcapitan', 'rogerss', '04227866766', 'capitan@gmail.com', '', 1, 1, 2),
(16, '320494994', 'djfjfjfjjfj', 'jfjfjfjfjf', '22222222222', 'sssssssssss@gmail.com', 'dddddddd', NULL, 0, 2),
(17, '21560042', 'franchesquino', 'franchesquines', '04126786464', 'ereuebladee@gmail.com', 'jejejejjejeje', NULL, 0, 2),
(18, '15095615', 'luis', 'alvarado', '04243371838', 'luisalvarado@gmail.com', 'luisluisluis', 4, 1, 2),
(19, '314509876', 'pedro', 'montilla da silva', '04146785480', 'pedro@gmail.com', 'jdjdjdjdjd', 5, 0, 2),
(20, '11001001', 'Juan', 'Perez', '04141112233', 'juan.p@mail.com', '1234', 1, 1, 2),
(21, '11001002', 'Juan', 'Gomez', '04144445566', 'juan.g@mail.com', '1234', 2, 1, 2),
(22, '11001003', 'Maria', 'Lopez', '04147778899', 'maria.l@mail.com', '1234', 1, 1, 2),
(23, '11001004', 'Pedro', 'Ruiz', '04140001122', 'pedro.r@mail.com', '1234', 3, 1, 2),
(24, '11001005', 'Ana', 'Soto', '04143334455', 'ana.s@mail.com', '1234', 1, 1, 2),
(25, '11001006', 'Luis', 'Diaz', '04146667788', 'luis.d@mail.com', '1234', 2, 1, 2),
(26, '11001007', 'Sofia', 'Vega', '04149990011', 'sofia.v@mail.com', '1234', 4, 1, 2),
(27, '11001008', 'Carlos', 'Mora', '04142223344', 'carlos.m@mail.com', '1234', 5, 1, 2),
(28, '11001009', 'Elena', 'Ruiz', '04145556677', 'elena.r@mail.com', '1234', 1, 1, 2),
(29, '11001010', 'Jose', 'Perez', '04148889900', 'jose.p@mail.com', '1234', 2, 1, 2),
(30, '31930248', 'luis', 'durannn', '04145229957', 'luisalvaradod-2006@hotmail.com', '', 3, 1, 2),
(31, '45679908', 'cristiano', 'ronaldo', '04120000000', 'sisassisas@gmail.com', 'sssssssssssss', 6, 0, 2);

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
(1, 'Press Bancaaa'),
(2, 'Sentadilla'),
(3, 'Peso Muerto'),
(4, 'Dominadas'),
(5, 'Remo con barra'),
(6, 'Press Militar'),
(7, 'Zancadas'),
(8, 'Curl Biceps'),
(9, 'Extensiones'),
(10, 'Abdominales'),
(11, 'fondos'),
(13, 'Remo Unilateral');

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
  `id_cargo` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `id_rol` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `cedula`, `nombre`, `apellido`, `telefono`, `correo`, `contrasena`, `id_cargo`, `estado`, `id_rol`) VALUES
(4, '99999999', 'Iron', 'Mannn', '04128574648', 'sisisi@gmail.com', '', 2, 1, 2),
(5, '31560098', 'luisillo', 'ereu', '04128675678', 'luiselpillo@gmail.com', 'megustanloshombres', 2, 1, 2),
(6, '32046165', 'jose', 'uribe', '04245783165', 'joseuribe@gmail.com', 'soyelmasgei', 3, 1, 2),
(7, '31560043', 'cristianito', 'ronaldinhjo', '01287873377', 'sisasisas@gmail.com', 'sssssssssssssss', 1, 0, 2);

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
(3, 'Diario Estándar', 3.00),
(4, 'Convenio: Cardenales', 0.00),
(5, 'Convenio: PromarTV', 0.00),
(6, 'Convenio: Emisora', 0.00),
(7, 'Convenio: Academia Básquet', 0.00),
(8, 'Convenio: Gratis', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id_metodo` int(11) NOT NULL,
  `banco` varchar(100) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id_metodo`, `banco`, `cedula`, `telefono`) VALUES
(2, 'Venezuela', '31560041', '04128574348'),
(3, 'Venezuela', '32600068', '04245174317');

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
  `id_metodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id_pago`, `fecha`, `monto`, `id_cliente`, `id_membresia`, `referencia`, `id_metodo`) VALUES
(2, '2026-06-12', 3.00, 3, 1, '123456789122', 2),
(3, '2026-06-10', 50.00, 3, 1, 'REF001', 3),
(4, '2026-06-11', 80.00, 12, 2, 'REF002', 2);

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
(4, 'Recepcionista', 'Acceso a reportese'),
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
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

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
  ADD KEY `fk_empleado_cargo` (`id_cargo`),
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
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `detalleRutina`
--
ALTER TABLE `detalleRutina`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ejercicio`
--
ALTER TABLE `ejercicio`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `membresia`
--
ALTER TABLE `membresia`
  MODIFY `id_membresia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id_metodo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `fk_empleado_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`),
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
