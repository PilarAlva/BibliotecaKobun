-- Poblar la base de datos kobun_db con datos realistas de ejemplo
USE kobun_db;

-- Roles
INSERT INTO Roles_Usuarios (tipo) VALUES 
('Administrador'),
('Profesor');

-- Usuarios
INSERT INTO Usuarios (rol_id, nombre, apellido, mail, clave, img_perfil) VALUES
(1, 'Lucía', 'Paredes', 'lucia.paredes@kobun.org', '123456', 'lucia.jpg'),
(1, 'Carlos', 'Benítez', 'carlos.benitez@kobun.org', '123456', 'carlos.jpg'),
(2, 'Mariana', 'Suárez', 'mariana.suarez@kobun.org', '123456', 'mariana.jpg'),
(2, 'Diego', 'Rossi', 'diego.rossi@kobun.org', '123456', 'diego.jpg'),
(2, 'Elena', 'Martínez', 'elena.martinez@kobun.org', '123456', 'elena.jpg');

-- Socios (solo algunos usuarios)
INSERT INTO Socios (usuario_id, telefono, dni, fecha_alta, activo, fecha_nacimiento) VALUES
(1, '1132457890', '34122345', '2024-02-15', TRUE, '1990-03-10'),
(3, '1156789012', '37999887', '2024-05-20', TRUE, '1988-07-02'),
(4, '1123456789', '40111222', '2024-06-01', TRUE, '1992-09-25');

-- Géneros
INSERT INTO Generos (nombre) VALUES 
('Ficción contemporánea'),
('Poesía'),
('Ensayo'),
('Infantil'),
('Misterio');

-- Autores
INSERT INTO Autores (nombre, apellido, fecha_nacimiento, fecha_muerte) VALUES
('Julio', 'Cortázar', '1914-08-26', '1984-02-12'),
('María', 'Elena Walsh', '1930-02-01', '2011-01-10'),
('Samanta', 'Schweblin', '1978-03-19', NULL),
('Ernesto', 'Sábato', '1911-06-24', '2011-04-30');

-- Editoriales
INSERT INTO Editoriales (nombre) VALUES 
('Alfaguara'),
('Planeta'),
('Sudamericana');

-- Libros
INSERT INTO Libros (isbn, titulo, sinopsis, ref_portada, fecha_alta, activo, descripcion) VALUES
('9789877385661', 'Rayuela', 'Una novela emblemática del boom latinoamericano.', 'rayuela.jpg', '2024-07-01', TRUE, 'Una historia no lineal de amor y búsqueda existencial.'),
('9789500721893', 'El túnel', 'Obra existencialista argentina de gran repercusión.', 'eltunel.jpg', '2024-07-01', TRUE, 'Juan Pablo Castel narra su obsesión por una mujer.'),
('9789500723354', 'Cuentos para ver', 'Selección de cuentos para niños.', 'cuentosver.jpg', '2024-07-15', TRUE, 'Una recopilación de cuentos con valores y humor.');

-- Libros_Autores
INSERT INTO Libros_Autores (libro_id, autor_id) VALUES
(1, 1),
(2, 4),
(3, 2);

-- Libros_Editoriales
INSERT INTO Libros_Editoriales (libro_id, editorial_id) VALUES
(1, 3),
(2, 2),
(3, 1);

-- Libros_Generos
INSERT INTO Libros_Generos (libro_id, genero_id) VALUES
(1, 1),
(2, 1),
(3, 4);

-- Ejemplares
INSERT INTO Ejemplares (libro_id, codigo_topografico) VALUES
(1, 'FIC-COR-001'),
(1, 'FIC-COR-002'),
(2, 'FIC-SAB-001'),
(3, 'INF-WAL-001');

-- Talleres
INSERT INTO Talleres (nombre, descripcion, ref_portada, horario, lugar, activo) VALUES
('Taller de Escritura Creativa', 'Espacio para explorar la narración y el relato breve.', 'taller_escritura.jpg', 'Miércoles 18:00 - 20:00', 'Sala Azul', TRUE),
('Círculo de Lectura', 'Encuentros semanales para debatir obras seleccionadas.', 'circulo_lectura.jpg', 'Jueves 17:00 - 19:00', 'Sala Amarilla', TRUE);

-- Talleres_Profesores
INSERT INTO Talleres_Profesores (taller_id, usuario_id) VALUES
(1, 3),
(2, 4);

-- Talleres_Usuarios (participantes)
INSERT INTO Talleres_Usuarios (taller_id, usuario_id) VALUES
(1, 1),
(1, 5),
(2, 1),
(2, 3);

-- Archivos
INSERT INTO Archivos (referencia, titulo) VALUES
('archivo1.pdf', 'Guía de ejercicios'),
('archivo2.pdf', 'Lecturas recomendadas');

-- Publicaciones
INSERT INTO Publicaciones (taller_id, usuario_id, titulo, cuerpo) VALUES
(1, 3, 'Inspiración para escribir', 'El proceso creativo comienza con la observación del entorno.'),
(2, 4, 'Próxima lectura: Rayuela', 'La próxima semana debatiremos sobre la estructura de Rayuela.');

-- Publicaciones_Archivo
INSERT INTO Publicaciones_Archivo (archivo_id, publicacion_id) VALUES
(1, 1),
(2, 2);

-- Prestamos
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_vencimiento, fecha_devolucion) VALUES
(1, 1, '2024-10-15', '2024-10-10'),
(3, 3, '2024-10-20', NULL);

-- Pagos
INSERT INTO Pagos (socio_id, monto, medio) VALUES
(1, 2500.00, 'efectivo'),
(3, 2500.00, 'transferencia');

-- Datos Biblioteca
INSERT INTO Datos_Biblioteca (mail, multa, cuota_socio, limite_prestamos_nuevos, limite_prestamos) VALUES
('contacto@kobun.org', 500.00, 2500.00, 2, 5);
