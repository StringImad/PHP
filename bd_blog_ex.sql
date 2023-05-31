-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-05-2023 a las 10:29:55
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `valor`) VALUES
(1, 'Deportes'),
(2, 'Economía');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idComentario`, `comentario`, `idUsuario`, `idNoticia`, `estado`, `fCreacion`) VALUES
(1, 'Pues deberían de echarla, Que vergüenza!!', 2, 1, 'apto', '2023-05-17 09:14:07'),
(15, 'No pasa na hombre', 2, 1, 'sin validar', '2023-05-25 07:22:48'),
(16, 'Viva la alcaldesa', 2, 1, 'sin validar', '2023-05-25 07:22:55'),
(17, 'Ole!', 2, 1, 'apto', '2023-05-25 07:37:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(120) NOT NULL,
  `copete` varchar(255) NOT NULL,
  `cuerpo` text NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `fPublicacion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fModificacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `copete`, `cuerpo`, `idUsuario`, `idCategoria`, `fPublicacion`, `fCreacion`, `fModificacion`) VALUES
(1, 'Los audios de Marbella: el marido de la alcaldesa ', 'Seis meses después de arrancar la investigación por narcotráfico de la Audiencia Nacional, Lars Broberg llamó a su hijo y hablaron en sueco: “Escucha, escucha, el [teléfono] que tienes en la mano está intervenido”', 'En el capítulo de los posibles delitos que quedaron sin investigar a por la Audiencia Nacional a la familia de Ángeles Muñoz destaca el chivatazo que el marido de la alcaldesa de Marbella y su hijastro recibieron acerca de que estaban siendo investigados por pertenecer presuntamente a una organización criminal dedicada al narcotráfico. Tras informar en exclusiva de ello el pasado noviembre, elDiario.es ha accedido al audio de esa conversación en sueco: “Escucha, escucha, el que estás sujetando [el teléfono] está intervenido”.\r\n\r\nEra 28 de octubre de 2019 y habían pasado seis meses desde que el Juzgado Central de Instrucción número 6 de la Audiencia Nacional abriera una causa contra una delegación de la mafia sueca a partir de una comisión rogatoria cursada por las autoridades de ese país del norte de Europa.\r\n\r\nEn ese momento, la Audiencia Nacional, la Fiscalía Antidroga y la Policía consideraban a Joakim Broberg, hijastro de Muñoz, cabecilla de una delegación de la Mocro Mafia sueca en la Costa del Sol. Creían que, además de participar en traslados de cannabis desde Marruecos al norte de Europa, habían puesto sus sociedades al servicio del blanqueo de las ganancias del narcotráfico.', 3, 1, '2023-05-17 10:07:12', '2023-05-17 09:07:12', '2023-05-17 09:11:44'),
(2, 'Una pistola encasquillada evita un tiroteo en una pelea en la discoteca Dreamers de Marbella', 'Un británico ajeno a la trifulca ha sido detenido por intentar sobornar a los porteros con el objetivo de recuperar el arma, que fue requisada.', 'La madrugada del viernes 26 de mayo, los asistentes a la fiesta que la discoteca Dreamers, ubicada en la localidad marbellí de Puerto Banús, había organizado, se llevaron un buen susto tras una pelea con armas de fuego que sucedió al filo de las cuatro de la mañana.\r\n\r\nEn el ambiente festivo, cuando la mayoría de los presentes bailaban al ritmo de la música, un ciudadano inglés y otro latino, según las fuentes consultadas por EL ESPAÑOL de Málaga, se enfrentaron en el interior del local. Uno de los implicados salió corriendo tras el otro hacia la terraza, donde llegó a sacar un revólver para presuntamente disparar al contrario, pero se le cayó al suelo.', 2, 2, '2023-05-29 13:05:07', '2023-05-29 10:04:49', '2023-05-29 10:05:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tipo` enum('comun','admin') NOT NULL DEFAULT 'comun'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `usuario`, `clave`, `email`, `tipo`) VALUES
(1, 'juan59', '202cb962ac59075b964b07152d234b70', 'inve@jdd.com', 'admin'),
(2, 'imad', '202cb962ac59075b964b07152d234b70', '263@inve.es', 'admin'),
(3, 'Mary', '202cb962ac59075b964b07152d234b70', 'Mary@invent.com', 'comun'),
(12, 'juan591', '202cb962ac59075b964b07152d234b70', 'inve1@jdd.com', 'comun'),
(13, 'ssaax', '202cb962ac59075b964b07152d234b70', 'elpinchdsediablo59@gmail.com', 'comun');

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
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
