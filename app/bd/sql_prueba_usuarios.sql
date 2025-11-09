-- ==============================================================================
-- 1. CONFIGURACIÓN INICIAL Y LIMPIEZA
-- ==============================================================================

-- Desactiva la verificación de claves foráneas para permitir la inserción forzada
SET FOREIGN_KEY_CHECKS = 0;

-- Limpieza de tablas clave para evitar conflictos con los IDs
TRUNCATE TABLE Publicaciones_Archivo;
TRUNCATE TABLE Prestamos;
TRUNCATE TABLE Pagos;
TRUNCATE TABLE Ejemplares;
TRUNCATE TABLE Libros_Autores;
TRUNCATE TABLE Libros_Editoriales;
TRUNCATE TABLE Libros_Generos;
TRUNCATE TABLE Talleres_Usuarios;
TRUNCATE TABLE Talleres_Profesores;
TRUNCATE TABLE Socios;
TRUNCATE TABLE Publicaciones;
TRUNCATE TABLE Archivos;
TRUNCATE TABLE Libros;
TRUNCATE TABLE Autores;
TRUNCATE TABLE Editoriales;
TRUNCATE TABLE Generos;
TRUNCATE TABLE Talleres;
TRUNCATE TABLE Usuarios;
TRUNCATE TABLE Roles_Usuarios;
TRUNCATE TABLE Datos_Biblioteca;

-- ==============================================================================
-- 2. INSERCIÓN DE DATOS MAESTROS Y ESTRUCTURALES
-- ==============================================================================

-- Roles de Usuario (IDs: 0, 1, 2)
INSERT INTO Roles_Usuarios (id, tipo) VALUES   
(1, 'Administrador'),  
(2, 'Profesor'),
(3, 'Usuario');

-- Ajustar AUTO_INCREMENT para continuar después de los IDs manuales
ALTER TABLE Roles_Usuarios AUTO_INCREMENT = 3; 

-- Datos de la Biblioteca (Configuración de Multa y Cuota)
INSERT INTO Datos_Biblioteca (mail, multa, cuota_socio, limite_prestamos_nuevos, limite_prestamos)
VALUES ('biblioteca@kobun.com', 5.00, 150.00, 1, 3);

-- Géneros y Editoriales base
INSERT INTO Generos (nombre) VALUES 
('Ciencia Ficción'), ('Fantasía'), ('Misterio');

INSERT INTO Editoriales (nombre) VALUES 
('Lector Veloz'), ('Ediciones Foco');

-- Autores
INSERT INTO Autores (id, nombre, apellido, fecha_nacimiento) VALUES 
(1, 'Agatha', 'Christie', '1890-09-15'),
(2, 'Isaac', 'Asimov', '1920-01-02');

-- ==============================================================================
-- 3. CREACIÓN DE RECURSOS (LIBROS Y EJEMPLARES)
-- ==============================================================================

-- Libros de prueba
INSERT INTO Libros (id, isbn, titulo, sinopsis, descripcion, fecha_alta) VALUES 
(1, '9788497592398', 'El Misterio del Libro Falso', 'Un detective debe resolver el misterio de un manuscrito robado.', 'Novela de intriga clásica.', '2024-01-10'),
(2, '9788445000965', 'Viaje a la Nebulosa Alfa', 'Un épico viaje espacial a través de galaxias desconocidas.', 'Ciencia ficción dura.', '2024-03-20'),
(3, '9788433918005', 'La Casa Silenciosa', 'Una historia de terror psicológico.', 'Novela corta de terror.', '2024-05-01');

-- Relaciones Libro-Autor
INSERT INTO Libros_Autores (libro_id, autor_id) VALUES 
(1, 1), -- El Misterio -> Christie
(2, 2); -- Viaje -> Asimov

-- Relaciones Libro-Editorial
INSERT INTO Libros_Editoriales (libro_id, editorial_id) VALUES 
(1, 1), 
(2, 2),
(3, 1);

-- Relaciones Libro-Género
INSERT INTO Libros_Generos (libro_id, genero_id) VALUES 
(1, 3), -- Misterio
(2, 1), -- Ciencia Ficción
(3, 3); -- Misterio

-- Ejemplares (Los recursos que se prestarán)
INSERT INTO Ejemplares (id, libro_id, codigo_topografico) VALUES 
(101, 1, 'MIST.A.1'), -- Ejemplar 1 de "El Misterio..."
(102, 1, 'MIST.A.2'), -- Ejemplar 2 de "El Misterio..."
(201, 2, 'CFIC.I.1'), -- Ejemplar 1 de "Viaje a la Nebulosa Alfa"
(301, 3, 'TERR.C.1'); -- Ejemplar 1 de "La Casa Silenciosa"

-- ==============================================================================
-- 4. SIMULACIÓN DE FLUJO DE USUARIOS (SOCIOS)
-- ==============================================================================

-- PASO 1: CREACIÓN DE 3 USUARIOS REGISTRADOS
INSERT INTO Usuarios (rol_id, nombre, apellido, mail, clave) VALUES
( 3, 'Alex', 'Ruiz', 'alex.ruiz@test.com', SHA2('clavealex', 256)),
( 3, 'Brenda', 'Castro', 'brenda.castro@test.com', SHA2('clavebrenda', 256)),
( 3, 'Carlos', 'Dominguez', 'carlos.dominguez@test.com', SHA2('clavecarlos', 256));

-- PASO 2: LOS 3 USUARIOS SE HACEN SOCIOS (Fechas de alta recientes)
INSERT INTO Socios (id, usuario_id, telefono, dni, fecha_alta, fecha_nacimiento) VALUES
(1, 10, '555-1010', '11111111A', '2025-09-01', '1990-05-15'), -- Alex
(2, 11, '555-2020', '22222222B', '2025-09-01', '1985-11-20'), -- Brenda
(3, 12, '555-3030', '33333333C', '2025-09-01', '2000-02-01'); -- Carlos

-- PASO 3: REGISTRO DE PAGOS DE CUOTA ANUAL (Los 3 pagan la cuota al inicio)
INSERT INTO Pagos (socio_id, monto, medio, fecha) VALUES
(1, 150.00, 'transferencia', '2025-09-01 10:00:00'), -- Alex paga cuota
(2, 150.00, 'efectivo', '2025-09-01 11:00:00'),     -- Brenda paga cuota
(3, 150.00, 'transferencia', '2025-09-01 12:00:00'); -- Carlos paga cuota

-- ==============================================================================
-- 5. SIMULACIÓN DE PRÉSTAMOS NORMALES (Devueltos a tiempo)
-- ==============================================================================

-- ALEX: Préstamo del Ejemplar 101 (Misterio)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(1, 101, '2025-09-15 14:00:00', '2025-09-29', '2025-09-25'); -- Devuelto 4 días antes

-- BRENDA: Préstamo del Ejemplar 201 (Ciencia Ficción)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(2, 201, '2025-09-18 09:30:00', '2025-10-02', '2025-10-01'); -- Devuelto 1 día antes

-- CARLOS: Préstamo del Ejemplar 301 (Casa Silenciosa)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(3, 301, '2025-09-20 11:00:00', '2025-10-04', '2025-10-03'); -- Devuelto 1 día antes

-- ==============================================================================
-- 6. SIMULACIÓN DE PRÉSTAMO CON MULTA Y PAGO ASOCIADO
-- ==============================================================================

-- CARLOS: Segundo Préstamo (Ejemplar 102)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(3, 102, '2025-10-10 16:00:00', '2025-10-24', '2025-10-29'); 
-- Vencimiento: 2025-10-24
-- Devolución: 2025-10-29 (5 días de atraso)

-- Cálculo de Multa (Multa es 5.00 por día): 5 días * 5.00 = 25.00

-- CARLOS: Pago de Multa generado por el atraso
INSERT INTO Pagos (socio_id, monto, medio, fecha) VALUES
(3, 25.00, 'efectivo', '2025-10-29 12:00:00'); -- Pago de multa al momento de devolver.

-- ==============================================================================
-- 7. SIMULACIÓN DE PRÉSTAMO ACTIVO (SIN DEVOLVER)
-- ==============================================================================

-- ALEX: Segundo Préstamo (Activo, no devuelto)
INSERT INTO Prestamos (socio_id, ejemplar_id, fecha_prestamo, fecha_vencimiento, fecha_devolucion) VALUES
(1, 201, '2025-11-01 10:00:00', '2025-11-15', NULL); 
-- Este préstamo sigue activo y sin devolver al día de hoy (07-11-2025)

-- ==============================================================================
-- 8. CIERRE
-- ==============================================================================

-- Vuelve a activar la verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;