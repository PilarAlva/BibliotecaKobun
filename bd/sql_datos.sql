-- #######################################################################
-- # PASO 1: LIMPIEZA Y TRUNCADO DE TABLAS
-- # Asegura que la base de datos esté vacía y lista para los datos de prueba
-- #######################################################################

-- Deshabilitar la revisión de claves foráneas temporalmente para permitir el TRUNCATE
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Truncar Tablas de Gestión (dependen de muchas otras)
TRUNCATE TABLE Prestamos;
TRUNCATE TABLE Pagos;
TRUNCATE TABLE Publicaciones_Archivo;
TRUNCATE TABLE Publicaciones;
TRUNCATE TABLE Archivos;

-- 2. Truncar Tablas de Relaciones N:M
TRUNCATE TABLE Libros_Autores;
TRUNCATE TABLE Libros_Editoriales;
TRUNCATE TABLE Libros_Generos;
TRUNCATE TABLE Talleres_Usuarios;
TRUNCATE TABLE Talleres_Profesores;

-- 3. Truncar Tablas Principales con FKs salientes
TRUNCATE TABLE Ejemplares;
TRUNCATE TABLE Socios;
TRUNCATE TABLE Talleres;

-- 4. Truncar Tablas de Catálogo y Usuarios
TRUNCATE TABLE Libros;
TRUNCATE TABLE Autores;
TRUNCATE TABLE Editoriales;
TRUNCATE TABLE Generos;
TRUNCATE TABLE Usuarios;
TRUNCATE TABLE Roles_Usuarios;

-- 5. Truncar Tablas de Configuración (no tienen FKs entrantes)
TRUNCATE TABLE Datos_Biblioteca;

-- Habilitar la revisión de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;

-- #######################################################################
-- # PASO 2: INSERCIÓN DE DATOS AMPLIADOS DE PRUEBA
-- #######################################################################

-- ***********************************
-- 1. Tablas Maestras
-- ***********************************

-- Datos_Biblioteca
INSERT INTO Datos_Biblioteca (mail, multa, cuota_socio, limite_prestamos_nuevos, limite_prestamos) VALUES
('contacto@kobun-db.com', 0.50, 25.00, 5, 10);

-- Roles_Usuarios
INSERT INTO Roles_Usuarios (tipo) VALUES
('Administrador'), ('Bibliotecario'), ('Socio'), ('Profesor');

-- Géneros (Ampliados)
INSERT INTO Generos (nombre) VALUES
('Ficción'), ('Fantasía'), ('Ciencia Ficción'), ('Misterio'),
('Thriller'), ('Romance'), ('No Ficción'), ('Historia'),
('Biografía'), ('Aventura'), ('Poesía'), ('Ensayo'),
('Terror'), ('Infantil');

-- Autores (Ampliados - 10 autores)
INSERT INTO Autores (nombre, apellido, fecha_nacimiento, fecha_muerte) VALUES
('Gabriel', 'García Márquez', '1927-03-06', '2014-04-17'), -- 1
('Jane', 'Austen', '1775-12-16', '1817-07-18'), -- 2
('George', 'Orwell', '1903-06-25', '1950-01-21'), -- 3
('J.R.R.', 'Tolkien', '1892-01-03', '1973-09-02'), -- 4
('Agatha', 'Christie', '1890-09-15', '1976-01-12'), -- 5
('Isabel', 'Allende', '1942-08-02', NULL), -- 6
('Stephen', 'King', '1947-09-21', NULL), -- 7
('Carl', 'Sagan', '1934-11-09', '1996-12-20'), -- 8
('Neil', 'Gaiman', '1960-11-10', NULL), -- 9
('Terry', 'Pratchett', '1948-04-28', '2015-03-12'); -- 10

-- Editoriales (Ampliadas - 7 editoriales)
INSERT INTO Editoriales (nombre) VALUES
('Editorial Planeta'), -- 1
('Penguin Random House'), -- 2
('HarperCollins'), -- 3
('Alianza Editorial'), -- 4
('Minotauro'), -- 5
('Anagrama'), -- 6
('Debolsillo'); -- 7

-- ***********************************
-- 2. Usuarios, Socios y Talleres
-- ***********************************

-- Usuarios (5 usuarios iniciales + 5 nuevos para talleres)
INSERT INTO Usuarios (rol_id, nombre, apellido, mail, password) VALUES
(1, 'Juan', 'Pérez', 'juan.perez@kobun.com', 'hash_admin_seguro_123'), -- 1 (Admin)
(2, 'Maria', 'Gómez', 'maria.gomez@kobun.com', 'hash_bibliotecario_seguro_123'), -- 2 (Bibliotecario)
(3, 'Carlos', 'López', 'carlos.lopez@mail.com', 'hash_socio_1_seguro_123'), -- 3 (Socio 1)
(3, 'Ana', 'Martínez', 'ana.martinez@mail.com', 'hash_socio_2_seguro_123'), -- 4 (Socio 2)
(4, 'Pedro', 'Sánchez', 'pedro.sanchez@kobun.com', 'hash_profesor_seguro_123'), -- 5 (Profesor 1)
(3, 'Laura', 'Díaz', 'laura.diaz@mail.com', 'hash_socio_3_seguro_123'), -- 6 (Socio 3)
(3, 'Miguel', 'Ruiz', 'miguel.ruiz@mail.com', 'hash_socio_4_seguro_123'), -- 7 (Socio 4)
(4, 'Elena', 'Vargas', 'elena.vargas@kobun.com', 'hash_profesor_2_seguro_123'), -- 8 (Profesor 2)
(3, 'Jorge', 'Castro', 'jorge.castro@mail.com', 'hash_socio_5_seguro_123'), -- 9 (Socio 5)
(3, 'Sofia', 'Mora', 'sofia.mora@mail.com', 'hash_socio_6_seguro_123'); -- 10 (Socio 6)

-- Socios (usuario_id 3, 4, 6, 7, 9, 10)
INSERT INTO Socios (usuario_id, telefono, dni, fecha_alta, fecha_nacimiento) VALUES
(3, '1123456789', '30123456', CURDATE(), '1990-05-15'), -- 1. Carlos
(4, '1198765432', '40654321', CURDATE(), '1985-11-20'), -- 2. Ana
(6, '1133334444', '41222333', CURDATE(), '1995-03-01'), -- 3. Laura
(7, '1155556666', '35666777', CURDATE(), '1988-07-25'), -- 4. Miguel
(9, '1177778888', '42999000', CURDATE(), '1999-12-10'), -- 5. Jorge
(10, '1100001111', '38111222', CURDATE(), '1992-09-05'); -- 6. Sofia

-- Talleres
INSERT INTO Talleres (nombre, descripcion, horario, lugar) VALUES
('Club de Lectura Clásica', 'Análisis de obras fundamentales de la literatura.', 'Lunes 18:00 - 19:30', 'Sala Principal'), -- 1
('Introducción a la Programación', 'Taller básico de Python para principiantes.', 'Miércoles 10:00 - 12:00', 'Aula Multimedia'), -- 2
('Escribir Ciencia Ficción', 'Técnicas narrativas para el género.', 'Martes 19:00 - 21:00', 'Sala de Reuniones'); -- 3

-- Talleres_Profesores (Pedro=5, Elena=8)
INSERT INTO Talleres_Profesores (taller_id, usuario_id) VALUES
(1, 5), -- Club de Lectura por Pedro
(2, 8), -- Programación por Elena
(3, 5); -- Ciencia Ficción por Pedro

-- Talleres_Usuarios (Inscripción de Socios 3, 4, 6, 7, 9, 10)
INSERT INTO Talleres_Usuarios (taller_id, usuario_id) VALUES
(1, 3), (1, 4), -- Club de Lectura: Carlos, Ana
(2, 6), (2, 7), -- Programación: Laura, Miguel
(3, 9), (3, 10); -- Ciencia Ficción: Jorge, Sofia

-- ***********************************
-- 3. Libros y Relaciones (Más Complejidad)
-- ***********************************

-- Libros (10 libros únicos, algunos con mismo título pero diferente ISBN/Editorial)
INSERT INTO Libros (id, isbn, titulo, sinopsis, ref_portada, fecha_alta, descripcion) VALUES
(1, '9788497592208', 'Cien años de soledad', 'La epopeya de la familia Buendía en Macondo.', '/portadas/cien_anios.jpg', CURDATE(), 'Realismo mágico.'), -- García Márquez
(2, '9788499086111', '1984', 'Vigilancia totalitaria.', '/portadas/1984.jpg', CURDATE(), 'Distopía clásica.'), -- Orwell
(3, '9788445071477', 'El Señor de los Anillos', 'La aventura para destruir el Anillo.', '/portadas/esdla.jpg', CURDATE(), 'Fantasía épica.'), -- Tolkien
(4, '9788423351984', 'Asesinato en el Orient Express', 'Misterio a bordo de un tren.', '/portadas/asesinato.jpg', CURDATE(), 'Misterio clásico.'), -- Christie
(5, '9789561005709', 'La casa de los espíritus', 'Saga familiar con eventos sobrenaturales.', '/portadas/espiritus.jpg', CURDATE(), 'Realismo mágico y drama.'), -- Allende
(6, '9788499083321', 'Cosmos', 'Un viaje a través del universo y la ciencia.', '/portadas/cosmos.jpg', CURDATE(), 'Ciencia y divulgación.'), -- Carl Sagan
(7, '9788498380295', 'Buenos presagios', 'Un ángel y un demonio se unen para evitar el Apocalipsis.', '/portadas/presagios.jpg', CURDATE(), 'Fantasía cómica.'), -- Gaiman y Pratchett
(8, '9788499087507', 'IT', 'Un grupo de niños enfrenta a un ente maligno.', '/portadas/it.jpg', CURDATE(), 'Terror sobrenatural.'), -- Stephen King
(9, '9788420485361', 'Orgullo y Prejuicio', 'Crítica social y romance.', '/portadas/orgullo.jpg', CURDATE(), 'Clásico romántico.'), -- Jane Austen
(10, '9788499086112', '1984 - Edición Lujo', 'Vigilancia totalitaria. Mismo contenido, diferente editorial.', '/portadas/1984_lujo.jpg', CURDATE(), 'Distopía clásica - Edición especial.'); -- Orwell (mismo título, diferente ISBN/Editorial)

-- Libros_Autores (Relación N:M)
INSERT INTO Libros_Autores (libro_id, autor_id) VALUES
(1, 1), -- Cien años de soledad (García Márquez)
(2, 3), -- 1984 (Orwell)
(3, 4), -- ESDLA (Tolkien)
(4, 5), -- Asesinato... (Christie)
(5, 6), -- La casa de los espíritus (Allende)
(6, 8), -- Cosmos (Carl Sagan)
(7, 9), (7, 10), -- ¡Múltiples autores! Buenos presagios (Gaiman y Pratchett)
(8, 7), -- IT (Stephen King)
(9, 2), -- Orgullo y Prejuicio (Jane Austen)
(10, 3); -- 1984 Edición Lujo (Orwell)

-- Libros_Editoriales (Relación N:M)
INSERT INTO Libros_Editoriales (libro_id, editorial_id) VALUES
(1, 2), -- Cien años (Penguin)
(2, 4), -- 1984 (Alianza)
(3, 5), -- ESDLA (Minotauro)
(4, 1), -- Asesinato... (Planeta)
(5, 2), -- La casa... (Penguin)
(6, 4), -- Cosmos (Alianza)
(7, 3), -- Buenos presagios (HarperCollins)
(8, 1), -- IT (Planeta)
(9, 7), -- Orgullo y Prejuicio (Debolsillo)
(10, 7); -- ¡Mismo título, diferente editorial/ISBN! 1984 Lujo (Debolsillo)

-- Libros_Generos (Relación N:M - ¡Múltiples géneros!)
INSERT INTO Libros_Generos (libro_id, genero_id) VALUES
(1, 1), (1, 4), -- Cien años (Ficción, Misterio - por el elemento misterioso de la familia)
(2, 3), (2, 1), -- 1984 (Ciencia Ficción, Ficción)
(3, 2), (3, 10), -- ESDLA (Fantasía, Aventura)
(4, 4), (4, 5), -- Asesinato... (Misterio, Thriller)
(5, 2), (5, 6), -- La casa... (Fantasía, Romance)
(6, 7), (6, 3), -- Cosmos (No Ficción, Ciencia Ficción)
(7, 2), (7, 5), -- Buenos presagios (Fantasía, Thriller - comedia)
(8, 13), (8, 5), -- IT (Terror, Thriller)
(9, 6), (9, 1), -- Orgullo y Prejuicio (Romance, Ficción)
(10, 3); -- 1984 Lujo (Ciencia Ficción)

-- Ejemplares (35 ejemplares en total)
INSERT INTO Ejemplares (libro_id, codigo_topografico) VALUES
(1, 'FIC-GM-C1'), (1, 'FIC-GM-C2'), (1, 'FIC-GM-C3'), (1, 'FIC-GM-C4'), (1, 'FIC-GM-C5'), -- 5 ej. Cien Años
(2, 'SCF-GO-D1'), (2, 'SCF-GO-D2'), (2, 'SCF-GO-D3'), (2, 'SCF-GO-D4'), -- 4 ej. 1984 (Alianza)
(10, 'SCF-GO-D-LUJO1'), (10, 'SCF-GO-D-LUJO2'), (10, 'SCF-GO-D-LUJO3'), -- 3 ej. 1984 (Debolsillo)
(3, 'FAN-JT-E1'), (3, 'FAN-JT-E2'), (3, 'FAN-JT-E3'), (3, 'FAN-JT-E4'), (3, 'FAN-JT-E5'), (3, 'FAN-JT-E6'), -- 6 ej. ESDLA
(4, 'MIS-AC-F1'), (4, 'MIS-AC-F2'), -- 2 ej. Asesinato...
(5, 'MAG-IA-G1'), (5, 'MAG-IA-G2'), (5, 'MAG-IA-G3'), -- 3 ej. La Casa...
(6, 'NON-CS-H1'), (6, 'NON-CS-H2'), -- 2 ej. Cosmos
(7, 'FAN-GP-I1'), (7, 'FAN-GP-I2'), (7, 'FAN-GP-I3'), -- 3 ej. Buenos Presagios
(8, 'TRR-SK-J1'), (8, 'TRR-SK-J2'), -- 2 ej. IT
(9, 'ROM-JA-K1'), (9, 'ROM-JA-K2'), (9, 'ROM-JA-K3'); -- 3 ej. Orgullo...

-- ***********************************
-- 4. Gestión (Préstamos y Pagos)
-- ***********************************

-- Préstamos
-- Préstamo 1 (Activo - Carlos, Ejemplar 1)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) VALUES
(1, 1, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY));
-- Préstamo 2 (Devuelto a tiempo - Ana, Ejemplar 6)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(2, 6, DATE_SUB(NOW(), INTERVAL 30 DAY), DATE_SUB(NOW(), INTERVAL 16 DAY), DATE_SUB(NOW(), INTERVAL 17 DAY));
-- Préstamo 3 (Vencido - Laura, Ejemplar 11 - 1984 Lujo)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) VALUES
(3, 11, DATE_SUB(NOW(), INTERVAL 20 DAY), DATE_SUB(NOW(), INTERVAL 6 DAY));

-- Pagos (Simulación de pago de cuota y multa)
INSERT INTO Pagos (socio_id, monto, medio) VALUES
(1, 25.00, 'transferencia'), -- Cuota de Carlos
(2, 25.00, 'efectivo'),      -- Cuota de Ana
(3, 5.00, 'efectivo');       -- Multa simbólica de Laura


-- 1. Préstamos YA DEVUELTOS A TIEMPO (Histórico)

-- Préstamo 1: Ana (socio_id 2) devolvió "1984" (Ejemplar 6) a tiempo
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(2, 6, DATE_SUB(NOW(), INTERVAL 60 DAY), DATE_SUB(NOW(), INTERVAL 46 DAY), DATE_SUB(NOW(), INTERVAL 50 DAY));

-- Préstamo 2: Miguel (socio_id 4) devolvió "ESDLA" (Ejemplar 15) a tiempo
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(4, 15, DATE_SUB(NOW(), INTERVAL 40 DAY), DATE_SUB(NOW(), INTERVAL 26 DAY), DATE_SUB(NOW(), INTERVAL 28 DAY));

-- Préstamo 3: Jorge (socio_id 5) devolvió "Cosmos" (Ejemplar 26) a tiempo
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(5, 26, DATE_SUB(NOW(), INTERVAL 100 DAY), DATE_SUB(NOW(), INTERVAL 86 DAY), DATE_SUB(NOW(), INTERVAL 88 DAY));


-- 2. Préstamos DEVUELTOS TARDE (Generan Multa)

-- Préstamo 4: Carlos (socio_id 1) devolvió "Cien años..." (Ejemplar 3) con 5 días de retraso
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(1, 3, DATE_SUB(NOW(), INTERVAL 30 DAY), DATE_SUB(NOW(), INTERVAL 16 DAY), DATE_SUB(NOW(), INTERVAL 11 DAY));

-- Préstamo 5: Sofia (socio_id 6) devolvió "IT" (Ejemplar 30) con 10 días de retraso
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(6, 30, DATE_SUB(NOW(), INTERVAL 50 DAY), DATE_SUB(NOW(), INTERVAL 36 DAY), DATE_SUB(NOW(), INTERVAL 26 DAY));


-- 3. Préstamos ACTIVOS (Actuales)

-- Préstamo 6: Laura (socio_id 3) tiene "Orgullo y Prejuicio" (Ejemplar 33)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) VALUES
(3, 33, DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_ADD(NOW(), INTERVAL 9 DAY));

-- Préstamo 7: Ana (socio_id 2) tiene "Buenos Presagios" (Ejemplar 28)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) VALUES
(2, 28, DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_ADD(NOW(), INTERVAL 4 DAY));

-- Préstamo 8: Carlos (socio_id 1) tiene "ESDLA" (Ejemplar 18)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) VALUES
(1, 18, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 13 DAY));


-- 4. Préstamos VENCIDOS NO DEVUELTOS (Generan Multa y Bloqueo)

-- Préstamo 9: Miguel (socio_id 4) tiene "La casa de los espíritus" (Ejemplar 21) vencido hace 7 días
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) VALUES
(4, 21, DATE_SUB(NOW(), INTERVAL 21 DAY), DATE_SUB(NOW(), INTERVAL 7 DAY));

-- Préstamo 10: Jorge (socio_id 5) tiene "1984 Lujo" (Ejemplar 12) vencido hace 30 días
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) VALUES
(5, 12, DATE_SUB(NOW(), INTERVAL 44 DAY), DATE_SUB(NOW(), INTERVAL 30 DAY));