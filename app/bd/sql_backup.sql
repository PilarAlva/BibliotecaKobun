-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2025 a las 13:12:32
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
(1, '../almacenamiento/subidos/20251104141410_20251103215639_20251102012256_20251025_185829.jpg.jpg.jpg', '20251103215639_20251102012256_20251025_185829.jpg.jpg'),
(2, '../almacenamiento/subidos/20251104145754_20251102012256_20251025_185829 (1).jpg.jpg', '20251102012256_20251025_185829 (1).jpg'),
(3, '../almacenamiento/subidos/20251104153748_sss.png.png', 'sss.png'),
(4, '../almacenamiento/subidos/20251104153748_Ilustración_sin_título.jpg.jpg', 'Ilustración_sin_título.jpg'),
(5, '../almacenamiento/subidos/20251104174159_1000169292.jpg.jpg', '1000169292.jpg'),
(6, '../almacenamiento/subidos/20251104174201_20251019_094452.jpg.jpg', '20251019_094452.jpg'),
(7, '../almacenamiento/subidos/20251104175435_20251104_101049.jpg.jpg', '20251104_101049.jpg'),
(8, '../almacenamiento/subidos/20251104175435_20251104_101718.jpg.jpg', '20251104_101718.jpg'),
(9, '../almacenamiento/subidos/20251104175927_20250828_163856.jpg.jpg', '20250828_163856.jpg'),
(10, '../almacenamiento/subidos/20251104175928_20250828_163856.jpg.jpg', '20250828_163856.jpg'),
(12, '../almacenamiento/subidos/20251105023746_20251103220355_td-s1-img01.jpg.jpg.jpg', '20251103220355_td-s1-img01.jpg.jpg'),
(13, '../almacenamiento/subidos/20251105214526_20251103221214_20251102012127_~$eguntas - Entrevistas (4) (1).docx.docx.docx', '20251103221214_20251102012127_~$eguntas - Entrevistas (4) (1).docx.docx');

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
(1, 'Gabriel', 'García Márquez', '1927-03-06', '2014-04-17'),
(2, 'Jane', 'Austen', '1775-12-16', '1817-07-18'),
(3, 'George', 'Orwell', '1903-06-25', '1950-01-21'),
(4, 'J.R.R.', 'Tolkien', '1892-01-03', '1973-09-02'),
(5, 'Agatha', 'Christie', '1890-09-15', '1976-01-12'),
(6, 'Isabel', 'Allende', '1942-08-02', NULL),
(7, 'Stephen', 'King', '1947-09-21', NULL),
(8, 'Carl', 'Sagan', '1934-11-09', '1996-12-20'),
(9, 'Neil', 'Gaiman', '1960-11-10', NULL),
(10, 'Terry', 'Pratchett', '1948-04-28', '2015-03-12');

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
(1, 'Felipe Da Rosa', 'fprofesor@mail.com', '12123123123123', 'Otro mail mas solo para prbar mi BD', '2025-11-05');

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
('contacto@kobun-db.com', 0.50, 25.00, 5, 10);

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
(4, 'Alianza Editorial'),
(6, 'Anagrama'),
(7, 'Debolsillo'),
(1, 'Editorial Planeta'),
(3, 'HarperCollins'),
(5, 'Minotauro'),
(2, 'Penguin Random House');

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
(1, 1, 'FIC-GM-C1'),
(2, 1, 'FIC-GM-C2'),
(3, 1, 'FIC-GM-C3'),
(4, 1, 'FIC-GM-C4'),
(5, 1, 'FIC-GM-C5'),
(6, 2, 'SCF-GO-D1'),
(7, 2, 'SCF-GO-D2'),
(8, 2, 'SCF-GO-D3'),
(9, 2, 'SCF-GO-D4'),
(10, 10, 'SCF-GO-D-LUJO1'),
(11, 10, 'SCF-GO-D-LUJO2'),
(12, 10, 'SCF-GO-D-LUJO3'),
(13, 3, 'FAN-JT-E1'),
(14, 3, 'FAN-JT-E2'),
(15, 3, 'FAN-JT-E3'),
(16, 3, 'FAN-JT-E4'),
(17, 3, 'FAN-JT-E5'),
(18, 3, 'FAN-JT-E6'),
(19, 4, 'MIS-AC-F1'),
(20, 4, 'MIS-AC-F2'),
(21, 5, 'MAG-IA-G1'),
(22, 5, 'MAG-IA-G2'),
(23, 5, 'MAG-IA-G3'),
(24, 6, 'NON-CS-H1'),
(25, 6, 'NON-CS-H2'),
(26, 7, 'FAN-GP-I1'),
(27, 7, 'FAN-GP-I2'),
(28, 7, 'FAN-GP-I3'),
(29, 8, 'TRR-SK-J1'),
(30, 8, 'TRR-SK-J2'),
(31, 9, 'ROM-JA-K1'),
(32, 9, 'ROM-JA-K2'),
(33, 9, 'ROM-JA-K3');

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
(10, 'Aventura'),
(9, 'Biografía'),
(3, 'Ciencia Ficción'),
(12, 'Ensayo'),
(2, 'Fantasía'),
(1, 'Ficción'),
(8, 'Historia'),
(14, 'Infantil'),
(4, 'Misterio'),
(7, 'No Ficción'),
(11, 'Poesía'),
(6, 'Romance'),
(13, 'Terror'),
(5, 'Thriller');

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
  `fecha_alta` date DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `isbn`, `titulo`, `sinopsis`, `ref_portada`, `fecha_alta`, `activo`, `descripcion`) VALUES
(1, '9788497592208', 'Cien años de soledad', 'La epopeya de la familia Buendía en Macondo.', '/portadas/cien_anios.jpg', '2025-11-04', 1, 'Realismo mágico.'),
(2, '9788499086111', '1984', 'Vigilancia totalitaria.', '/portadas/1984.jpg', '2025-11-04', 1, 'Distopía clásica.'),
(3, '9788445071477', 'El Señor de los Anillos', 'La aventura para destruir el Anillo.', '/portadas/esdla.jpg', '2025-11-04', 1, 'Fantasía épica.'),
(4, '9788423351984', 'Asesinato en el Orient Express', 'Misterio a bordo de un tren.', '/portadas/asesinato.jpg', '2025-11-04', 1, 'Misterio clásico.'),
(5, '9789561005709', 'La casa de los espíritus', 'Saga familiar con eventos sobrenaturales.', '/portadas/espiritus.jpg', '2025-11-04', 1, 'Realismo mágico y drama.'),
(6, '9788499083321', 'Cosmos', 'Un viaje a través del universo y la ciencia.', '/portadas/cosmos.jpg', '2025-11-04', 1, 'Ciencia y divulgación.'),
(7, '9788498380295', 'Buenos presagios', 'Un ángel y un demonio se unen para evitar el Apocalipsis.', '/portadas/presagios.jpg', '2025-11-04', 1, 'Fantasía cómica.'),
(8, '9788499087507', 'IT', 'Un grupo de niños enfrenta a un ente maligno.', '/portadas/it.jpg', '2025-11-04', 1, 'Terror sobrenatural.'),
(9, '9788420485361', 'Orgullo y Prejuicio', 'Crítica social y romance.', '/portadas/orgullo.jpg', '2025-11-04', 1, 'Clásico romántico.'),
(10, '9788499086112', '1984 - Edición Lujo', 'Vigilancia totalitaria. Mismo contenido, diferente editorial.', '/portadas/1984_lujo.jpg', '2025-11-04', 1, 'Distopía clásica - Edición especial.');

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
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 8),
(7, 9),
(7, 10),
(8, 7),
(9, 2),
(10, 3);

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
(1, 2),
(2, 4),
(3, 5),
(4, 1),
(5, 2),
(6, 4),
(7, 3),
(8, 1),
(9, 7),
(10, 7);

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
(1, 1),
(1, 4),
(2, 1),
(2, 3),
(3, 2),
(3, 10),
(4, 4),
(4, 5),
(5, 2),
(5, 6),
(6, 3),
(6, 7),
(7, 2),
(7, 5),
(8, 5),
(8, 13),
(9, 1),
(9, 6),
(10, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `socio_id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `medio` enum('efectivo','transferencia') DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `socio_id`, `monto`, `medio`, `fecha`) VALUES
(1, 1, 25.00, 'transferencia', '2025-10-02 13:07:03'),
(2, 2, 25.00, 'efectivo', '2025-11-04 13:07:03'),
(3, 3, 5.00, 'efectivo', '2025-11-04 13:07:03');

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
(1, 1, 1, '2025-11-04 13:07:03', '2025-11-18', NULL),
(2, 2, 6, '2025-10-05 13:07:03', '2025-10-19', '2025-10-18'),
(3, 3, 11, '2025-10-15 13:07:03', '2025-10-29', NULL),
(4, 2, 6, '2025-09-05 13:07:03', '2025-09-19', '2025-09-15'),
(5, 4, 15, '2025-09-25 13:07:03', '2025-10-09', '2025-10-07'),
(6, 5, 26, '2025-07-27 13:07:03', '2025-08-10', '2025-08-08'),
(7, 1, 3, '2025-10-05 13:07:03', '2025-10-19', '2025-10-24'),
(8, 6, 30, '2025-09-15 13:07:03', '2025-09-29', '2025-10-09'),
(9, 3, 33, '2025-10-30 13:07:03', '2025-11-13', NULL),
(10, 2, 28, '2025-10-25 13:07:03', '2025-11-08', NULL),
(11, 1, 18, '2025-11-03 13:07:03', '2025-11-17', NULL),
(12, 4, 21, '2025-10-14 13:07:03', '2025-10-28', NULL),
(13, 5, 12, '2025-09-21 13:07:03', '2025-10-05', NULL),
(14, 6, 6, '2025-11-05 03:00:00', '2025-11-20', NULL),
(15, 6, 7, '2025-11-05 03:00:00', '2025-11-20', NULL),
(16, 6, 8, '2025-11-05 03:00:00', '2025-11-20', NULL),
(17, 6, 2, '2025-11-05 03:00:00', '2025-11-20', NULL),
(18, 6, 9, '2025-11-05 03:00:00', '2025-11-20', NULL),
(19, 6, 10, '2025-11-05 03:00:00', '2025-11-20', NULL);

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
(17, 1, 12, 'foro', '2025-11-04 16:39:57', 'Esto es genial! ', '<p>Wow! Qué página tan interactiva y divertida! </p>'),
(19, 1, 12, 'foro', '2025-11-04 16:42:01', 'Archivo ', '<p><br></p>'),
(21, 1, 15, 'foro', '2025-11-04 16:52:09', 'Hola a todos, soy la mamá de felipe😊', '<p><br></p>'),
(22, 1, 15, 'foro', '2025-11-04 16:54:41', 'Escolarte Flora 2025', '<p><span class=\"ql-cursor\">﻿</span></p>'),
(23, 1, 17, 'foro', '2025-11-04 16:59:30', '', '<p><br></p>'),
(24, 1, 17, 'foro', '2025-11-04 16:59:31', '', '<p><br></p>'),
(26, 1, 11, 'foro', '2025-11-04 22:56:41', 'Algo 2', '<p><br></p>'),
(27, 1, 11, 'foro', '2025-11-04 23:20:16', 'Titulo            ', '<p>Este cuerpo también está editado</p>'),
(30, 1, 11, 'foro', '2025-11-05 01:37:47', 'Algo', '<p>asdas</p>'),
(32, 1, 18, 'foro', '2025-11-05 11:00:02', 'Por qué puedo anotarme de prepo??', '<p>Hay dios mio</p>'),
(34, 1, 11, 'foro', '2025-11-05 16:09:13', 'Algo', '<p><br></p>'),
(35, 1, 11, 'foro', '2025-11-05 20:45:27', '', '<p><br></p>');

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
(5, 19),
(8, 22),
(9, 23),
(10, 24),
(12, 30),
(13, 35);

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
(1, 3, '1123456789', '30123456', '2025-11-04 03:00:00', 1, '1990-05-15'),
(2, 4, '1198765432', '40654321', '2025-11-04 03:00:00', 1, '1985-11-20'),
(3, 6, '1133334444', '41222333', '2025-11-04 03:00:00', 1, '1995-03-01'),
(4, 7, '1155556666', '35666777', '2025-11-04 03:00:00', 1, '1988-07-25'),
(5, 9, '1177778888', '42999000', '2025-11-04 03:00:00', 1, '1999-12-10'),
(6, 11, '1100001111', '38111222', '2025-11-04 03:00:00', 1, '1992-09-05');

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
(1, 'Club de Lectura Clásica', 'Análisis de obras fundamentales de la literatura.', NULL, 'Lunes 18:00 - 19:30', 'Sala Principal', 1, NULL, '2025-11-04 13:07:03'),
(2, 'Introducción a la Programación', 'Taller básico de Python para principiantes.', NULL, 'Miércoles 10:00 - 12:00', 'Aula Multimedia', 1, NULL, '2025-11-04 13:07:03'),
(3, 'Escribir Ciencia Ficción', 'Técnicas narrativas para el género.', NULL, 'Martes 19:00 - 21:00', 'Sala de Reuniones', 1, NULL, '2025-11-04 13:07:03');

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
(1, 5),
(1, 18),
(2, 8),
(3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres_usuarios`
--

CREATE TABLE `talleres_usuarios` (
  `taller_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `activo` tinyint(4) DEFAULT 0,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talleres_usuarios`
--

INSERT INTO `talleres_usuarios` (`taller_id`, `usuario_id`, `activo`, `fecha_inscripcion`) VALUES
(1, 3, 0, '2025-11-04 13:07:03'),
(1, 4, 0, '2025-11-04 13:07:03'),
(1, 11, 1, '2025-11-05 12:44:16'),
(1, 15, 1, '2025-11-04 16:51:43'),
(1, 17, 1, '2025-11-04 16:56:36'),
(1, 18, 0, '2025-11-05 13:36:43'),
(2, 6, 0, '2025-11-04 13:07:03'),
(2, 7, 0, '2025-11-04 13:07:03'),
(2, 11, 0, '2025-11-05 20:37:23'),
(3, 9, 0, '2025-11-04 13:07:03'),
(3, 10, 0, '2025-11-04 13:07:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
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
(2, 1, 'Maria', 'Gómez', 'maria.gomez@kobun.com', 'hash_bibliotecario_seguro_123', NULL),
(3, 1, 'Carlos', 'López', 'carlos.lopez@mail.com', 'hash_socio_1_seguro_123', NULL),
(4, 1, 'Ana', 'Martínez', 'ana.martinez@mail.com', 'hash_socio_2_seguro_123', NULL),
(5, 1, 'Pedro', 'Sánchez', 'pedro.sanchez@kobun.com', 'hash_profesor_seguro_123', NULL),
(6, 1, 'Laura', 'Díaz', 'laura.diaz@mail.com', 'hash_socio_3_seguro_123', NULL),
(7, 1, 'Miguel', 'Ruiz', 'miguel.ruiz@mail.com', 'hash_socio_4_seguro_123', NULL),
(8, 1, 'Elena', 'Vargas', 'elena.vargas@kobun.com', 'hash_profesor_2_seguro_123', NULL),
(9, 1, 'Jorge', 'Castro', 'jorge.castro@mail.com', 'hash_socio_5_seguro_123', NULL),
(10, 1, 'Sofia', 'Mora', 'sofia.mora@mail.com', 'hash_socio_6_seguro_123', NULL),
(11, 3, 'Felipe', 'Da Rosa', 'fdarosa@mail.com', '$2y$10$XVXPkH9lggXDESmHA.X7Fef.k1v/IcOzwLtP2pCgwJnUvd6thUsPG', NULL),
(12, 3, 'Federico', 'Da Rosa Orcorchuk', 'fede@gmail.com', '$2y$10$WdlL5gsqw018Gbz1dylXoOJ0QpI9Sd8i67W6nfVp0A6IFBqhiYy6e', NULL),
(13, 3, 'Faustina', 'Da Rosa Orcorchuk', 'faustinadarosaorcorchuk@gmail.com', '$2y$10$.4hcM5BdMAZj1.6uzlSxmOC3NBfp2aHdMZUPQPUcmXrkDIvWjSmIW', NULL),
(14, 3, 'Mariana', 'Orcorchuk', 'marianaorcorchuk@yahoo.com.ar', '$2y$10$4XjL0KJ/Vxw3jv00bPusn.96iSSoveJ6zkC.VnNcIcV7zWi4J9.Ha', NULL),
(15, 3, 'Mariana', 'Orcorchuk', 'mariana@gmail.com', '$2y$10$MV0X8CZjckNUBL6I4sbCGuTJb4jjrvrgJpVRTsh.jye/4w29Lh4M6', NULL),
(16, 3, 'Caquita marron', '. Com', 'floradarosa66@gmail.com', '$2y$10$8l21XPg2bcB7gA0HYI8wxuQrwtK2aG0wWW14WIt9Guh9V..PdpYMG', NULL),
(17, 3, 'Flora', 'Da Rosa', 'flora@gmail.com', '$2y$10$VxgraPRACPnL/dX8OoZwauY/Z01.pmJKoAdqvBLqe37Fa0VsekEh2', NULL),
(18, 2, 'Felipe', 'Da Rosa', 'fprofesor@mail.com', '$2y$10$CjhElC6aTw9NNhcmF1v6Cud/Gv38tpTW.fGiPe6my1fl8WUyXG8si', NULL),
(19, 1, 'Felipe-Admin', 'Da Rosa', 'fadmin@mail.com', '$2y$10$cTozydD4d.i4dtpyOPW4.e6kYgQ9QT6jeLdWiIFznesGGCIgHGmy.', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `generos`
--
ALTER TABLE `generos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `roles_usuarios`
--
ALTER TABLE `roles_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `talleres`
--
ALTER TABLE `talleres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles_usuarios` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
