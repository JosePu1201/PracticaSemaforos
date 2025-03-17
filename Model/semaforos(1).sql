-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-03-2025 a las 22:09:08
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
-- Base de datos: `semaforos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Interseccion`
--

CREATE TABLE `Interseccion` (
  `id` int(11) NOT NULL,
  `numeroCalle` int(11) NOT NULL,
  `numeroAvenida` int(11) NOT NULL,
  `numeroZona` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Interseccion`
--

INSERT INTO `Interseccion` (`id`, `numeroCalle`, `numeroAvenida`, `numeroZona`, `nombre`) VALUES
(1, 5, 10, 3, '5ta Calle y 10ma Avenida de la Zona 3'),
(2, 1, 1, 1, '1.º Calle y 1.º Avenida de la Zona 1'),
(3, 1, 1, 2, '1.º Calle y 1.º Avenida de la Zona 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Iteracion`
--

CREATE TABLE `Iteracion` (
  `id` int(11) NOT NULL,
  `monitor` varchar(150) NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Iteracion`
--

INSERT INTO `Iteracion` (`id`, `monitor`, `inicio`, `fin`, `comentario`) VALUES
(1, '2', '2025-03-17 20:54:21', '2025-03-17 20:54:21', ''),
(2, '2', '2025-03-17 21:21:15', '2025-03-17 21:21:16', 'asdasd'),
(3, '2', '2025-03-17 14:22:03', '2025-03-17 14:22:11', 'hola de nuevo'),
(4, '2', '2025-03-17 14:30:47', '2025-03-17 14:31:29', 'finalizado correctamente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `LogSesion`
--

CREATE TABLE `LogSesion` (
  `id` int(11) NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `usuario` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `LogSesion`
--

INSERT INTO `LogSesion` (`id`, `inicio`, `fin`, `usuario`) VALUES
(1, '2025-03-17 19:29:49', '2025-03-17 19:30:56', '2'),
(2, '2025-03-17 12:32:38', '2025-03-17 12:32:55', '2'),
(3, '2025-03-17 12:33:24', '2025-03-17 12:33:28', '2'),
(4, '2025-03-17 12:36:40', '2025-03-17 12:37:18', 'josePu'),
(5, '2025-03-17 12:37:23', '2025-03-17 12:37:39', 'super'),
(6, '2025-03-17 12:41:07', '2025-03-17 13:13:22', 'super'),
(7, '2025-03-17 13:13:26', '2025-03-17 13:13:37', '2'),
(8, '2025-03-17 13:14:18', '2025-03-17 13:14:28', '2'),
(9, '2025-03-17 13:14:38', '2025-03-17 13:52:22', 'super'),
(10, '2025-03-17 13:52:56', '2025-03-17 13:53:05', 'super'),
(11, '2025-03-17 13:53:10', '2025-03-17 13:53:13', '2'),
(12, '2025-03-17 13:53:46', '2025-03-17 14:09:00', 'super'),
(13, '2025-03-17 14:09:07', '2025-03-17 14:22:27', '2'),
(14, '2025-03-17 14:22:30', '2025-03-17 14:23:59', 'super'),
(15, '2025-03-17 14:30:45', '2025-03-17 14:33:59', '2'),
(16, '2025-03-17 14:47:44', '2025-03-17 14:47:46', '2'),
(17, '2025-03-17 14:48:50', '2025-03-17 15:03:38', 'josePu'),
(18, '2025-03-17 15:04:24', '2025-03-17 15:04:58', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Rol`
--

CREATE TABLE `Rol` (
  `id_rol` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Rol`
--

INSERT INTO `Rol` (`id_rol`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Monitor'),
(3, 'Supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Semaforo`
--

CREATE TABLE `Semaforo` (
  `id` int(11) NOT NULL,
  `tiempoVerde` int(11) NOT NULL,
  `tiempoAmarillo` int(11) NOT NULL,
  `tiempoRojo` int(11) NOT NULL,
  `interseccion` int(11) NOT NULL,
  `direccion` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Semaforo`
--

INSERT INTO `Semaforo` (`id`, `tiempoVerde`, `tiempoAmarillo`, `tiempoRojo`, `interseccion`, `direccion`) VALUES
(1, 10, 1, 1, 1, 'N'),
(2, 10, 1, 1, 1, 'O'),
(3, 10, 1, 1, 1, 'E'),
(4, 10, 1, 1, 1, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoVheiculo`
--

CREATE TABLE `tipoVheiculo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoVheiculo`
--

INSERT INTO `tipoVheiculo` (`id`, `nombre`) VALUES
(1, 'Sedan'),
(2, 'Bus urbano'),
(3, 'Camion'),
(4, 'Motocicleta'),
(5, 'Sub');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE `Usuario` (
  `id_usuario` varchar(150) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Usuario`
--

INSERT INTO `Usuario` (`id_usuario`, `nombre`, `correo`, `pass`, `id_rol`) VALUES
('2', '2', 'jose@gmail.com', '1', 2),
('admin', 'administrador', 'admin@gmail.com', 'admin', 1),
('j', 'jose luis pu', 'jsam@gmail', '1234', 2),
('josePu', 'Jose', 'joseluis@gmail.com', '12345678', 1),
('k', 'dsf', 'fsdf@asd', '1234', 3),
('super', 'supervisor', 'super@gmail.com', '1', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Vehiculo`
--

CREATE TABLE `Vehiculo` (
  `placa` varchar(5) NOT NULL,
  `color` varchar(20) NOT NULL,
  `modelo` int(11) NOT NULL,
  `velocidad` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `interseccion` int(11) NOT NULL,
  `direccion` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `Vehiculo`
--

INSERT INTO `Vehiculo` (`placa`, `color`, `modelo`, `velocidad`, `tipo`, `interseccion`, `direccion`) VALUES
('0F8A8', 'rojo', 2013, 21, 2, 2, 'N'),
('153B9', 'rojo', 2021, 18, 1, 1, 'S'),
('2FD16', 'verde', 1998, 16, 4, 1, 'E'),
('36257', 'azul', 2023, 9, 1, 2, 'O'),
('3B119', 'blanco', 2024, 1, 1, 1, 'S'),
('3CD08', 'gris', 2023, 18, 1, 1, 'N'),
('445E5', 'azul', 2002, 21, 2, 2, 'O'),
('4AAAF', 'verde', 2024, 19, 4, 2, 'E'),
('762FB', 'azul', 1994, 21, 3, 1, 'N'),
('77F3A', 'blanco', 2000, 23, 2, 1, 'O'),
('7DE4B', 'blanco', 2006, 14, 1, 2, 'N'),
('85994', 'azul', 2002, 18, 2, 1, 'O'),
('A4AEC', 'blanco', 2012, 29, 4, 1, 'S'),
('B461B', 'verde', 2018, 6, 2, 2, 'S'),
('CB234', 'Rojo', 1999, 23, 1, 2, 'N'),
('CD22F', 'rojo', 2007, 4, 4, 2, 'O'),
('D8BC8', 'verde', 1982, 14, 1, 1, 'O'),
('DDED9', 'azul', 2019, 23, 3, 2, 'N'),
('E3BB9', 'rojo', 1989, 20, 1, 2, 'E'),
('E6418', 'gris', 1998, 15, 4, 1, 'S'),
('F7093', 'gris', 1994, 27, 4, 2, 'O');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Interseccion`
--
ALTER TABLE `Interseccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `Iteracion`
--
ALTER TABLE `Iteracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monitor` (`monitor`);

--
-- Indices de la tabla `LogSesion`
--
ALTER TABLE `LogSesion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`usuario`);

--
-- Indices de la tabla `Rol`
--
ALTER TABLE `Rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `Semaforo`
--
ALTER TABLE `Semaforo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interseccion` (`interseccion`);

--
-- Indices de la tabla `tipoVheiculo`
--
ALTER TABLE `tipoVheiculo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `Vehiculo`
--
ALTER TABLE `Vehiculo`
  ADD PRIMARY KEY (`placa`),
  ADD KEY `interseccion` (`interseccion`),
  ADD KEY `tipo` (`tipo`),
  ADD KEY `tipo_2` (`tipo`),
  ADD KEY `tipo_3` (`tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Interseccion`
--
ALTER TABLE `Interseccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Iteracion`
--
ALTER TABLE `Iteracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `LogSesion`
--
ALTER TABLE `LogSesion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `Semaforo`
--
ALTER TABLE `Semaforo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Iteracion`
--
ALTER TABLE `Iteracion`
  ADD CONSTRAINT `Iteracion_ibfk_1` FOREIGN KEY (`monitor`) REFERENCES `Usuario` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `LogSesion`
--
ALTER TABLE `LogSesion`
  ADD CONSTRAINT `LogSesion_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `Usuario` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Semaforo`
--
ALTER TABLE `Semaforo`
  ADD CONSTRAINT `Semaforo_ibfk_1` FOREIGN KEY (`interseccion`) REFERENCES `Interseccion` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Usuario`
--
ALTER TABLE `Usuario`
  ADD CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `Rol` (`id_rol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `Vehiculo`
--
ALTER TABLE `Vehiculo`
  ADD CONSTRAINT `Vehiculo_ibfk_1` FOREIGN KEY (`interseccion`) REFERENCES `Interseccion` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Vehiculo_ibfk_2` FOREIGN KEY (`tipo`) REFERENCES `tipoVheiculo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
