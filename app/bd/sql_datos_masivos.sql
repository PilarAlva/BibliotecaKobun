-- #############################################################
-- # INSERCIÓN DE DATOS MAESTROS (Roles de Usuario) #
-- #############################################################
USE kobun_db;
-- 1. Truncar y restablecer el AUTO_INCREMENT
TRUNCATE TABLE Roles_Usuarios;
ALTER TABLE Roles_Usuarios AUTO_INCREMENT = 3; -- Establece el próximo ID a 3, para que los inserts 
                                              -- manuales (0, 1, 2) no interfieran.

-- 2. Insertar roles forzando los IDs 0, 1 y 2
INSERT INTO Roles_Usuarios (id, tipo) VALUES 
(0, 'Invitado'),     -- ID 0
(1, 'Administrador'),  -- ID 1
(2, 'Profesor');       -- ID 2
-- Nota: Si tu tabla Usuarios depende de Rol_ID 1 o 2, estos ya están definidos.

-- Datos maestros restantes:
INSERT INTO Generos (nombre) VALUES 
('Ciencia Ficción'), ('Fantasía'), ('Misterio'), ('Thriller'), 
('Novela Histórica'), ('Biografía'), ('Poesía'), ('Aventura');

INSERT INTO Editoriales (nombre) VALUES 
('Editorial Ficticia S.A.'), ('Libros del Sur'), ('Ediciones Cósmicas'),
('Prensa Antigua'), ('Tinta Fresca');

INSERT INTO Datos_Biblioteca (mail, multa, cuota_socio, limite_prestamos_nuevos, limite_prestamos)
VALUES ('biblioteca@kobun.com', 5.00, 150.00, 1, 3);

-- Cambia el delimitador para definir los procedimientos
USE kobun_db;

DELIMITER $$ 

-- --------------------------------------------------
-- PROCEDIMIENTO 1: LLENAR AUTORES
-- --------------------------------------------------
DROP PROCEDURE IF EXISTS llenar_autores$$
CREATE PROCEDURE llenar_autores(IN num_filas INT)
BEGIN
    DECLARE i INT DEFAULT 0;
    
    WHILE i < num_filas DO
        INSERT INTO Autores (nombre, apellido, fecha_nacimiento)
        VALUES (
            CONCAT('Autor_Nombre_', FLOOR(1 + (RAND() * 9999))), 
            CONCAT('Apellido_', FLOOR(1 + (RAND() * 9999))),
            DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 80 * 365) DAY) -- Edad entre 1 y 80
        );
        SET i = i + 1;
    END WHILE;
END$$

-- Cambia el delimitador para definir el procedimiento
DELIMITER $$ 

-- --------------------------------------------------
-- PROCEDIMIENTO 2: LLENAR USUARIOS (Actualizado)
-- --------------------------------------------------
DROP PROCEDURE IF EXISTS llenar_usuarios$$
CREATE PROCEDURE llenar_usuarios(IN num_filas INT)
BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE random_rol INT;

    -- Insertamos el usuario base (Administrador o Profesor - Rol 1 o 2)
    -- Asumimos que el primer usuario insertado manualmente o por el script será el que 
    -- luego usará la tabla Socios si la FK lo requiere, por eso usamos rol 1.
    INSERT INTO Usuarios (rol_id, nombre, apellido, mail, clave) 
    VALUES (1, 'Admin', 'Sistema', 'admin@sistema.com', SHA2('clave_segura', 256));

    WHILE i < num_filas DO
        -- ID de rol aleatorio entre 1 (Administrador) y 2 (Profesor)
        -- Si quisieras incluir Socios, deberías añadir un Rol 3 para Socio.
        SET random_rol = FLOOR(1 + (RAND() * 2)); 

        INSERT INTO Usuarios (rol_id, nombre, apellido, mail, clave)
        VALUES (
            random_rol,
            CONCAT('Usuario_Nombre_', i), 
            CONCAT('Apellido_', i),
            CONCAT('usuario', i, '@mail.com'),
            SHA2(CONCAT('clave', i), 256)
        );
        SET i = i + 1;
    END WHILE;
END$$

-- --------------------------------------------------
-- PROCEDIMIENTO 3: LLENAR LIBROS
-- --------------------------------------------------
DROP PROCEDURE IF EXISTS llenar_libros$$
CREATE PROCEDURE llenar_libros(IN num_filas INT)
BEGIN
    DECLARE i INT DEFAULT 0;
    
    WHILE i < num_filas DO
        INSERT INTO Libros (isbn, titulo, descripcion, fecha_alta)
        VALUES (
            -- Genera un ISBN de 13 dígitos
            CONCAT(FLOOR(RAND() * 900) + 100, FLOOR(RAND() * 900000000000) + 100000000000), 
            CONCAT('Título Ficticio ', i),
            CONCAT('Descripción detallada del libro ', i, ' y su sinopsis.'),
            DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 5 * 365) DAY) -- Fecha de alta de los últimos 5 años
        );
        SET i = i + 1;
    END WHILE;
END$$

-- --------------------------------------------------
-- PROCEDIMIENTO 4: LLENAR EJEMPLARES
-- --------------------------------------------------
DROP PROCEDURE IF EXISTS llenar_ejemplares$$
CREATE PROCEDURE llenar_ejemplares(IN num_filas INT)
BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE max_libro_id INT;
    SET max_libro_id = (SELECT MAX(id) FROM Libros);

    WHILE i < num_filas DO
        INSERT INTO Ejemplares (libro_id, codigo_topografico)
        VALUES (
            -- ID de libro aleatorio válido
            FLOOR(1 + (RAND() * max_libro_id)), 
            CONCAT('T', FLOOR(RAND() * 10), '.S', FLOOR(RAND() * 10), '.', i)
        );
        SET i = i + 1;
    END WHILE;
END$$

-- --------------------------------------------------
-- PROCEDIMIENTO 5: LLENAR SOCIOS (asumiendo que 10% de usuarios son socios)
-- --------------------------------------------------
DROP PROCEDURE IF EXISTS llenar_socios$$
CREATE PROCEDURE llenar_socios(IN num_socios INT)
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE max_usuario_id INT;
    SET max_usuario_id = (SELECT MAX(id) FROM Usuarios);

    WHILE i <= num_socios DO
        INSERT INTO Socios (usuario_id, telefono, dni, fecha_alta, fecha_nacimiento)
        VALUES (
            -- Asigna IDs de usuarios secuenciales a los primeros socios
            i, 
            CONCAT('555-000-', i),
            CONCAT('DNI-', i),
            DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 3 * 365) DAY), -- Fecha de alta de los últimos 3 años
            DATE_SUB(CURDATE(), INTERVAL FLOOR(RAND() * 40 * 365) DAY) -- Edad entre 20 y 60
        );
        SET i = i + 1;
    END WHILE;
END$$

-- Restaura el delimitador
DELIMITER ;

-- ######################################
-- # EJECUCIÓN DE PROCEDIMIENTOS (10,000 FILAS) #
-- ######################################

CALL llenar_autores(10000); 
CALL llenar_usuarios(10000); 
CALL llenar_libros(5000);     -- 5,000 libros
CALL llenar_ejemplares(10000); -- 10,000 ejemplares (promedio de 2 por libro)
CALL llenar_socios(1000);     -- 1,000 socios

-- Opcional: Eliminar procedimientos después de usarlos
DROP PROCEDURE llenar_autores;
DROP PROCEDURE llenar_usuarios;
DROP PROCEDURE llenar_libros;
DROP PROCEDURE llenar_ejemplares;
DROP PROCEDURE llenar_socios;