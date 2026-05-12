-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2026 a las 17:44:20
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
-- Base de datos: `centro_salud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnosticos`
--

CREATE TABLE `diagnosticos` (
  `id` int(11) NOT NULL,
  `dni_paciente` int(11) NOT NULL,
  `dni_medico` int(11) NOT NULL,
  `temperatura` decimal(4,1) DEFAULT NULL,
  `oximetria` decimal(4,1) DEFAULT NULL,
  `pulso` int(11) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `diagnosticos`
--

INSERT INTO `diagnosticos` (`id`, `dni_paciente`, `dni_medico`, `temperatura`, `oximetria`, `pulso`, `fecha`) VALUES
(19, 123456789, 123456789, 36.2, NULL, NULL, '2025-05-13'),
(20, 123456789, 123456789, 36.9, NULL, NULL, '2025-05-13'),
(21, 123456789, 123456789, 36.3, NULL, NULL, '2025-05-13'),
(22, 123456789, 123456789, 36.9, NULL, NULL, '2025-05-13'),
(23, 123456789, 123456789, 36.4, NULL, NULL, '2025-05-13'),
(24, 123456789, 123456789, 37.0, NULL, NULL, '2025-05-13'),
(25, 123456789, 123456789, 36.6, NULL, NULL, '2025-05-13'),
(26, 123456789, 123456789, 36.5, NULL, NULL, '2025-05-13'),
(27, 123456789, 123456789, 36.7, NULL, NULL, '2025-05-13'),
(28, 123456789, 123456789, 36.4, NULL, NULL, '2025-05-13'),
(29, 123456789, 123456789, 36.8, NULL, NULL, '2025-05-13'),
(30, 123456789, 123456789, 36.2, NULL, NULL, '2025-05-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `estado`, `fecha`) VALUES
(1, 1, '2025-06-05 02:33:54'),
(2, 0, '2025-06-05 02:33:56'),
(3, 1, '2025-06-05 02:34:03'),
(4, 0, '2025-06-05 02:34:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_chequeo`
--

CREATE TABLE `estado_chequeo` (
  `id` int(11) NOT NULL,
  `chequeo_activo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_chequeo`
--

INSERT INTO `estado_chequeo` (`id`, `chequeo_activo`) VALUES
(1, 'temperatura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id` int(11) NOT NULL,
  `nombre_comercial` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `dni` int(11) NOT NULL CHECK (`dni` > 1000000),
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`dni`, `nombre`, `apellido`, `contrasena`) VALUES
(47290612, 'dylan', 'gaston', '2882'),
(47761000, 'dylan', 'maidana', '1234'),
(47781048, 'Mauruto', 'Gamer', '4621'),
(123456789, 'no', 'si', '2222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `dni` int(11) NOT NULL CHECK (`dni` > 1000000),
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`dni`, `nombre`, `apellido`, `contrasena`) VALUES
(5745866, 'juan', 'juancho', '5555'),
(11111111, 'Paciente', 'Anonimo', '3333'),
(22222222, 'YYYY', 'HHHHH', '$2y$10$bGPCGJ6SOJc8uFbSmrZEJeYo7LP9qw9/AKu9D3zPHkgBnMuPultKu'),
(44444444, 'HHHH', 'DDDDD', '$2y$10$3AMwNQcY828nShPyCQc3y.3bp/FfznXcPfE4wpCstqfj2m4u83d.a'),
(46838233, 'Agustina ', 'Gonzalez', '2030'),
(47105053, 'Maximo', 'Benelli', '2006'),
(47290611, 'D', 'GF', '2882'),
(47290612, 'DY', 'FR', '$2y$10$3SOFZED5k0vOFSzvMPvoLuCUCVxer2WOrlf6b.cDfAyGoOuRUaeAK'),
(47290615, 'DYLAN', 'FRANCO', '2888'),
(47440053, 'FRANCO', 'BRINGAS', '$2y$10$m8QOHG1T5X8pkUlviy8StO9IZUHVZVzYO248oLa1NxvHceck1VWj6'),
(47761000, 'el pepe', 'stesht', '1234'),
(47767677, 'ALEXIS', 'RAMIREZ', '2070'),
(52222222, 'N', 'M', '9999'),
(55555555, 'HHHH', 'DDDDD', '$2y$10$t3.ZtUV7/brKfxGp.HSK..cy30WU2LpXuvvjYU3C2QcluL0L6fDXi'),
(63333333, 'F', 'P', '3333'),
(77444111, 'NNN', 'MMM', '$2y$10$34kwzn9iqs8UPAuYgYlVteM3BKsIBM.55rZP/UlVzad6hh7Zfam56'),
(77777778, 'NNN', 'BB', '$2y$10$37Pf78IHhkj6b.CeXJ6bLuUqpqFJScZuy/KIkUeBeW1PzFSPYh/ca'),
(77777784, 'Paciente', 'Anonimo', '6666'),
(88888888, 'GGGG', 'GGGG', '$2y$10$B1j0WCu5yyiD1EUswfs9Sui4jZGlfj2q1wcx9vCH2QG0QpsJblbWS'),
(123456789, 'si', 'no', '1111'),
(2147483647, 'juan', 'juancho', '5555');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prescripciones`
--

CREATE TABLE `prescripciones` (
  `id` int(11) NOT NULL,
  `id_diagnostico` int(11) NOT NULL,
  `id_medicamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sensor_silla`
--

CREATE TABLE `sensor_silla` (
  `id` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0,
  `ultimo_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sensor_silla`
--

INSERT INTO `sensor_silla` (`id`, `estado`, `ultimo_update`) VALUES
(1, 0, '2025-06-05 01:29:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_medicamentos`
--

CREATE TABLE `stock_medicamentos` (
  `id_medicamento` int(11) NOT NULL,
  `stock_disponible` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `diagnosticos`
--
ALTER TABLE `diagnosticos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dni_paciente` (`dni_paciente`),
  ADD KEY `dni_medico` (`dni_medico`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_chequeo`
--
ALTER TABLE `estado_chequeo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `prescripciones`
--
ALTER TABLE `prescripciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_diagnostico` (`id_diagnostico`),
  ADD KEY `id_medicamento` (`id_medicamento`);

--
-- Indices de la tabla `sensor_silla`
--
ALTER TABLE `sensor_silla`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stock_medicamentos`
--
ALTER TABLE `stock_medicamentos`
  ADD PRIMARY KEY (`id_medicamento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `diagnosticos`
--
ALTER TABLE `diagnosticos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prescripciones`
--
ALTER TABLE `prescripciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sensor_silla`
--
ALTER TABLE `sensor_silla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `diagnosticos`
--
ALTER TABLE `diagnosticos`
  ADD CONSTRAINT `diagnosticos_ibfk_1` FOREIGN KEY (`dni_paciente`) REFERENCES `pacientes` (`dni`),
  ADD CONSTRAINT `diagnosticos_ibfk_2` FOREIGN KEY (`dni_medico`) REFERENCES `medicos` (`dni`);

--
-- Filtros para la tabla `prescripciones`
--
ALTER TABLE `prescripciones`
  ADD CONSTRAINT `prescripciones_ibfk_1` FOREIGN KEY (`id_diagnostico`) REFERENCES `diagnosticos` (`id`),
  ADD CONSTRAINT `prescripciones_ibfk_2` FOREIGN KEY (`id_medicamento`) REFERENCES `medicamentos` (`id`);

--
-- Filtros para la tabla `stock_medicamentos`
--
ALTER TABLE `stock_medicamentos`
  ADD CONSTRAINT `stock_medicamentos_ibfk_1` FOREIGN KEY (`id_medicamento`) REFERENCES `medicamentos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
