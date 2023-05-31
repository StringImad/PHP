-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-05-2023 a las 12:02:13
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_blog_ex`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `valor` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `valor`) VALUES
(1, 'DEPORTES'),
(2, 'ECONOMÍA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idComentario` int(11) NOT NULL,
  `comentario` varchar(255) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idNoticia` int(11) NOT NULL,
  `estado` enum('sin validar','apto') NOT NULL DEFAULT 'sin validar',
  `fCreacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idComentario`, `comentario`, `idUsuario`, `idNoticia`, `estado`, `fCreacion`) VALUES
(1, 'Pues yo pienso que cómo pierda deberían echarlo', 2, 1, 'apto', '2023-05-17 09:14:36'),
(2, 'Pues para mi, debe de quedarse', 1, 1, 'apto', '2023-05-17 09:14:36'),
(4, 'No contestas???', 2, 1, 'apto', '2023-05-25 06:54:55'),
(5, 'No tienes ni idea', 1, 1, 'apto', '2023-05-25 06:55:39'),
(6, 'Tú, si que no tienes ni idea.', 2, 1, 'apto', '2023-05-25 07:08:05'),
(7, 'No contestas?', 2, 1, 'apto', '2023-05-31 08:24:56'),
(8, 'Parece que no contestas', 2, 1, 'apto', '2023-05-31 09:13:20'),
(9, 'Ojalá perdais!!', 3, 2, 'apto', '2023-05-31 09:32:20'),
(10, 'Al final perdió. Que va a hacer Ancelotti', 3, 1, 'apto', '2023-05-31 09:47:41'),
(13, 'Q mala Pipa tienes!!', 2, 2, 'apto', '2023-05-31 09:56:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `copete` varchar(255) NOT NULL,
  `cuerpo` text NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `fPublicacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fModificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `copete`, `cuerpo`, `idUsuario`, `idCategoria`, `fPublicacion`, `fCreacion`, `fModificacion`) VALUES
(1, 'Ancelotti se juega... la final y nada más', 'Su continuidad tras el partido ante el Manchester City está fuera de toda duda en un mundo, eso sí, tan cambiante como el del fútbol', 'Carlo Ancelotti confía ciegamente en la plantilla y los futbolistas, en el italiano. Algo ya sabido y reconocido por unos y otros desde hace tiempo. A este factor decisivo para la conquista de títulos (tres esta temporada) se ha unido en esta ocasión el respaldo público y en privado del club (el propio presidente) a lo hecho por el entrenador. Todo ello ha elevado la seguridad y confianza del grupo ante el desafío de eliminar al Manchester City y, de esta manera, pisar la final de Estambul.\r\nAncelotti pone en juego en el Etihad el pase a la final. Nada más. Su continuidad está fuera de toda duda en un mundo, no olvidemos, tan cambiante como es el fútbol. En la memoria está cuando el Real Madrid con Zinedine Zidane ganó en Kiev en 2018 su tercera Champions League consecutiva y tres días más tarde decidió que su etapa en el banquillo del club blanco había terminado.', 2, 1, '2023-05-17 09:15:12', '2023-05-17 09:10:40', '2023-05-31 08:35:06'),
(2, '\"No entrabamos en ninguna de la Quinielas\"', 'El vicepresidente del Sevilla reflexiona en MARCA sobre cómo es posible que un año marcado por el miedo a un posible descenso haya terminado con otra final', 'La temporada ha sido tan dura para el Sevilla, que esta final de Budapest es considerada como un regalo a tanto sufrimiento vivido. Si el sevillista de a pie lo ha pasado mal, qué decir del también sevillista que gestiona una entidad poco acostumbrada al fracaso en los últimos tiempos. Pocas horas de sueño, mucha incertidumbre y el miedo por un descenso que ya se mira como un lejano sueño. Ahora, José María del Nido Carrasco, igual de cansado con todo lo que conlleva una final, tiene el deseo de cambiar un año para el olvido por uno para el recuerdo. Budapest les espera. ', 1, 1, '2023-05-29 08:31:28', '2023-05-31 08:34:08', '2023-05-31 09:31:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tipo` enum('admin','comun') NOT NULL DEFAULT 'comun'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `usuario`, `clave`, `email`, `tipo`) VALUES
(1, 'masantos76', 'e10adc3949ba59abbe56e057f20f883e', 'inventado@info.es', 'admin'),
(2, 'masantos', 'e10adc3949ba59abbe56e057f20f883e', 'inventado2@info.es', 'admin'),
(3, 'jlara', 'e10adc3949ba59abbe56e057f20f883e', 'inventado3@info.es', 'comun'),
(4, 'masantos78', 'e10adc3949ba59abbe56e057f20f883e', 'inventado5@info.es', 'comun'),
(5, 'jlara34', 'e10adc3949ba59abbe56e057f20f883e', 'sadf@lsdff.es', 'comun');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idComentario`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idNoticia` (`idNoticia`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`idNoticia`) REFERENCES `noticias` (`idNoticia`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `noticias_ibfk_2` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
