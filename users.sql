-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-12-2024 a las 13:41:33
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
-- Base de datos: `portmanager`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `surname` varchar(128) NOT NULL,
  `photo` varchar(128) DEFAULT NULL,
  `categoria_profesional` varchar(64) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `profile_summary` text DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `visible` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(128) DEFAULT NULL,
  `token_creation_date` timestamp NULL DEFAULT NULL,
  `active_account` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `users`:
--

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `photo`, `categoria_profesional`, `email`, `profile_summary`, `password`, `visible`, `created_at`, `updated_at`, `token`, `token_creation_date`, `active_account`) VALUES
(1, 'Pablo', 'Mérida Velasco', 'pabloMerida.jpg', 'Desarrollador Web', 'pablomerida03@gmail.com', 'Desarrollador web con ganas de comerse el  mundo y aprender', '1234', 0, '2024-03-10 18:45:57', '2024-03-10 18:45:57', NULL, NULL, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `name` (`name`),
  ADD KEY `surname` (`surname`),
  ADD KEY `profile_summary` (`profile_summary`(768)),
  ADD KEY `email_2` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


--
-- Metadatos
--
USE `phpmyadmin`;

--
-- Metadatos para la tabla users
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
