-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2017 a las 22:38:13
-- Versión del servidor: 5.7.14
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestoria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculaciones`
--

CREATE TABLE `matriculaciones` (
  `id` int(11) NOT NULL,
  `entrada` date NOT NULL,
  `bastidor` int(6) NOT NULL,
  `matricula` varchar(7) NOT NULL,
  `cliente` varchar(40) NOT NULL,
  `alta` decimal(2,0) NOT NULL,
  `565/567` varchar(5) NOT NULL,
  `p.p.` varchar(20) NOT NULL,
  `poblacion` varchar(20) NOT NULL,
  `localidad` varchar(20) DEFAULT NULL,
  `emp` int(25) DEFAULT NULL,
  `salida` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `matriculaciones`
--

INSERT INTO `matriculaciones` (`id`, `entrada`, `bastidor`, `matricula`, `cliente`, `alta`, `565/567`, `p.p.`, `poblacion`, `localidad`, `emp`, `salida`) VALUES
(1, '2017-04-06', 123456, '1234EEE', 'Cristian', '51', '', 'Baleares', 'palma', '', 0, NULL),
(2, '2017-04-06', 123456, '1234EEE', 'Cristian', '51', '', 'Baleares', 'palma', '', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contraseña` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `correo`, `contraseña`) VALUES
(1, 'CRISTIAN', 'DIAZ PORTERO', 'cristiandiazportero@gmail.com', '4b713bbbefb605d8c7a67feef7921ba4'),
(2, 'luis', 'garcia', 'lmgspain@hotmail.com', 'a354d8570d85744131ed4e6cc80274d4');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `matriculaciones`
--
ALTER TABLE `matriculaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `matriculaciones`
--
ALTER TABLE `matriculaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
