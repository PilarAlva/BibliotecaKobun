-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2025 a las 13:31:53
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
-- Base de datos: `kobun_db`
--
CREATE DATABASE IF NOT EXISTS `kobun_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `kobun_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id` int(11) NOT NULL,
  `referencia` varchar(200) NOT NULL,
  `titulo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id`, `referencia`, `titulo`) VALUES
(1, '../almacenamiento/subidos/20251113215929_portada-principito.webp.webp', 'portada-principito.webp'),
(2, '../almacenamiento/subidos/20251113215929_perfil-profe.jpg.jpg', 'perfil-profe.jpg'),
(3, '../almacenamiento/subidos/20251113215938_portada-principito.webp.webp', 'portada-principito.webp'),
(4, '../almacenamiento/subidos/20251113215938_perfil-profe.jpg.jpg', 'perfil-profe.jpg'),
(5, '../almacenamiento/portadas/20251114040518_dibujo de historietas.webp', 'dibujo de historietas'),
(6, '../almacenamiento/portadas/20251114040521_dibujo de historietas.webp', 'dibujo de historietas'),
(7, '../almacenamiento/portadas/20251114040525_dibujo de historietas.webp', 'dibujo de historietas'),
(8, '../almacenamiento/portadas/20251114040527_dibujo de historietas.webp', 'dibujo de historietas'),
(9, '../almacenamiento/portadas/20251114040528_dibujo de historietas.webp', 'dibujo de historietas'),
(10, '../almacenamiento/portadas/20251114040528_dibujo de historietas.webp', 'dibujo de historietas'),
(11, '../almacenamiento/portadas/20251114040529_dibujo de historietas.webp', 'dibujo de historietas'),
(12, '../almacenamiento/portadas/20251114040529_dibujo de historietas.webp', 'dibujo de historietas'),
(13, '../almacenamiento/portadas/20251114040529_dibujo de historietas.webp', 'dibujo de historietas'),
(14, '../almacenamiento/portadas/20251114040529_dibujo de historietas.webp', 'dibujo de historietas'),
(15, '../almacenamiento/portadas/20251114040530_dibujo de historietas.webp', 'dibujo de historietas'),
(16, '../almacenamiento/portadas/20251114040530_dibujo de historietas.webp', 'dibujo de historietas'),
(17, '../almacenamiento/portadas/20251114040530_dibujo de historietas.webp', 'dibujo de historietas'),
(18, '../almacenamiento/portadas/20251114040530_dibujo de historietas.webp', 'dibujo de historietas'),
(19, '../almacenamiento/portadas/20251114040531_dibujo de historietas.webp', 'dibujo de historietas'),
(20, '../almacenamiento/portadas/20251114040531_dibujo de historietas.webp', 'dibujo de historietas'),
(21, '../almacenamiento/portadas/20251114040531_dibujo de historietas.webp', 'dibujo de historietas'),
(22, '../almacenamiento/portadas/20251114040531_dibujo de historietas.webp', 'dibujo de historietas'),
(23, '../almacenamiento/portadas/20251114040531_dibujo de historietas.webp', 'dibujo de historietas'),
(24, '../almacenamiento/portadas/20251114040533_dibujo de historietas.webp', 'dibujo de historietas'),
(25, '../almacenamiento/portadas/20251114040533_dibujo de historietas.webp', 'dibujo de historietas'),
(26, '../almacenamiento/portadas/20251114040536_dibujo de historietas.webp', 'dibujo de historietas'),
(27, '../almacenamiento/portadas/20251114040537_dibujo de historietas.webp', 'dibujo de historietas'),
(28, '../almacenamiento/portadas/20251114040539_dibujo de historietas.webp', 'dibujo de historietas'),
(29, '../almacenamiento/portadas/20251114040540_dibujo de historietas.webp', 'dibujo de historietas'),
(30, '../almacenamiento/portadas/20251114041720_escribir ciencia ficción.webp', 'escribir ciencia ficción'),
(31, '../almacenamiento/portadas/20251116011258_el espacio entre las palabras.png', 'el espacio entre las palabras'),
(32, '../almacenamiento/portadas/20251116225341_albaoscura.jpg', 'albaoscura'),
(33, '../almacenamiento/portadas/20251116225407_aleación de ley.webp', 'aleación de ley'),
(34, '../almacenamiento/portadas/20251116225417_amor líquido.webp', 'amor líquido'),
(35, '../almacenamiento/portadas/20251116225432_así habló zaratustra.webp', 'así habló zaratustra'),
(36, '../almacenamiento/portadas/20251116225446_balada de pájaros cantores y serpientes.webp', 'balada de pájaros cantores y serpientes'),
(37, '../almacenamiento/portadas/20251116225500_brazales de duelo.webp', 'brazales de duelo'),
(38, '../almacenamiento/portadas/20251116225509_cinco semanas en globo.webp', 'cinco semanas en globo'),
(39, '../almacenamiento/portadas/20251116225523_crimen y castigo.webp', 'crimen y castigo'),
(40, '../almacenamiento/portadas/20251116225650_crítica de la razón pura.webp', 'crítica de la razón pura'),
(41, '../almacenamiento/portadas/20251116225706_danzante del filo.webp', 'danzante del filo'),
(42, '../almacenamiento/portadas/20251116225720_de la gramatología.webp', 'de la gramatología'),
(43, '../almacenamiento/portadas/20251116225731_demian.jpg', 'demian'),
(44, '../almacenamiento/portadas/20251116225755_divergente.jpg', 'divergente'),
(45, '../almacenamiento/portadas/20251116225804_don quijote de la mancha.webp', 'don quijote de la mancha'),
(46, '../almacenamiento/portadas/20251116225814_drácula.webp', 'drácula'),
(47, '../almacenamiento/portadas/20251116225823_duna.webp', 'duna'),
(48, '../almacenamiento/portadas/20251116225832_el aleph.jpg', 'el aleph'),
(49, '../almacenamiento/portadas/20251116225846_el amor, las mujeres y la muerte.webp', 'el amor, las mujeres y la muerte'),
(50, '../almacenamiento/portadas/20251116225855_el amor, las mujeres y la vida.webp', 'el amor, las mujeres y la vida'),
(51, '../almacenamiento/portadas/20251116225903_el banquete.jpg', 'el banquete'),
(52, '../almacenamiento/portadas/20251116225924_el cáliz de los dioses.jpg', 'el cáliz de los dioses'),
(53, '../almacenamiento/portadas/20251116230013_el camino de los reyes.jpg', 'el camino de los reyes'),
(54, '../almacenamiento/portadas/20251116230021_el capital.webp', 'el capital'),
(55, '../almacenamiento/portadas/20251116230028_el conocimiento humano.webp', 'el conocimiento humano'),
(56, '../almacenamiento/portadas/20251116230110_el extranjero.webp', 'el extranjero'),
(57, '../almacenamiento/portadas/20251116230119_el faro del fin del mundo.webp', 'el faro del fin del mundo'),
(58, '../almacenamiento/portadas/20251116230130_el forastero misterioso.webp', 'el forastero misterioso'),
(59, '../almacenamiento/portadas/20251116230141_el héroe de las eras.webp', 'el héroe de las eras'),
(60, '../almacenamiento/portadas/20251116230151_el hobbit.webp', 'el hobbit'),
(61, '../almacenamiento/portadas/20251116230200_el hombre invisible.jpg', 'el hombre invisible'),
(62, '../almacenamiento/portadas/20251116230213_el imperio final.webp', 'el imperio final'),
(63, '../almacenamiento/portadas/20251116230228_el ladrón del rayo.webp', 'el ladrón del rayo'),
(64, '../almacenamiento/portadas/20251116230239_el libro de bill.jpg', 'el libro de bill'),
(65, '../almacenamiento/portadas/20251116230248_el libro troll del rubius.jpg', 'el libro troll del rubius'),
(66, '../almacenamiento/portadas/20251116230305_el mar de monstruos.webp', 'el mar de monstruos'),
(67, '../almacenamiento/portadas/20251116230316_el metal perdido.webp', 'el metal perdido'),
(68, '../almacenamiento/portadas/20251116230413_el principito.webp', 'el principito'),
(69, '../almacenamiento/portadas/20251116230420_el prisionero de azkaban.jpg', 'el prisionero de azkaban'),
(70, '../almacenamiento/portadas/20251116230430_el retrato de dorian gray.webp', 'el retrato de dorian gray'),
(71, '../almacenamiento/portadas/20251116230443_el señor de los anillos: el retorno del rey.webp', 'el señor de los anillos: el retorno del rey'),
(72, '../almacenamiento/portadas/20251116230458_el señor de los anillos: el retorno del rey.webp', 'el señor de los anillos: el retorno del rey'),
(73, '../almacenamiento/portadas/20251116230523_el señor de los anillos: el retorno del rey.webp', 'el señor de los anillos: el retorno del rey'),
(74, '../almacenamiento/portadas/20251116230536_el señor de los anillos: el retorno del rey.webp', 'el señor de los anillos: el retorno del rey'),
(75, '../almacenamiento/portadas/20251116230628_el señor de los anillos: el retorno del rey.webp', 'el señor de los anillos: el retorno del rey'),
(76, '../almacenamiento/portadas/20251116230702_el silmarillion.jpg', 'el silmarillion'),
(77, '../almacenamiento/portadas/20251116230740_elantris.webp', 'elantris'),
(78, '../almacenamiento/portadas/20251116230754_fahrenheit 451.webp', 'fahrenheit 451'),
(79, '../almacenamiento/portadas/20251116230806_frankenstein.webp', 'frankenstein'),
(80, '../almacenamiento/portadas/20251116230821_fundación.webp', 'fundación'),
(81, '../almacenamiento/portadas/20251116230829_fundación y tierra.webp', 'fundación y tierra'),
(82, '../almacenamiento/portadas/20251116230838_hacia la fundación.webp', 'hacia la fundación'),
(83, '../almacenamiento/portadas/20251116230855_harry potter y el cáliz de fuego.webp', 'harry potter y el cáliz de fuego'),
(84, '../almacenamiento/portadas/20251116230913_harry potter y el misterio del príncipe.jpg', 'harry potter y el misterio del príncipe'),
(85, '../almacenamiento/portadas/20251116230927_harry potter y la orden del fénix.png', 'harry potter y la orden del fénix'),
(86, '../almacenamiento/portadas/20251116230942_harry potter y la piedra filosofal.webp', 'harry potter y la piedra filosofal'),
(87, '../almacenamiento/portadas/20251116230955_harry potter y las reliquias de la muerte.webp', 'harry potter y las reliquias de la muerte'),
(88, '../almacenamiento/portadas/20251116231006_herejes de duna.webp', 'herejes de duna'),
(89, '../almacenamiento/portadas/20251116231015_hijos de duna.webp', 'hijos de duna'),
(90, '../almacenamiento/portadas/20251116231022_hyperion.webp', 'hyperion'),
(91, '../almacenamiento/portadas/20251116231031_indigno de ser humano.webp', 'indigno de ser humano'),
(92, '../almacenamiento/portadas/20251116231039_insurgente.jpg', 'insurgente'),
(93, '../almacenamiento/portadas/20251116231047_it.webp', 'it'),
(94, '../almacenamiento/portadas/20251116231059_juramentada.jpg', 'juramentada'),
(95, '../almacenamiento/portadas/20251116231107_kamasutra.webp', 'kamasutra'),
(96, '../almacenamiento/portadas/20251116231118_la batalla del laberinto.webp', 'la batalla del laberinto'),
(97, '../almacenamiento/portadas/20251116231127_la cámara secreta.webp', 'la cámara secreta'),
(98, '../almacenamiento/portadas/20251116231135_la gaya ciencia.webp', 'la gaya ciencia'),
(99, '../almacenamiento/portadas/20251116231143_la guerra de los mundos.webp', 'la guerra de los mundos'),
(100, '../almacenamiento/portadas/20251116231154_la maldición del titán.png', 'la maldición del titán'),
(101, '../almacenamiento/portadas/20251116231203_la máquina del tiempo.webp', 'la máquina del tiempo'),
(102, '../almacenamiento/portadas/20251116231218_la razón de estar contigo.webp', 'la razón de estar contigo'),
(103, '../almacenamiento/portadas/20251116231225_la república.jpg', 'la república'),
(104, '../almacenamiento/portadas/20251116231238_la sociedad del cansancio.webp', 'la sociedad del cansancio'),
(105, '../almacenamiento/portadas/20251116231430_las montañas de la locura.webp', 'las montañas de la locura'),
(106, '../almacenamiento/portadas/20251116231446_leal.jpg', 'leal'),
(107, '../almacenamiento/portadas/20251116231455_los juegos del hambre.webp', 'los juegos del hambre'),
(108, '../almacenamiento/portadas/20251116231509_los juegos del hambre: en llamas.webp', 'los juegos del hambre: en llamas'),
(109, '../almacenamiento/portadas/20251116231549_los límites de la fundación.jpg', 'los límites de la fundación'),
(110, '../almacenamiento/portadas/20251116231557_más allá del bien y del mal.webp', 'más allá del bien y del mal'),
(111, '../almacenamiento/portadas/20251116231619_nuevo rincón de haikus.webp', 'nuevo rincón de haikus'),
(112, '../almacenamiento/portadas/20251116231633_nuncanoche.webp', 'nuncanoche'),
(113, '../almacenamiento/portadas/20251116231643_palabras radiantes.jpg', 'palabras radiantes'),
(114, '../almacenamiento/portadas/20251116231653_preludio a fundación.webp', 'preludio a fundación'),
(115, '../almacenamiento/portadas/20251116231704_rayuela.jpg', 'rayuela'),
(116, '../almacenamiento/portadas/20251116231719_rebelión en la granja.webp', 'rebelión en la granja'),
(117, '../almacenamiento/portadas/20251116231727_ritmo de la guerra.webp', 'ritmo de la guerra'),
(118, '../almacenamiento/portadas/20251116231741_segunda fundación.webp', 'segunda fundación'),
(119, '../almacenamiento/portadas/20251116231751_ser y tiempo.webp', 'ser y tiempo'),
(120, '../almacenamiento/portadas/20251116231806_sinsajo.png', 'sinsajo'),
(121, '../almacenamiento/portadas/20251116231815_sombras de identidad.webp', 'sombras de identidad'),
(122, '../almacenamiento/portadas/20251116231826_tumbadedioses.jpg', 'tumbadedioses'),
(123, '../almacenamiento/portadas/20251116231849_un mundo feliz.webp', 'un mundo feliz'),
(124, '../almacenamiento/portadas/20251116231903_viaje a la luna.jpg', 'viaje a la luna'),
(125, '../almacenamiento/portadas/20251116231911_viaje al centro de la tierra.jpg', 'viaje al centro de la tierra'),
(126, '../almacenamiento/portadas/20251116231918_viento y verdad.webp', 'viento y verdad'),
(127, '../almacenamiento/portadas/20251116231927_yo, robot.webp', 'yo, robot'),
(128, '../almacenamiento/portadas/20251116232309_el señor de los anillos el retorno del rey.webp', 'el señor de los anillos el retorno del rey'),
(129, '../almacenamiento/portadas/20251116232332_el señor de los anillos la comunidad del anillo.webp', 'el señor de los anillos la comunidad del anillo'),
(130, '../almacenamiento/portadas/20251116232408_el señor de los anillos las dos torres.webp', 'el señor de los anillos las dos torres'),
(131, '../almacenamiento/portadas/20251116232434_los juegos del hambre en llamas.webp', 'los juegos del hambre en llamas'),
(132, '../almacenamiento/portadas/20251116232449_maze runner correr o morir.jpg', 'maze runner correr o morir'),
(133, '../almacenamiento/portadas/20251116232501_maze runner la cura mortal.jpg', 'maze runner la cura mortal'),
(134, '../almacenamiento/portadas/20251116232522_maze runner prueba de fuego.jpg', 'maze runner prueba de fuego'),
(135, '../almacenamiento/portadas/20251116234500_escribir ciencia ficción.webp', 'escribir ciencia ficción'),
(136, '../almacenamiento/portadas/20251116234948_dibujo de historietas.webp', 'dibujo de historietas'),
(137, '../almacenamiento/subidos/20251117003811_Ejercicios de escritura semana 1.pdf.pdf', 'Ejercicios de escritura semana 1.pdf'),
(138, '../almacenamiento/portadas/20251117131051_el pozo de la ascensión.webp', 'el pozo de la ascensión'),
(139, '../almacenamiento/portadas/20251117131309_20000 leguas de viaje submarino.webp', '20000 leguas de viaje submarino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_muerte` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id`, `nombre`, `apellido`, `fecha_nacimiento`, `fecha_muerte`) VALUES
(1, 'Jay', 'Kristoff', '1973-11-11', NULL),
(2, 'Brandon', 'Sanderson', '1975-12-19', NULL),
(3, 'Zygmunt', 'Bauman', '1925-11-19', '2017-01-09'),
(4, 'Friedrich', 'Nietzsche', '1844-10-15', '1900-08-25'),
(5, 'Suzanne', 'Collins', '1962-08-10', NULL),
(6, 'Julio', 'Verne', '1828-02-08', '1905-03-24'),
(7, 'Fiódor', 'Dostoyevski', '1821-11-11', '1881-02-09'),
(8, 'Immanuel', 'Kant', '1724-04-22', '1804-02-12'),
(9, 'Jacques', 'Derrida', '1930-07-15', '2004-10-09'),
(10, 'Hermann', 'Hesse', '1877-07-02', '1962-08-09'),
(11, 'Veronica', 'Roth', '1988-08-19', NULL),
(12, 'Miguel de', 'Cervantes Saavedra', '1547-09-29', '1616-04-22'),
(13, 'Bram', 'Stoker', '1847-11-08', '1912-04-20'),
(14, 'Frank', 'Herbert', '1920-10-08', '1986-02-11'),
(15, 'Jorge Luis', 'Borges', '1899-08-24', '1986-06-14'),
(16, 'Platón', '', '0427-01-01', '0347-01-01'),
(17, 'J.K.', 'Rowling', '1965-07-31', NULL),
(18, 'Karl', 'Marx', '1818-05-05', '1883-03-14'),
(19, 'Bertrand', 'Russell', '1872-05-18', '1970-02-02'),
(20, 'Albert', 'Camus', '1913-11-07', '1960-01-04'),
(21, 'Mark', 'Twain', '1835-11-30', '1910-04-21'),
(22, 'H.G.', 'Wells', '1866-09-21', '1946-08-13'),
(23, 'J.R.R.', 'Tolkien', '1892-01-03', '1973-09-02'),
(24, 'Ray', 'Bradbury', '1920-08-22', '2012-06-05'),
(25, 'Mary', 'Shelley', '1797-08-30', '1851-02-01'),
(26, 'Isaac', 'Asimov', '1920-01-02', '1992-04-06'),
(27, 'Alex', 'Hirsch', '1985-06-18', NULL),
(28, 'El', 'Rubius', '1990-02-13', NULL),
(29, 'Stephen', 'King', '1947-09-21', NULL),
(30, 'Byung-Chul', 'Han', '1959-09-01', NULL),
(31, 'James', 'Dashner', '1972-11-26', NULL),
(32, 'George', 'Orwell', '1903-06-25', '1950-01-21'),
(33, 'Aldous', 'Huxley', '1894-07-26', '1963-11-22'),
(34, 'Antoine de', 'Saint-Exupéry', '1900-06-29', '1944-07-31'),
(35, 'Rick', 'Riordan', '1964-06-05', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

CREATE TABLE `correos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `consulta` text NOT NULL,
  `fecha_envio` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `correos`
--

INSERT INTO `correos` (`id`, `nombre`, `email`, `telefono`, `consulta`, `fecha_envio`) VALUES
(1, 'Antonio Araoz', 'antonio@kobum.com', '1156653223', 'Haciendo la prueba de envío de un mansaje a través del Formulario de Contacto.', '2025-11-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_biblioteca`
--

CREATE TABLE `datos_biblioteca` (
  `mail` varchar(100) DEFAULT NULL,
  `multa` decimal(10,2) DEFAULT NULL,
  `cuota_socio` decimal(10,2) DEFAULT NULL,
  `limite_prestamos_nuevos` int(11) DEFAULT NULL,
  `limite_prestamos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datos_biblioteca`
--

INSERT INTO `datos_biblioteca` (`mail`, `multa`, `cuota_socio`, `limite_prestamos_nuevos`, `limite_prestamos`) VALUES
('kobun@gmail.com', 500.00, 10000.00, 2, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editoriales`
--

CREATE TABLE `editoriales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `editoriales`
--

INSERT INTO `editoriales` (`id`, `nombre`) VALUES
(5, 'Alfaguara'),
(4, 'Anagrama'),
(21, 'Baen Books'),
(25, 'Blackie Books'),
(18, 'Bruguera'),
(7, 'Debolsillo'),
(13, 'Destino'),
(24, 'Edhasa'),
(15, 'Ediciones B'),
(10, 'Gredos'),
(2, 'HarperCollins'),
(19, 'La Bestia Equilátera'),
(6, 'Minotauro'),
(20, 'Nordica Libros'),
(14, 'Nova'),
(22, 'Orbit Books'),
(1, 'Penguin Random House'),
(3, 'Planeta'),
(23, 'Roca Editorial'),
(17, 'Salamandra'),
(16, 'Seix Barral'),
(11, 'Siglo XXI Editores'),
(9, 'Tor Books'),
(12, 'Tusquets Editores'),
(8, 'Vintage Books');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejemplares`
--

CREATE TABLE `ejemplares` (
  `id` int(11) NOT NULL,
  `libro_id` int(11) NOT NULL,
  `codigo_topografico` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejemplares`
--

INSERT INTO `ejemplares` (`id`, `libro_id`, `codigo_topografico`) VALUES
(1, 1, 'LIBNOV1-BKN'),
(2, 1, 'LIBNOV1-BKN'),
(3, 2, 'LIBTOR2-BKN'),
(4, 2, 'LIBTOR2-BKN'),
(5, 3, 'LIBSEI3-BKN'),
(6, 3, 'LIBSEI3-BKN'),
(7, 4, 'LIBGRE4-BKN'),
(8, 4, 'LIBGRE4-BKN'),
(9, 5, 'LIBSAL5-BKN'),
(10, 5, 'LIBSAL5-BKN'),
(11, 6, 'LIBTOR6-BKN'),
(12, 6, 'LIBTOR6-BKN'),
(13, 7, 'LIBEDH7-BKN'),
(14, 7, 'LIBEDH7-BKN'),
(15, 8, 'LIBGRE8-BKN'),
(16, 8, 'LIBGRE8-BKN'),
(17, 9, 'LIBGRE9-BKN'),
(18, 9, 'LIBGRE9-BKN'),
(19, 10, 'LIBTOR10-BKN'),
(20, 10, 'LIBTOR10-BKN'),
(21, 11, 'LIBGRE11-BKN'),
(22, 11, 'LIBGRE11-BKN'),
(23, 12, 'LIBSEI12-BKN'),
(24, 12, 'LIBSEI12-BKN'),
(25, 13, 'LIBSAL13-BKN'),
(26, 13, 'LIBSAL13-BKN'),
(27, 14, 'LIBGRE14-BKN'),
(28, 14, 'LIBGRE14-BKN'),
(29, 15, 'LIBPLA15-BKN'),
(30, 15, 'LIBPLA15-BKN'),
(31, 16, 'LIBTOR16-BKN'),
(32, 16, 'LIBTOR16-BKN'),
(33, 17, 'LIBTOR17-BKN'),
(34, 17, 'LIBTOR17-BKN'),
(35, 18, 'LIBTUS18-BKN'),
(36, 18, 'LIBTUS18-BKN'),
(37, 19, 'LIBSEI19-BKN'),
(38, 19, 'LIBSEI19-BKN'),
(39, 20, 'LIBSEI20-BKN'),
(40, 20, 'LIBSEI20-BKN'),
(41, 21, 'LIBTOR21-BKN'),
(42, 21, 'LIBTOR21-BKN'),
(43, 22, 'LIBGRE22-BKN'),
(44, 22, 'LIBGRE22-BKN'),
(45, 23, 'LIBSAL23-BKN'),
(46, 23, 'LIBSAL23-BKN'),
(47, 24, 'LIBTOR24-BKN'),
(48, 24, 'LIBTOR24-BKN'),
(49, 25, 'LIBSIG25-BKN'),
(50, 25, 'LIBSIG25-BKN'),
(51, 26, 'LIBGRE26-BKN'),
(52, 26, 'LIBGRE26-BKN'),
(53, 27, 'LIBSEI27-BKN'),
(54, 27, 'LIBSEI27-BKN'),
(55, 28, 'LIBEDH28-BKN'),
(56, 28, 'LIBEDH28-BKN'),
(57, 29, 'LIBLA 29-BKN'),
(58, 29, 'LIBLA 29-BKN'),
(59, 30, 'LIBTOR30-BKN'),
(60, 30, 'LIBTOR30-BKN'),
(61, 31, 'LIBPLA31-BKN'),
(62, 31, 'LIBPLA31-BKN'),
(63, 32, 'LIBPLA32-BKN'),
(64, 32, 'LIBPLA32-BKN'),
(65, 33, 'LIBTOR33-BKN'),
(66, 33, 'LIBTOR33-BKN'),
(67, 34, 'LIBSAL34-BKN'),
(68, 34, 'LIBSAL34-BKN'),
(69, 35, 'LIBBLA35-BKN'),
(70, 35, 'LIBBLA35-BKN'),
(71, 36, 'LIBBLA36-BKN'),
(72, 36, 'LIBBLA36-BKN'),
(73, 37, 'LIBSAL37-BKN'),
(74, 37, 'LIBSAL37-BKN'),
(75, 38, 'LIBTOR38-BKN'),
(76, 38, 'LIBTOR38-BKN'),
(77, 39, 'LIBPLA39-BKN'),
(78, 39, 'LIBPLA39-BKN'),
(79, 40, 'LIBSAL40-BKN'),
(80, 40, 'LIBSAL40-BKN'),
(81, 41, 'LIBSEI41-BKN'),
(82, 41, 'LIBSEI41-BKN'),
(83, 42, 'LIBPLA42-BKN'),
(84, 42, 'LIBPLA42-BKN'),
(85, 43, 'LIBPLA43-BKN'),
(86, 43, 'LIBPLA43-BKN'),
(87, 44, 'LIBPLA44-BKN'),
(88, 44, 'LIBPLA44-BKN'),
(89, 45, 'LIBTOR45-BKN'),
(90, 45, 'LIBTOR45-BKN'),
(91, 46, 'LIBALF46-BKN'),
(92, 46, 'LIBALF46-BKN'),
(93, 47, 'LIBSEI47-BKN'),
(94, 47, 'LIBSEI47-BKN'),
(95, 48, 'LIBTOR48-BKN'),
(96, 48, 'LIBTOR48-BKN'),
(97, 49, 'LIBTOR49-BKN'),
(98, 49, 'LIBTOR49-BKN'),
(99, 50, 'LIBTOR50-BKN'),
(100, 50, 'LIBTOR50-BKN'),
(101, 51, 'LIBSAL51-BKN'),
(102, 51, 'LIBSAL51-BKN'),
(103, 52, 'LIBSAL52-BKN'),
(104, 52, 'LIBSAL52-BKN'),
(105, 53, 'LIBSAL53-BKN'),
(106, 53, 'LIBSAL53-BKN'),
(107, 54, 'LIBSAL54-BKN'),
(108, 54, 'LIBSAL54-BKN'),
(109, 55, 'LIBSAL55-BKN'),
(110, 55, 'LIBSAL55-BKN'),
(111, 56, 'LIBTOR56-BKN'),
(112, 56, 'LIBTOR56-BKN'),
(113, 57, 'LIBTOR57-BKN'),
(114, 57, 'LIBTOR57-BKN'),
(115, 58, 'LIBTOR58-BKN'),
(116, 58, 'LIBTOR58-BKN'),
(117, 59, 'LIBSEI59-BKN'),
(118, 59, 'LIBSEI59-BKN'),
(119, 60, 'LIBSAL60-BKN'),
(120, 60, 'LIBSAL60-BKN'),
(121, 61, 'LIBPLA61-BKN'),
(122, 61, 'LIBPLA61-BKN'),
(123, 62, 'LIBTOR62-BKN'),
(124, 62, 'LIBTOR62-BKN'),
(125, 63, 'LIBGRE63-BKN'),
(126, 63, 'LIBGRE63-BKN'),
(127, 64, 'LIBSAL64-BKN'),
(128, 64, 'LIBSAL64-BKN'),
(129, 65, 'LIBSAL65-BKN'),
(130, 65, 'LIBSAL65-BKN'),
(131, 66, 'LIBGRE66-BKN'),
(132, 66, 'LIBGRE66-BKN'),
(133, 67, 'LIBPLA67-BKN'),
(134, 67, 'LIBPLA67-BKN'),
(135, 68, 'LIBSAL68-BKN'),
(136, 68, 'LIBSAL68-BKN'),
(137, 69, 'LIBEDH69-BKN'),
(138, 69, 'LIBEDH69-BKN'),
(139, 70, 'LIBSEI70-BKN'),
(140, 70, 'LIBSEI70-BKN'),
(141, 71, 'LIBGRE71-BKN'),
(142, 71, 'LIBGRE71-BKN'),
(143, 72, 'LIBBRU72-BKN'),
(144, 72, 'LIBBRU72-BKN'),
(145, 73, 'LIBLA 73-BKN'),
(146, 73, 'LIBLA 73-BKN'),
(147, 74, 'LIBSAL74-BKN'),
(148, 74, 'LIBSAL74-BKN'),
(149, 75, 'LIBSAL75-BKN'),
(150, 75, 'LIBSAL75-BKN'),
(151, 76, 'LIBSAL76-BKN'),
(152, 76, 'LIBSAL76-BKN'),
(153, 77, 'LIBTOR77-BKN'),
(154, 77, 'LIBTOR77-BKN'),
(155, 78, 'LIBGRE78-BKN'),
(156, 78, 'LIBGRE78-BKN'),
(157, 79, 'LIBSAL79-BKN'),
(158, 79, 'LIBSAL79-BKN'),
(159, 80, 'LIBSAL80-BKN'),
(160, 80, 'LIBSAL80-BKN'),
(161, 81, 'LIBSAL81-BKN'),
(162, 81, 'LIBSAL81-BKN'),
(163, 82, 'LIBNOR82-BKN'),
(164, 82, 'LIBNOR82-BKN'),
(165, 83, 'LIBNOV83-BKN'),
(166, 83, 'LIBNOV83-BKN'),
(167, 84, 'LIBTOR84-BKN'),
(168, 84, 'LIBTOR84-BKN'),
(169, 85, 'LIBTOR85-BKN'),
(170, 85, 'LIBTOR85-BKN'),
(171, 86, 'LIBTUS86-BKN'),
(172, 86, 'LIBTUS86-BKN'),
(173, 87, 'LIBPLA87-BKN'),
(174, 87, 'LIBPLA87-BKN'),
(175, 88, 'LIBTOR88-BKN'),
(176, 88, 'LIBTOR88-BKN'),
(177, 89, 'LIBTOR89-BKN'),
(178, 89, 'LIBTOR89-BKN'),
(179, 90, 'LIBGRE90-BKN'),
(180, 90, 'LIBGRE90-BKN'),
(181, 91, 'LIBSAL91-BKN'),
(182, 91, 'LIBSAL91-BKN'),
(183, 92, 'LIBTOR92-BKN'),
(184, 92, 'LIBTOR92-BKN'),
(185, 93, 'LIBNOV93-BKN'),
(186, 93, 'LIBNOV93-BKN'),
(187, 94, 'LIBPLA94-BKN'),
(188, 94, 'LIBPLA94-BKN'),
(189, 95, 'LIBEDH95-BKN'),
(190, 95, 'LIBEDH95-BKN'),
(191, 96, 'LIBEDH96-BKN'),
(192, 96, 'LIBEDH96-BKN'),
(193, 97, 'LIBEDH97-BKN'),
(194, 97, 'LIBEDH97-BKN'),
(195, 98, 'LIBTUS98-BKN'),
(196, 98, 'LIBTUS98-BKN'),
(197, 99, 'LIBBAE99-BKN'),
(198, 99, 'LIBBAE99-BKN'),
(199, 2, 'LIBTOR2-BKN');

--
-- Disparadores `ejemplares`
--
DELIMITER $$
CREATE TRIGGER `asignar_codigo_topografico` BEFORE INSERT ON `ejemplares` FOR EACH ROW BEGIN
    DECLARE v_editorial VARCHAR(100);
    DECLARE v_prefijo VARCHAR(3);
    DECLARE v_codigo VARCHAR(50);

    SELECT e.nombre INTO v_editorial
    FROM Libros_Editoriales le 
	LEFT JOIN editoriales e ON le.editorial_id = e.id
    WHERE le.libro_id = NEW.libro_id
    LIMIT 1;

    SET v_prefijo = UPPER(LEFT(v_editorial, 3));

    SET v_codigo = CONCAT('LIB', v_prefijo, NEW.libro_id, '-', NEW.id);

 	SET NEW.codigo_topografico = CONCAT('LIB', v_prefijo, NEW.libro_id, '-BKN');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `generos`
--

CREATE TABLE `generos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `generos`
--

INSERT INTO `generos` (`id`, `nombre`) VALUES
(19, 'Autobiografía'),
(9, 'Aventura'),
(20, 'Ciencia'),
(1, 'Ciencia ficción'),
(23, 'Crítica literaria'),
(16, 'Cuento'),
(12, 'Distopía'),
(22, 'Economía'),
(6, 'Ensayo'),
(24, 'Épica'),
(18, 'Erotismo'),
(15, 'Fábula'),
(2, 'Fantasía'),
(3, 'Filosofía'),
(25, 'Humor'),
(13, 'Misterio'),
(14, 'Mitología'),
(7, 'Novela clásica'),
(11, 'Poesía'),
(21, 'Política'),
(4, 'Psicología'),
(17, 'Religión'),
(10, 'Romance'),
(5, 'Sociología'),
(8, 'Terror');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `sinopsis` text DEFAULT NULL,
  `ref_portada` varchar(100) DEFAULT NULL,
  `fecha_alta` date DEFAULT curdate(),
  `activo` tinyint(1) DEFAULT 1,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `isbn`, `titulo`, `sinopsis`, `ref_portada`, `fecha_alta`, `activo`, `descripcion`) VALUES
(1, '9788409500011', 'Albaoscura', 'Una fantasía oscura y poética donde el poder y la luz se enfrentan en una guerra ancestral.', '32', '2025-11-13', 1, '624 páginas'),
(2, '9788413140022', 'Aleación de ley', 'Una historia del universo de Nacidos de la Bruma donde la magia y la tecnología chocan en un western moderno.', '33', '2025-11-13', 1, '384 páginas'),
(3, '9788497930033', 'Amor líquido', 'Zygmunt Bauman analiza la fragilidad de los vínculos humanos en la era moderna.', '34', '2025-11-13', 1, '224 páginas'),
(4, '9788420680044', 'Así habló Zaratustra', 'La obra filosófica de Nietzsche que redefine el sentido de la moral y el superhombre.', '35', '2025-11-13', 1, '352 páginas'),
(5, '9788416860055', 'Balada de pájaros cantores y serpientes', 'Precuela de Los Juegos del Hambre que narra los orígenes del presidente Snow.', '36', '2025-11-13', 1, '528 páginas'),
(6, '9788445000066', 'Brazales de duelo', 'Waxillium Ladrian se enfrenta a los secretos de su linaje en esta secuela de Aleación de ley.', '37', '2025-11-13', 1, '480 páginas'),
(7, '9788408000077', 'Cinco semanas en globo', 'Julio Verne narra una travesía aérea por África en una de sus aventuras más célebres.', '38', '2025-11-13', 1, '320 páginas'),
(8, '9788420430088', 'Crimen y castigo', 'Dostoyevski explora la culpa y la redención a través del atormentado Raskólnikov.', '39', '2025-11-13', 1, '672 páginas'),
(9, '9788437600099', 'Crítica de la razón pura', 'Immanuel Kant estudia los límites del conocimiento y las condiciones de la experiencia.', '40', '2025-11-13', 1, '784 páginas'),
(10, '9788417340100', 'Danzante del filo', 'Una guerrera busca redención y honor en un mundo dividido por la guerra.', '41', '2025-11-13', 1, '624 páginas'),
(11, '9788495270111', 'De la gramatología', 'Jacques Derrida deconstruye los fundamentos del lenguaje y la escritura.', '42', '2025-11-13', 1, '456 páginas'),
(12, '9788426400122', 'Demian', 'Hermann Hesse explora el autodescubrimiento y la dualidad del alma.', '43', '2025-11-13', 1, '240 páginas'),
(13, '9788499300133', 'Divergente', 'Una joven desafía un sistema que clasifica a las personas según sus virtudes.', '44', '2025-11-13', 1, '480 páginas'),
(14, '9788408120144', 'Don Quijote de la Mancha', 'La obra maestra de Cervantes sobre el idealismo, la locura y la libertad.', '45', '2025-11-13', 1, '1056 páginas'),
(15, '9788491050155', 'Drácula', 'Bram Stoker da vida al vampiro más famoso de la literatura gótica.', '46', '2025-11-13', 1, '448 páginas'),
(16, '9788445070166', 'Duna', 'Frank Herbert presenta una épica de poder, religión y ecología en el planeta Arrakis.', '47', '2025-11-13', 1, '688 páginas'),
(17, '9788415610177', 'El pozo de la ascensión', 'La lucha por un imperio continúa mientras nuevos enemigos acechan desde las sombras.', '138', '2025-11-13', 1, '720 páginas'),
(18, '9788420410188', 'El aleph', 'Jorge Luis Borges reúne relatos sobre lo infinito, lo divino y lo imposible.', '48', '2025-11-13', 1, '224 páginas'),
(19, '9788466350199', 'El amor, las mujeres y la vida', 'Mario Benedetti celebra la ternura y el deseo en su poesía más íntima.', '50', '2025-11-13', 1, '192 páginas'),
(20, '9788415730200', 'El amor, las mujeres y la muerte', 'Arthur Schopenhauer reflexiona sobre el amor como impulso y tragedia.', '49', '2025-11-13', 1, '256 páginas'),
(21, '9788466640211', 'Elantris', 'La primera novela de Brandon Sanderson, sobre una ciudad maldita y la fe perdida.', '77', '2025-11-13', 1, '640 páginas'),
(22, '9788420670222', 'El banquete', 'Platón reflexiona sobre el amor y la belleza a través de un diálogo filosófico.', '51', '2025-11-13', 1, '192 páginas'),
(23, '9788467070233', 'El cáliz de los dioses', 'Rick Riordan continúa las aventuras de Percy Jackson en una nueva misión divina.', '52', '2025-11-13', 1, '416 páginas'),
(24, '9788417340244', 'El camino de los reyes', 'Primer volumen de El archivo de las tormentas, una epopeya de magia y liderazgo.', '53', '2025-11-13', 1, '1248 páginas'),
(25, '9788420670255', 'El capital', 'Karl Marx analiza las dinámicas del capitalismo y las relaciones de producción.', '54', '2025-11-13', 1, '912 páginas'),
(26, '9788445070266', 'El conocimiento humano', 'Bertrand Russell examina los fundamentos de la verdad, la razón y la experiencia.', '55', '2025-11-13', 1, '368 páginas'),
(27, '9788420670279', 'El extranjero', 'Albert Camus presenta la indiferencia y el absurdo en la vida de Meursault.', '56', '2025-11-13', 1, '184 páginas'),
(28, '9788408000280', 'El faro del fin del mundo', 'Una historia de naufragios y supervivencia escrita por Julio Verne.', '57', '2025-11-13', 1, '288 páginas'),
(29, '9788497590299', 'El forastero misterioso', 'Mark Twain aborda la moral y el sentido de la existencia a través del diablo joven.', '58', '2025-11-13', 1, '176 páginas'),
(30, '9788417340305', 'El héroe de las eras', 'El desenlace épico de Nacidos de la Bruma, donde el mundo enfrenta su fin.', '59', '2025-11-13', 1, '792 páginas'),
(31, '9788497590312', 'El hobbit', 'La precuela de El señor de los anillos, protagonizada por Bilbo Bolsón.', '60', '2025-11-13', 1, '320 páginas'),
(32, '9788497590329', 'El hombre invisible', 'H. G. Wells presenta un experimento científico que conduce a la locura.', '61', '2025-11-13', 1, '224 páginas'),
(33, '9788417340330', 'El imperio final', 'Brandon Sanderson inicia la saga de Nacidos de la Bruma, donde llueve ceniza y gobierna la oscuridad.', '62', '2025-11-13', 1, '672 páginas'),
(34, '9788497590343', 'El ladrón del rayo', 'Percy Jackson descubre que es hijo de un dios y debe impedir una guerra olímpica.', '63', '2025-11-13', 1, '384 páginas'),
(35, '9788417340354', 'El libro de Bill', 'Un compendio humorístico del universo de Gravity Falls con secretos y acertijos.', '64', '2025-11-13', 1, '160 páginas'),
(36, '9788417340361', 'El libro troll del Rubius', 'Una aventura interactiva y caótica creada por el popular youtuber El Rubius.', '65', '2025-11-13', 1, '192 páginas'),
(37, '9788497590374', 'El mar de monstruos', 'Percy Jackson regresa al mar donde habitan criaturas mitológicas y peligrosas.', '66', '2025-11-13', 1, '304 páginas'),
(38, '9788417340385', 'El metal perdido', 'La conclusión de la saga de Wax y Wayne, donde el destino del mundo está en juego.', '67', '2025-11-13', 1, '672 páginas'),
(39, '9788497590398', 'El principito', 'El clásico de Antoine de Saint-Exupéry sobre la inocencia, la amistad y el amor.', '68', '2025-11-13', 1, '112 páginas'),
(40, '9788497590404', 'El prisionero de Azkaban', 'Harry Potter enfrenta a un fugitivo peligroso y descubre verdades sobre su pasado.', '69', '2025-11-13', 1, '448 páginas'),
(41, '9788497590411', 'El retrato de Dorian Gray', 'Oscar Wilde narra la decadencia moral de un hombre que nunca envejece.', '70', '2025-11-13', 1, '304 páginas'),
(42, '9788497590428', 'El señor de los anillos: El retorno del rey', 'El final de la saga épica de Tolkien, con la batalla definitiva por la Tierra Media.', '128', '2025-11-13', 1, '1344 páginas'),
(43, '9788497590435', 'El señor de los anillos: La comunidad del anillo', 'El inicio del viaje de Frodo y la Comunidad hacia Mordor.', '129', '2025-11-13', 1, '1216 páginas'),
(44, '9788497590442', 'El señor de los anillos: Las dos torres', 'El viaje se divide, las alianzas cambian y la oscuridad se cierne sobre la Tierra Media.', '130', '2025-11-13', 1, '1176 páginas'),
(45, '9788497590459', 'El Silmarillion', 'El origen del mundo de Tolkien: dioses, héroes y la creación de Arda.', '76', '2025-11-13', 1, '512 páginas'),
(46, '9788497590466', 'Fahrenheit 451', 'Una sociedad sin libros ni pensamiento crítico, donde leer es un crimen.', '78', '2025-11-13', 1, '256 páginas'),
(47, '9788497590473', 'Frankenstein', 'Mary Shelley crea la historia del hombre que desafió a la muerte y su criatura inmortal.', '79', '2025-11-13', 1, '280 páginas'),
(48, '9788497590480', 'Fundación', 'Isaac Asimov inicia la saga sobre la caída de un imperio galáctico.', '80', '2025-11-13', 1, '288 páginas'),
(49, '9788497590497', 'Fundación y Tierra', 'La humanidad busca sus orígenes en los confines de la galaxia.', '81', '2025-11-13', 1, '416 páginas'),
(50, '9788497590503', 'Hacia la Fundación', 'El preludio final a la saga, donde Hari Seldon consolida su visión del futuro.', '82', '2025-11-13', 1, '448 páginas'),
(51, '9788497590510', 'Harry Potter y el cáliz de fuego', 'Harry enfrenta un torneo mortal y el regreso de Lord Voldemort.', '83', '2025-11-13', 1, '640 páginas'),
(52, '9788497590527', 'Harry Potter y el misterio del príncipe', 'El sexto año en Hogwarts revela secretos del pasado del Señor Tenebroso.', '84', '2025-11-13', 1, '608 páginas'),
(53, '9788497590534', 'Harry Potter y la orden del fénix', 'Harry se une a una resistencia secreta mientras el Ministerio niega la verdad.', '85', '2025-11-13', 1, '896 páginas'),
(54, '9788497590541', 'Harry Potter y la piedra filosofal', 'El inicio de la saga mágica más famosa, donde un niño descubre su destino.', '86', '2025-11-13', 1, '320 páginas'),
(55, '9788497590558', 'Harry Potter y las reliquias de la muerte', 'El desenlace épico de la saga, donde la batalla final decide el destino del mundo mágico.', '87', '2025-11-13', 1, '736 páginas'),
(56, '9788497590565', 'Herejes de Duna', 'Los herederos de Paul Atreides enfrentan nuevas fuerzas en el desierto de Arrakis.', '88', '2025-11-13', 1, '624 páginas'),
(57, '9788497590572', 'Hijos de Duna', 'La continuación del destino de la casa Atreides entre política y religión.', '89', '2025-11-13', 1, '704 páginas'),
(58, '9788497590589', 'Hyperion', 'Una expedición hacia un mundo lejano revela los secretos del misterioso Alcaudón.', '90', '2025-11-13', 1, '496 páginas'),
(59, '9788497590596', 'Indigno de ser humano', 'Osamu Dazai narra el derrumbe existencial de un hombre incapaz de encajar.', '91', '2025-11-13', 1, '224 páginas'),
(60, '9788497590602', 'Insurgente', 'La rebelión se extiende mientras Tris Prior enfrenta las consecuencias de sus decisiones.', '92', '2025-11-13', 1, '464 páginas'),
(61, '9788497590619', 'IT', 'Stephen King convierte la infancia en un campo de batalla contra un mal que adopta forma de payaso.', '93', '2025-11-13', 1, '1504 páginas'),
(62, '9788497590626', 'Juramentada', 'La tercera entrega de El archivo de las tormentas, una historia de guerra, traición y redención.', '94', '2025-11-13', 1, '1248 páginas'),
(63, '9788497590633', 'Kamasutra', 'El texto clásico hindú sobre el arte del amor, el deseo y la vida cotidiana.', '95', '2025-11-13', 1, '240 páginas'),
(64, '9788497590640', 'La batalla del laberinto', 'Percy Jackson enfrenta una guerra inminente mientras el laberinto de Dédalo esconde sus trampas.', '96', '2025-11-13', 1, '368 páginas'),
(65, '9788497590657', 'La cámara secreta', 'Harry Potter regresa a Hogwarts y descubre un antiguo peligro escondido en sus muros.', '97', '2025-11-13', 1, '384 páginas'),
(66, '9788497590664', 'La gaya ciencia', 'Nietzsche celebra la creatividad, la alegría y el eterno retorno del espíritu libre.', '98', '2025-11-13', 1, '384 páginas'),
(67, '9788497590671', 'La guerra de los mundos', 'H. G. Wells narra la invasión marciana que desafía la supervivencia de la humanidad.', '99', '2025-11-13', 1, '304 páginas'),
(68, '9788497590688', 'La maldición del titán', 'Percy y sus amigos deben rescatar a un dios desaparecido en una peligrosa misión.', '100', '2025-11-13', 1, '312 páginas'),
(69, '9788497590695', 'La máquina del tiempo', 'Un científico viaja al futuro y descubre la decadencia de la civilización humana.', '101', '2025-11-13', 1, '192 páginas'),
(70, '9788497590701', 'La razón de estar contigo', 'Una conmovedora historia contada desde la perspectiva de un perro que busca su propósito.', '102', '2025-11-13', 1, '352 páginas'),
(71, '9788497590718', 'La república', 'Platón expone su modelo ideal de justicia, política y sociedad.', '103', '2025-11-13', 1, '416 páginas'),
(72, '9788497590725', 'Las montañas de la locura', 'H. P. Lovecraft narra una expedición antártica que revela horrores ancestrales.', '105', '2025-11-13', 1, '240 páginas'),
(73, '9788497590732', 'La sociedad del cansancio', 'Byung-Chul Han analiza el agotamiento psicológico y la presión del rendimiento.', '104', '2025-11-13', 1, '128 páginas'),
(74, '9788497590749', 'Leal', 'El desenlace de la trilogía Divergente, marcado por la traición y el sacrificio.', '106', '2025-11-13', 1, '496 páginas'),
(75, '9788497590756', 'Los juegos del hambre: En llamas', 'Katniss Everdeen regresa a la arena en una rebelión en ciernes.', '131', '2025-11-13', 1, '416 páginas'),
(76, '9788497590763', 'Los juegos del hambre', 'Un mundo distópico donde adolescentes luchan a muerte en un cruel espectáculo.', '107', '2025-11-13', 1, '400 páginas'),
(77, '9788497590770', 'Los límites de la fundación', 'Asimov expande su universo hacia los márgenes del poder galáctico.', '109', '2025-11-13', 1, '512 páginas'),
(78, '9788497590787', 'Más allá del bien y del mal', 'Nietzsche examina la moral tradicional y propone una nueva filosofía de la fuerza.', '110', '2025-11-13', 1, '288 páginas'),
(79, '9788497590794', 'Maze Runner: Correr o morir', 'Un grupo de jóvenes despierta atrapado en un laberinto mortal sin recuerdos.', '132', '2025-11-13', 1, '384 páginas'),
(80, '9788497590800', 'Maze Runner: Prueba de fuego', 'Thomas y sus amigos enfrentan el calor, la locura y nuevas pruebas del CRUEL.', '134', '2025-11-13', 1, '384 páginas'),
(81, '9788497590817', 'Maze Runner: La cura mortal', 'El destino de la humanidad se decide en la última entrega de la trilogía.', '133', '2025-11-13', 1, '416 páginas'),
(82, '9788497590824', 'Nuevo rincón de haikus', 'Una colección de breves poemas que capturan lo efímero y lo eterno.', '111', '2025-11-13', 1, '96 páginas'),
(83, '9788497590831', 'Nuncanoche', 'Jay Kristoff presenta una historia de venganza, sombras y espadas en un imperio de asesinos.', '112', '2025-11-13', 1, '640 páginas'),
(84, '9788497590848', 'Palabras radiantes', 'La segunda entrega de El archivo de las tormentas, una epopeya sobre poder y esperanza.', '113', '2025-11-13', 1, '1280 páginas'),
(85, '9788497590855', 'Preludio a Fundación', 'Hari Seldon descubre los principios de la psicohistoria en el inicio del mito asimoviano.', '114', '2025-11-13', 1, '432 páginas'),
(86, '9788497590862', 'Rayuela', 'Julio Cortázar rompe las reglas de la narrativa en una obra que invita a saltar entre capítulos.', '115', '2025-11-13', 1, '736 páginas'),
(87, '9788497590879', 'Rebelión en la granja', 'George Orwell satiriza los totalitarismos con una fábula protagonizada por animales.', '116', '2025-11-13', 1, '144 páginas'),
(88, '9788497590886', 'Ritmo de la guerra', 'La cuarta entrega del Archivo de las tormentas continúa la lucha por la salvación de Roshar.', '117', '2025-11-13', 1, '1376 páginas'),
(89, '9788497590893', 'Segunda Fundación', 'La misteriosa organización que vela por el futuro de la galaxia sale de las sombras.', '118', '2025-11-13', 1, '320 páginas'),
(90, '9788497590909', 'Ser y tiempo', 'Martin Heidegger analiza el sentido del ser y la existencia humana.', '119', '2025-11-13', 1, '592 páginas'),
(91, '9788497590916', 'Sinsajo', 'Katniss se convierte en símbolo de la rebelión en la conclusión de la trilogía.', '120', '2025-11-13', 1, '448 páginas'),
(92, '9788497590923', 'Sombras de identidad', 'Una historia de misterio y política ambientada en el universo de los Nacidos de la Bruma.', '121', '2025-11-13', 1, '560 páginas'),
(93, '9788497590930', 'Tumbadedioses', 'Jay Kristoff culmina la trilogía de Nuncanoche con una venganza sangrienta y gloriosa.', '122', '2025-11-13', 1, '720 páginas'),
(94, '9788497590947', 'Un mundo feliz', 'Aldous Huxley imagina una sociedad aparentemente perfecta controlada por el placer.', '123', '2025-11-13', 1, '288 páginas'),
(95, '9788497590954', '20000 leguas de viaje submarino', 'Julio Verne narra la exploración marina a bordo del mítico Nautilus.', '139', '2025-11-13', 1, '480 páginas'),
(96, '9788497590961', 'Viaje a la luna', 'Un grupo de científicos viaja al espacio impulsado por un gigantesco cañón.', '124', '2025-11-13', 1, '240 páginas'),
(97, '9788497590978', 'Viaje al centro de la tierra', 'Una aventura subterránea hacia los misterios ocultos del planeta.', '125', '2025-11-13', 1, '304 páginas'),
(98, '9788497590985', 'Viento y verdad', 'Una novela sobre los lazos, las pérdidas y el poder de las palabras.', '126', '2025-11-13', 1, '416 páginas'),
(99, '9788497590992', 'Yo, robot', 'Isaac Asimov reúne relatos que definen las leyes de la robótica y el futuro de la humanidad.', '127', '2025-11-13', 1, '320 páginas'),
(100, '12345', 'El Espacio entre las Palabras', 'Ni idea, sobre el espacio entre las palabras bro.', '31', '2025-11-15', 0, '460');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros_autores`
--

CREATE TABLE `libros_autores` (
  `libro_id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros_autores`
--

INSERT INTO `libros_autores` (`libro_id`, `autor_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 2),
(7, 6),
(8, 7),
(9, 8),
(10, 1),
(11, 9),
(12, 10),
(13, 11),
(14, 12),
(15, 13),
(16, 14),
(17, 2),
(18, 15),
(19, 4),
(20, 4),
(21, 2),
(22, 16),
(23, 17),
(24, 2),
(25, 18),
(26, 19),
(27, 20),
(28, 6),
(29, 21),
(30, 2),
(31, 23),
(32, 22),
(33, 2),
(34, 35),
(35, 27),
(36, 28),
(37, 35),
(38, 2),
(39, 34),
(40, 17),
(41, 22),
(42, 23),
(43, 23),
(44, 23),
(45, 23),
(46, 24),
(47, 25),
(48, 26),
(49, 26),
(50, 26),
(51, 17),
(52, 17),
(53, 17),
(54, 17),
(55, 17),
(56, 14),
(57, 14),
(58, 26),
(59, 20),
(60, 11),
(61, 29),
(62, 2),
(63, 30),
(64, 35),
(65, 17),
(66, 4),
(67, 22),
(68, 35),
(69, 22),
(70, 35),
(71, 16),
(72, 31),
(73, 30),
(74, 11),
(75, 5),
(76, 5),
(77, 26),
(78, 4),
(79, 31),
(80, 31),
(81, 31),
(82, 15),
(83, 1),
(84, 2),
(85, 26),
(86, 15),
(87, 32),
(88, 2),
(89, 26),
(90, 33),
(91, 5),
(92, 2),
(93, 1),
(94, 33),
(95, 6),
(96, 6),
(97, 6),
(98, 2),
(99, 26),
(100, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros_editoriales`
--

CREATE TABLE `libros_editoriales` (
  `libro_id` int(11) NOT NULL,
  `editorial_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros_editoriales`
--

INSERT INTO `libros_editoriales` (`libro_id`, `editorial_id`) VALUES
(1, 14),
(2, 9),
(3, 16),
(4, 10),
(5, 17),
(6, 9),
(7, 24),
(8, 10),
(9, 10),
(10, 9),
(11, 10),
(12, 16),
(13, 17),
(14, 10),
(15, 3),
(16, 9),
(17, 9),
(18, 12),
(19, 16),
(20, 16),
(21, 9),
(22, 10),
(23, 17),
(24, 9),
(25, 11),
(26, 10),
(27, 16),
(28, 24),
(29, 19),
(30, 9),
(31, 3),
(32, 3),
(33, 9),
(34, 17),
(35, 25),
(36, 25),
(37, 17),
(38, 9),
(39, 3),
(40, 17),
(41, 16),
(42, 3),
(43, 3),
(44, 3),
(45, 9),
(46, 5),
(47, 16),
(48, 9),
(49, 9),
(50, 9),
(51, 17),
(52, 17),
(53, 17),
(54, 17),
(55, 17),
(56, 9),
(57, 9),
(58, 9),
(59, 16),
(60, 17),
(61, 3),
(62, 9),
(63, 10),
(64, 17),
(65, 17),
(66, 10),
(67, 3),
(68, 17),
(69, 24),
(70, 16),
(71, 10),
(72, 18),
(73, 19),
(74, 17),
(75, 17),
(76, 17),
(77, 9),
(78, 10),
(79, 17),
(80, 17),
(81, 17),
(82, 20),
(83, 14),
(84, 9),
(85, 9),
(86, 12),
(87, 3),
(88, 9),
(89, 9),
(90, 10),
(91, 17),
(92, 9),
(93, 14),
(94, 3),
(95, 24),
(96, 24),
(97, 24),
(98, 12),
(99, 21),
(100, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros_generos`
--

CREATE TABLE `libros_generos` (
  `libro_id` int(11) NOT NULL,
  `genero_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros_generos`
--

INSERT INTO `libros_generos` (`libro_id`, `genero_id`) VALUES
(1, 2),
(1, 9),
(2, 2),
(2, 24),
(3, 5),
(3, 6),
(4, 3),
(5, 2),
(5, 12),
(6, 2),
(6, 24),
(7, 9),
(7, 24),
(8, 4),
(8, 7),
(9, 3),
(9, 6),
(10, 2),
(10, 24),
(11, 6),
(11, 23),
(12, 4),
(12, 7),
(13, 2),
(13, 12),
(14, 7),
(14, 15),
(15, 7),
(15, 8),
(16, 2),
(16, 9),
(17, 7),
(17, 23),
(18, 10),
(18, 11),
(19, 4),
(19, 6),
(20, 2),
(20, 24),
(21, 3),
(21, 17),
(22, 2),
(22, 9),
(23, 2),
(23, 24),
(24, 3),
(24, 20),
(25, 4),
(25, 6),
(26, 7),
(26, 9),
(27, 7),
(27, 9),
(28, 2),
(28, 9),
(29, 2),
(29, 9),
(30, 2),
(30, 24),
(31, 2),
(31, 8),
(32, 2),
(32, 9),
(33, 2),
(33, 24),
(34, 6),
(35, 25),
(36, 2),
(36, 9),
(37, 2),
(37, 9),
(38, 2),
(38, 9),
(39, 2),
(39, 9),
(40, 2),
(40, 9),
(41, 2),
(41, 9),
(42, 8),
(42, 12),
(43, 7),
(43, 8),
(44, 2),
(44, 9),
(45, 2),
(45, 9),
(46, 2),
(46, 9),
(47, 2),
(47, 9),
(48, 2),
(48, 9),
(49, 2),
(49, 9),
(50, 2),
(50, 9),
(51, 2),
(51, 9),
(52, 2),
(52, 9),
(53, 2),
(53, 9),
(54, 2),
(54, 9),
(55, 2),
(55, 9),
(56, 2),
(56, 9),
(57, 2),
(57, 9),
(58, 2),
(58, 9),
(59, 3),
(59, 6),
(60, 2),
(60, 9),
(61, 2),
(61, 9),
(62, 3),
(62, 6),
(63, 2),
(63, 12),
(64, 2),
(64, 12),
(65, 3),
(65, 6),
(66, 3),
(66, 6),
(67, 3),
(67, 6),
(68, 2),
(68, 9),
(69, 2),
(69, 9),
(70, 2),
(70, 9),
(71, 2),
(71, 9),
(72, 11),
(73, 2),
(73, 9),
(74, 2),
(74, 9),
(75, 3),
(75, 6),
(76, 3),
(76, 6),
(77, 2),
(77, 9),
(78, 3),
(78, 6),
(79, 2),
(79, 9),
(80, 2),
(80, 9),
(81, 2),
(81, 9),
(82, 3),
(82, 6),
(83, 3),
(83, 6),
(84, 3),
(84, 6),
(85, 2),
(85, 9),
(86, 2),
(86, 9),
(87, 3),
(87, 6),
(88, 2),
(88, 9),
(89, 3),
(89, 6),
(90, 2),
(90, 9),
(91, 2),
(91, 9),
(92, 7),
(92, 9),
(93, 3),
(93, 6),
(94, 2),
(94, 9),
(95, 3),
(95, 6),
(96, 9),
(96, 20),
(97, 2),
(97, 9),
(98, 6),
(98, 10),
(99, 9),
(100, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multas`
--

CREATE TABLE `multas` (
  `id` int(11) NOT NULL,
  `socio_id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_alta` date DEFAULT curdate(),
  `fecha_pago` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `multas`
--

INSERT INTO `multas` (`id`, `socio_id`, `monto`, `fecha_alta`, `fecha_pago`) VALUES
(1, 8, 500.00, '2025-11-16', NULL),
(2, 8, 500.00, '2025-11-16', NULL),
(3, 7, 1500.00, '2025-11-16', NULL),
(4, 7, 1500.00, '2025-11-16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `socio_id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `razon` varchar(100) DEFAULT NULL,
  `medio` enum('efectivo','transferencia') DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `socio_id`, `monto`, `razon`, `medio`, `fecha`) VALUES
(4, 7, 5.00, 'Multa', 'efectivo', '2025-11-15 21:17:29'),
(5, 9, 10000.00, 'Cuota', '', '2025-11-17 00:00:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL,
  `socio_id` int(11) NOT NULL,
  `ejemplar_id` int(11) NOT NULL,
  `fecha_prestamo` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_vencimiento` date NOT NULL,
  `fecha_devolucion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `socio_id`, `ejemplar_id`, `fecha_prestamo`, `fecha_vencimiento`, `fecha_devolucion`) VALUES
(2, 4, 15, '2025-10-04 20:25:43', '2025-10-18', '2025-10-16'),
(3, 5, 26, '2025-08-05 20:25:43', '2025-08-19', '2025-08-17'),
(5, 6, 30, '2025-09-24 20:25:43', '2025-10-08', '2025-10-18'),
(11, 4, 21, '2025-10-23 20:25:43', '2025-11-06', NULL),
(12, 5, 12, '2025-09-30 20:25:43', '2025-10-14', NULL),
(13, 7, 2, '2025-11-13 22:05:22', '2025-11-13', '2025-11-16'),
(14, 7, 3, '2025-11-13 22:05:40', '2025-11-13', '2025-11-16'),
(15, 8, 77, '2025-11-15 20:27:53', '2025-11-18', '2025-11-15'),
(16, 8, 5, '2025-11-15 20:32:09', '2025-11-15', '2025-11-15'),
(17, 8, 7, '2025-11-15 21:42:00', '2025-11-15', '2025-11-16'),
(18, 8, 13, '2025-11-15 21:44:41', '2025-11-15', '2025-11-16'),
(19, 7, 15, '2025-11-16 23:52:30', '2025-11-17', '2025-11-16'),
(20, 9, 7, '2025-11-17 00:01:40', '2025-12-02', NULL);

--
-- Disparadores `prestamos`
--
DELIMITER $$
CREATE TRIGGER `generar_multa_por_retraso` AFTER UPDATE ON `prestamos` FOR EACH ROW BEGIN
    DECLARE dias_retraso INT;
    DECLARE monto_por_dia DECIMAL(10,2);
    DECLARE total_multa DECIMAL(10,2);

    -- Obtener el valor del monto diario desde la configuración
    SELECT multa INTO monto_por_dia
    FROM datos_biblioteca
    LIMIT 1;

    -- Solo si el préstamo fue devuelto y antes no lo estaba
    IF NEW.fecha_devolucion IS NOT NULL AND OLD.fecha_devolucion IS NULL THEN

        -- Verificar si hubo retraso
        IF NEW.fecha_devolucion > NEW.fecha_vencimiento THEN
            SET dias_retraso = DATEDIFF(NEW.fecha_devolucion, NEW.fecha_vencimiento);
            SET total_multa = dias_retraso * monto_por_dia;

            -- Insertar la multa
            INSERT INTO multas (socio_id, monto, fecha_alta)
            VALUES (
                NEW.socio_id,
                total_multa,
                NOW()
            );
        END IF;

    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL,
  `taller_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `alcance` enum('foro','libreta','recurso','privado') NOT NULL DEFAULT 'foro',
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `titulo` text NOT NULL,
  `cuerpo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `taller_id`, `usuario_id`, `alcance`, `fecha_publicacion`, `titulo`, `cuerpo`) VALUES
(1, 1, 14, 'foro', '2025-11-13 20:59:32', 'Nueva asignación', '<p>Un ejercicio que no es un ejercicio. </p>'),
(2, 1, 14, 'foro', '2025-11-13 20:59:43', 'Nueva asignación', '<p>Un ejercicio que no es un ejercicio. </p>'),
(12, 30, 15, 'foro', '2025-11-16 23:29:09', 'Primeras Lecturas!', '<p><span style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">Para empezar el taller les recomiendo las siguientes lecturas: </span></p><p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">\"Yo, Robot\"</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\"> de Isaac Asimov</span></p><p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">\"La guerra de los mundos\"</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\"> de H.G. Wells</span></p><p><br></p>'),
(13, 30, 13, 'foro', '2025-11-16 23:29:49', 'Leí \'La guerra de los mundos\'', '<p><span style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">\'La guerra de los mundos\' me dejó sin aliento. La descripción de la invasión marciana es aterradora incluso ahora, más de un siglo después. Wells logró crear una atmósfera de pánico y desesperación increíble. El final es perfecto, una lección de humildad cósmica.</span></p>'),
(14, 30, 12, 'foro', '2025-11-16 23:31:36', 'Mi opinión sobre \'Yo, Robot\'', '<p><span style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">Acabo de terminar \'Yo, Robot\' y me fascinó cómo Asimov anticipó tantos dilemas éticos sobre la inteligencia artificial. Las tres leyes de la robótica son brillantes, y cada cuento te hace pensar sobre lo que significa ser humano. Un clásico que sigue siendo relevante hoy.</span></p><p><br></p>'),
(15, 30, 15, 'foro', '2025-11-16 23:32:49', 'Actividad: La Primera Línea', '<p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">Instrucciones:</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\"> Escribe la primera oración de un cuento de ciencia ficción. Debe presentar algo extraño, futurista o imposible como si fuera completamente normal </span></p><p><em style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">Ejemplo</em><span style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">: </span><em style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">Mamá siempre decía que no debía hablar con mis clones, pero el de los martes era el único que entendía mis chistes</em><span style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">. </span></p><p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\">Consejo:</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(39, 39, 39);\"> Piensa en combinar algo cotidiano (ir al trabajo, una cena familiar, una discusión de pareja) con un elemento de ciencia ficción (robots, viajes espaciales, tecnología extraña). La clave es el contraste.</span></p>'),
(16, 30, 15, 'recurso', '2025-11-16 23:38:13', 'Actividades para la primera semana.', '<p><br></p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones_archivo`
--

CREATE TABLE `publicaciones_archivo` (
  `archivo_id` int(11) NOT NULL,
  `publicacion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones_archivo`
--

INSERT INTO `publicaciones_archivo` (`archivo_id`, `publicacion_id`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(137, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_usuarios`
--

CREATE TABLE `roles_usuarios` (
  `id` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles_usuarios`
--

INSERT INTO `roles_usuarios` (`id`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Profesor'),
(3, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE `socios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT 1,
  `telefono` varchar(60) NOT NULL,
  `dni` varchar(60) NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1,
  `fecha_nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `socios`
--

INSERT INTO `socios` (`id`, `usuario_id`, `telefono`, `dni`, `fecha_alta`, `activo`, `fecha_nacimiento`) VALUES
(4, 7, '1155556666', '35666777', '2025-11-13 03:00:00', 1, '1988-07-25'),
(5, 9, '1177778888', '42999000', '2025-11-13 03:00:00', 1, '1999-12-10'),
(6, 10, '1100001111', '38111222', '2025-11-13 03:00:00', 1, '1992-09-05'),
(7, 13, '1122334455', '22456789', '2025-11-13 20:41:05', 1, '2003-12-20'),
(8, 12, '1122334567', '11232456', '2025-11-14 05:28:08', 1, '2003-08-28'),
(9, 17, '1122334545', '11333555', '2025-11-17 00:00:13', 1, '1990-08-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres`
--

CREATE TABLE `talleres` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `ref_portada` varchar(100) DEFAULT NULL,
  `horario` varchar(100) DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `cupo` int(11) DEFAULT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talleres`
--

INSERT INTO `talleres` (`id`, `nombre`, `descripcion`, `ref_portada`, `horario`, `lugar`, `activo`, `cupo`, `fecha_alta`) VALUES
(1, 'Club de Lectura Clásica', 'Análisis de obras fundamentales de la literatura.', NULL, 'Lunes 18:00 - 19:30', 'Sala Principal', 1, NULL, '2025-11-13 20:25:42'),
(30, 'Escribir Ciencia Ficción', 'Análisis de cuentos clásicos, autores y prácticas para armar tu propia historia.', '135', '18:30 a 19:30', 'Sala Roja', 1, 0, '2025-11-16 22:45:00'),
(31, 'Dibujo de Historietas', 'Armado de comics, diálogos y personajes.', '136', '17:00', 'Sala Azul', 1, 0, '2025-11-16 22:49:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres_profesores`
--

CREATE TABLE `talleres_profesores` (
  `taller_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talleres_profesores`
--

INSERT INTO `talleres_profesores` (`taller_id`, `usuario_id`) VALUES
(1, 8),
(30, 15),
(31, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres_usuarios`
--

CREATE TABLE `talleres_usuarios` (
  `taller_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 0,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talleres_usuarios`
--

INSERT INTO `talleres_usuarios` (`taller_id`, `usuario_id`, `activo`, `fecha_inscripcion`) VALUES
(1, 12, 1, '2025-11-14 01:57:24'),
(1, 13, 1, '2025-11-13 20:58:11'),
(30, 12, 1, '2025-11-16 23:20:05'),
(30, 13, 1, '2025-11-16 23:20:53'),
(30, 16, 1, '2025-11-16 23:21:54'),
(30, 18, 0, '2025-11-16 23:21:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_recuperacion`
--

CREATE TABLE `tokens_recuperacion` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `expiracion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) DEFAULT 3,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `clave` char(255) NOT NULL,
  `img_perfil` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `rol_id`, `nombre`, `apellido`, `mail`, `clave`, `img_perfil`) VALUES
(5, 2, 'Pedro', 'Sánchez', 'pedro.sanchez@kobun.com', 'hash_profesor_seguro_123', NULL),
(7, 1, 'Miguel', 'Ruiz', 'miguel.ruiz@mail.com', 'hash_socio_4_seguro_123', NULL),
(8, 2, 'Elena', 'Vargas', 'elena.vargas@kobun.com', 'hash_profesor_2_seguro_123', NULL),
(9, 3, 'Jorge', 'Castro', 'jorge.castro@mail.com', 'hash_socio_5_seguro_123', NULL),
(10, 3, 'Sofia', 'Mora', 'sofia.mora@mail.com', 'hash_socio_6_seguro_123', NULL),
(11, 1, 'Pilar', 'Alvarez', 'pilar@kobun.com', '$2y$10$3sh7Di.OFSCQBAAXfP1FXONYKXp7HClGL05xeQJSofBROLmMMOzNe', 'almacenamiento/perfiles/691a5a16dc54a-perfil-admin.webp'),
(12, 3, 'Demian', 'Diaz', 'demian@kobun.com', '$2y$10$hc.BlTg41QJTS6mFjO0DCO7a2MrKMFzFDB18q1GZhG6n5csvZ9CiO', 'almacenamiento/perfiles/691a59d35e508-perfil-demian.webp'),
(13, 3, 'Roma', 'Ruiz', 'roma@kobun.com', '$2y$10$uj607ILymwTYz2isxXzzw.lhqqUJiwrc6ZKOhMYx3r5m./rEXeL2i', 'almacenamiento/perfiles/691a59e20e36a-perfil-roma.jpg'),
(14, 2, 'Samir', 'Sietecase', 'samir@kobun.com', '$2y$10$kMoBszsIDIQvU0MhmUdgDe2YMyVxIIRcLIwaw1sB/EgicyK4SiJX2', 'almacenamiento/perfiles/691a59ff1b8ca-perfil-profe-salinas.webp'),
(15, 2, 'Maitena', 'Mendez', 'maitena@kobun.com', '$2y$10$YapG.eVRQMcnIzmPi83NI.a91vlCmkld6Ls7rDq2I6i6UUF8uwJbW', 'almacenamiento/perfiles/691a59b78c1a1-perfil-profe.jpg'),
(16, 3, 'Antonio', 'Araoz', 'antonio@kobun.com', '$2y$10$WNl6pmDMz.SvDJSGHUw1uePicEx.wae5oD08arMTezNFMczA9ExDG', NULL),
(17, 3, 'Esteban', 'Romero', 'esteban@kobun.com', '$2y$10$v6rMLG.E19oVtqcMREI6IeM6mJXya/.IYTD7JMdbguHRhTtx/Z.le', 'almacenamiento/perfiles/691a5b2cbfa7b-6916044dd0e18-156a9e60a209f6df3d6f07bae709f301.jpg'),
(18, 3, 'Liliana', 'Olmedo', 'liliana@kobun.com', '$2y$10$rIP1yccsL1AU6Xe.2WHUzOpsb7ziuA26Ffba4aa4QWnOrc5T/7hNK', 'almacenamiento/perfiles/691a5b8e549fb-6917377a15ef3-de5e6cdc798fd78f7597adc3594d0057.jpg'),
(19, 1, 'Felipe', 'Da Rosa', 'felipe@kobun.com', '$2y$10$WmO2LzVsGG7bo9fXghgMsuF/DR8GTXmSdoGVmw7vntgq0ZPENWuOK', 'almacenamiento/perfiles/691b15490dee1-perfil-felipe.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `libro_id` (`libro_id`);

--
-- Indices de la tabla `generos`
--
ALTER TABLE `generos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indices de la tabla `libros_autores`
--
ALTER TABLE `libros_autores`
  ADD PRIMARY KEY (`libro_id`,`autor_id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Indices de la tabla `libros_editoriales`
--
ALTER TABLE `libros_editoriales`
  ADD PRIMARY KEY (`libro_id`,`editorial_id`),
  ADD KEY `editorial_id` (`editorial_id`);

--
-- Indices de la tabla `libros_generos`
--
ALTER TABLE `libros_generos`
  ADD PRIMARY KEY (`libro_id`,`genero_id`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Indices de la tabla `multas`
--
ALTER TABLE `multas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `socio_id` (`socio_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `socio_id` (`socio_id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `socio_id` (`socio_id`),
  ADD KEY `ejemplar_id` (`ejemplar_id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taller_id` (`taller_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `publicaciones_archivo`
--
ALTER TABLE `publicaciones_archivo`
  ADD PRIMARY KEY (`archivo_id`,`publicacion_id`),
  ADD KEY `publicacion_id` (`publicacion_id`);

--
-- Indices de la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `talleres`
--
ALTER TABLE `talleres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nombre` (`nombre`);

--
-- Indices de la tabla `talleres_profesores`
--
ALTER TABLE `talleres_profesores`
  ADD PRIMARY KEY (`taller_id`,`usuario_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `talleres_usuarios`
--
ALTER TABLE `talleres_usuarios`
  ADD PRIMARY KEY (`taller_id`,`usuario_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `tokens_recuperacion`
--
ALTER TABLE `tokens_recuperacion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `multas`
--
ALTER TABLE `multas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `talleres`
--
ALTER TABLE `talleres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `tokens_recuperacion`
--
ALTER TABLE `tokens_recuperacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  ADD CONSTRAINT `ejemplares_ibfk_1` FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `libros_autores`
--
ALTER TABLE `libros_autores`
  ADD CONSTRAINT `libros_autores_ibfk_1` FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `libros_autores_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `autores` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `libros_editoriales`
--
ALTER TABLE `libros_editoriales`
  ADD CONSTRAINT `libros_editoriales_ibfk_1` FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`),
  ADD CONSTRAINT `libros_editoriales_ibfk_2` FOREIGN KEY (`editorial_id`) REFERENCES `editoriales` (`id`);

--
-- Filtros para la tabla `libros_generos`
--
ALTER TABLE `libros_generos`
  ADD CONSTRAINT `libros_generos_ibfk_1` FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `libros_generos_ibfk_2` FOREIGN KEY (`genero_id`) REFERENCES `generos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `multas`
--
ALTER TABLE `multas`
  ADD CONSTRAINT `multas_ibfk_1` FOREIGN KEY (`socio_id`) REFERENCES `socios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`socio_id`) REFERENCES `socios` (`id`);

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`socio_id`) REFERENCES `socios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`ejemplar_id`) REFERENCES `ejemplares` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`taller_id`) REFERENCES `talleres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publicaciones_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `publicaciones_archivo`
--
ALTER TABLE `publicaciones_archivo`
  ADD CONSTRAINT `publicaciones_archivo_ibfk_1` FOREIGN KEY (`archivo_id`) REFERENCES `archivos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `publicaciones_archivo_ibfk_2` FOREIGN KEY (`publicacion_id`) REFERENCES `publicaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `socios`
--
ALTER TABLE `socios`
  ADD CONSTRAINT `socios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `talleres_profesores`
--
ALTER TABLE `talleres_profesores`
  ADD CONSTRAINT `talleres_profesores_ibfk_1` FOREIGN KEY (`taller_id`) REFERENCES `talleres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `talleres_profesores_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `talleres_usuarios`
--
ALTER TABLE `talleres_usuarios`
  ADD CONSTRAINT `talleres_usuarios_ibfk_1` FOREIGN KEY (`taller_id`) REFERENCES `talleres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `talleres_usuarios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tokens_recuperacion`
--
ALTER TABLE `tokens_recuperacion`
  ADD CONSTRAINT `tokens_recuperacion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles_usuarios` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
