-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-10-2025 a las 00:09:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `notas_app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `codigo` varchar(5) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `email` varchar(15) NOT NULL,
  `programa` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`codigo`, `nombre`, `email`, `programa`) VALUES
('10001', 'Estudiante 1', 'test1@test.com', '1111'),
('10002', 'Estudiante 2', 'test2@test.com', '1111'),
('10003', 'Estudiante 3', 'test3@test.com', '2222'),
('10004', 'Estudiante 4', 'test4@test.com', '2222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `codigo` varchar(4) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `programa` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`codigo`, `nombre`, `programa`) VALUES
('1101', 'Prog. avanzada G1', '1111'),
('1102', 'Ing. Software G1', '1111'),
('2201', 'Prog. avanzada G2', '2222'),
('2202', 'Taller de web', '2222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `materia` varchar(4) NOT NULL,
  `estudiante` varchar(5) NOT NULL,
  `actividad` varchar(50) NOT NULL,
  `nota` decimal(10,2) NOT NULL,
  PRIMARY KEY (`materia`, `estudiante`, `actividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`materia`, `estudiante`, `actividad`, `nota`) VALUES
('1101', '10001', 'Ejemplo 1', 3.00),
('1101', '10002', 'Ejemplo 1', 4.00),
('1102', '10001', 'Ejemplo 2', 3.00),
('1102', '10002', 'Ejemplo 2', 3.00),
('2201', '10003', 'Act. 1', 3.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `codigo` varchar(4) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `programas` (`codigo`, `nombre`) VALUES
('1111', 'Ing. Sistemas'),
('2222', 'Ing. Multimedia');

--
-- Índices para tablas volcadas
--

ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_programas_estudiante` (`programa`);

ALTER TABLE `materias`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_programas_materia` (`programa`);

ALTER TABLE `notas`
  ADD KEY `fk_estudiantes_nota` (`estudiante`);

ALTER TABLE `estudiantes`
  ADD CONSTRAINT `fk_programas_estudiante` FOREIGN KEY (`programa`) REFERENCES `programas` (`codigo`);

ALTER TABLE `materias`
  ADD CONSTRAINT `fk_programas_materia` FOREIGN KEY (`programa`) REFERENCES `programas` (`codigo`);

ALTER TABLE `notas`
  ADD CONSTRAINT `fk_estudiantes_nota` FOREIGN KEY (`estudiante`) REFERENCES `estudiantes` (`codigo`),
  ADD CONSTRAINT `fk_materias_nota` FOREIGN KEY (`materia`) REFERENCES `materias` (`codigo`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
