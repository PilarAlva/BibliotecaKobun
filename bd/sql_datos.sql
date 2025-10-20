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
-- # PASO 2: INSERCIÓN DE DATOS DE PRUEBA
-- # (El orden respeta las dependencias de clave foránea)
-- #######################################################################

-- 1. Datos_Biblioteca
INSERT INTO Datos_Biblioteca (mail, multa, cuota_socio, limite_prestamos_nuevos, limite_prestamos) VALUES
('contacto@kobun-db.com', 0.50, 25.00, 5, 10);

-- 2. Roles_Usuarios (Necesario para Usuarios)
INSERT INTO Roles_Usuarios (tipo) VALUES
('Administrador'),
('Bibliotecario'),
('Socio'),
('Profesor');

-- 3. Generos (Necesario para Libros_Generos)
INSERT INTO Generos (nombre) VALUES
('Ficción'),
('Fantasía'),
('Ciencia Ficción'),
('Misterio'),
('Thriller'),
('Romance'),
('No Ficción'),
('Historia'),
('Biografía'),
('Aventura');

-- 4. Autores (Necesario para Libros_Autores)
INSERT INTO Autores (nombre, apellido, fecha_nacimiento, fecha_muerte) VALUES
('Gabriel', 'García Márquez', '1927-03-06', '2014-04-17'),
('Jane', 'Austen', '1775-12-16', '1817-07-18'),
('George', 'Orwell', '1903-06-25', '1950-01-21'),
('J.R.R.', 'Tolkien', '1892-01-03', '1973-09-02'),
('Agatha', 'Christie', '1890-09-15', '1976-01-12');

-- 5. Editoriales (Necesario para Libros_Editoriales)
INSERT INTO Editoriales (nombre) VALUES
('Editorial Planeta'),
('Penguin Random House'),
('HarperCollins'),
('Alianza Editorial'),
('Minotauro');

-- 6. Libros (Necesario para Ejemplares, Libros_Autores, Libros_Editoriales, Libros_Generos)
INSERT INTO Libros (isbn, titulo, sinopsis, ref_portada, fecha_alta, descripcion) VALUES
('9788497592208', 'Cien años de soledad', 'La epopeya de la familia Buendía en Macondo.', '/portadas/cien_anios.jpg', CURDATE(), 'Una obra maestra de la literatura latinoamericana y el realismo mágico.'),
('9788499086111', '1984', 'Una distopía sobre un futuro de vigilancia totalitaria.', '/portadas/1984.jpg', CURDATE(), 'Clásico de la ciencia ficción y la crítica social.'),
('9788445071477', 'El Señor de los Anillos', 'La aventura de Frodo Bolsón para destruir el Anillo Único.', '/portadas/esdla.jpg', CURDATE(), 'Una de las obras más influyentes de la fantasía épica.'),
('9788423351984', 'Asesinato en el Orient Express', 'El detective Hércules Poirot resuelve un misterio a bordo de un tren.', '/portadas/asesinato.jpg', CURDATE(), 'Un clásico del misterio de la reina del crimen.');

-- 7. Ejemplares (Depende de Libros)
-- 3 ejemplares de Cien años de soledad (libro_id=1)
INSERT INTO Ejemplares (libro_id, codigo_topografico) VALUES
(1, 'FIC-GM-C1'),
(1, 'FIC-GM-C2'),
(1, 'FIC-GM-C3'),
-- 2 ejemplares de 1984 (libro_id=2)
(2, 'SCF-GO-D1'),
(2, 'SCF-GO-D2'),
-- 2 ejemplares de El Señor de los Anillos (libro_id=3)
(3, 'FAN-JT-E1'),
(3, 'FAN-JT-E2'),
-- 1 ejemplar de Asesinato en el Orient Express (libro_id=4)
(4, 'MIS-AC-F1');

-- 8. Libros_Autores (Relación N:M)
INSERT INTO Libros_Autores (libro_id, autor_id) VALUES
(1, 1), -- Cien años de soledad por García Márquez
(2, 3), -- 1984 por Orwell
(3, 4), -- ESDLA por Tolkien
(4, 5); -- Asesinato en el Orient Express por Christie

-- 9. Libros_Editoriales (Relación N:M)
INSERT INTO Libros_Editoriales (libro_id, editorial_id) VALUES
(1, 2), -- Cien años de soledad - Penguin
(2, 4), -- 1984 - Alianza
(3, 5), -- ESDLA - Minotauro
(4, 1); -- Asesinato en el Orient Express - Planeta

-- 10. Libros_Generos (Relación N:M)
INSERT INTO Libros_Generos (libro_id, genero_id) VALUES
(1, 1), -- Cien años de soledad - Ficción
(2, 3), -- 1984 - Ciencia Ficción
(3, 2), -- ESDLA - Fantasía
(4, 4); -- Asesinato en el Orient Express - Misterio

-- 11. Usuarios (rol_id: 1=Admin, 2=Bibliotecario, 3=Socio, 4=Profesor)
-- NOTA: La contraseña (password) es un placeholder (debería ser un hash real de 255 caracteres).
INSERT INTO Usuarios (rol_id, nombre, apellido, mail, password) VALUES
(1, 'Juan', 'Pérez', 'juan.perez@kobun.com', 'hash_admin_seguro_123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890'), -- Admin
(2, 'Maria', 'Gómez', 'maria.gomez@kobun.com', 'hash_bibliotecario_seguro_1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890'), -- Bibliotecario
(3, 'Carlos', 'López', 'carlos.lopez@mail.com', 'hash_socio_1_seguro_1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890'), -- Socio 1
(4, 'Ana', 'Martínez', 'ana.martinez@mail.com', 'hash_socio_2_seguro_1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890'), -- Socio 2
(4, 'Pedro', 'Sánchez', 'pedro.sanchez@kobun.com', 'hash_profesor_seguro_1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890'); -- Profesor

-- 12. Socios (Depende de Usuarios. usuario_id: 3=Carlos, 4=Ana)
INSERT INTO Socios (usuario_id, telefono, dni, fecha_alta, fecha_nacimiento) VALUES
(3, '1123456789', '30123456', CURDATE(), '1990-05-15'), -- Socio Carlos (id=1)
(4, '1198765432', '40654321', CURDATE(), '1985-11-20'); -- Socia Ana (id=2)

-- 13. Talleres
INSERT INTO Talleres (nombre, descripcion, horario, lugar) VALUES
('Club de Lectura Clásica', 'Análisis de obras fundamentales de la literatura.', 'Lunes 18:00 - 19:30', 'Sala Principal'),
('Introducción a la Programación', 'Taller básico de Python para principiantes.', 'Miércoles 10:00 - 12:00', 'Aula Multimedia');

-- 14. Talleres_Profesores (Profesor Pedro Sánchez, usuario_id=5)
INSERT INTO Talleres_Profesores (taller_id, usuario_id) VALUES
(1, 5), -- Pedro enseña el Club de Lectura
(2, 5); -- Pedro enseña el Taller de Programación

-- 15. Talleres_Usuarios (Inscripción de Socios. Socio Carlos=3, Socia Ana=4)
INSERT INTO Talleres_Usuarios (taller_id, usuario_id) VALUES
(1, 3), -- Carlos se inscribe al Club de Lectura
(2, 4); -- Ana se inscribe al Taller de Programación

-- 16. Préstamos (ejemplo de un préstamo activo)
-- Socio: Carlos (socio_id=1). Ejemplar: FIC-GM-C1 (ejemplar_id=1).
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento) VALUES
(1, 1, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY)); -- Préstamo de 'Cien años de soledad' por 14 días.