CREATE DATABASE IF NOT EXISTS kobun_db;

USE kobun_db;

CREATE TABLE IF NOT EXISTS Generos(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(30) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Autores(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(30) NOT NULL,
	apellido varchar(30) NOT NULL,
	fecha_nacimiento DATE,
	fecha_muerte DATE
);

CREATE TABLE IF NOT EXISTS Editoriales(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(60) NOT NULL UNIQUE
);

/*El estandar ahora es del isbn-13 que tiene 13 caracteres como máximo*/
CREATE TABLE IF NOT EXISTS Libros(
	id INT AUTO_INCREMENT PRIMARY KEY,
	isbn VARCHAR(13) NOT NULL UNIQUE,
	titulo varchar(100) NOT NULL,
	sinopsis TEXT,
	ref_portada VARCHAR(100),
	fecha_alta DATE DEFAULT CURRENT_DATE,
	activo BOOLEAN DEFAULT TRUE,
	descripcion TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Ejemplares(
	id INT AUTO_INCREMENT PRIMARY KEY,
	libro_id INT NOT NULL,
	codigo_topografico VARCHAR(30) NOT NULL,
	
	INDEX(libro_id),

	FOREIGN KEY(libro_id) REFERENCES Libros(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Libros_Autores (
	libro_id INT NOT NULL,
	autor_id INT NOT NULL,
	
	PRIMARY KEY (libro_id, autor_id),
	FOREIGN KEY (libro_id) REFERENCES Libros(id) ON UPDATE CASCADE ON DELETE CASCADE, 
	FOREIGN KEY (autor_id) REFERENCES Autores(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Libros_Editoriales (
	libro_id INT NOT NULL,
	editorial_id INT NOT NULL,
	
	PRIMARY KEY (libro_id, editorial_id),
	FOREIGN KEY (libro_id) REFERENCES Libros(id),
	FOREIGN KEY (editorial_id) REFERENCES Editoriales(id)
);

CREATE TABLE IF NOT EXISTS Libros_Generos (
	libro_id INT NOT NULL,
	genero_id INT NOT NULL,
	PRIMARY KEY (libro_id, genero_id),
	FOREIGN KEY (libro_id) REFERENCES Libros(id) ON DELETE CASCADE,
	FOREIGN KEY (genero_id) REFERENCES Generos(id) ON UPDATE CASCADE ON DELETE RESTRICT
);


/*Usuarios*/


CREATE TABLE IF NOT EXISTS Roles_Usuarios(
	id INT AUTO_INCREMENT PRIMARY KEY,
	tipo VARCHAR(20) NOT NULL	
);

CREATE TABLE IF NOT EXISTS Usuarios(
	id INT AUTO_INCREMENT PRIMARY KEY,
	rol_id INT DEFAULT 3,
	nombre VARCHAR(60) NOT NULL,
	apellido VARCHAR(60) NOT NULL,
	mail VARCHAR(100) NOT NULL UNIQUE,
	clave CHAR(255) NOT NULL,
	img_perfil VARCHAR(100),

	FOREIGN KEY (rol_id) 
	REFERENCES Roles_Usuarios(id)
	ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Socios(
	id INT AUTO_INCREMENT PRIMARY KEY,
	usuario_id INT DEFAULT 1,
	telefono VARCHAR(60) NOT NULL,
	dni VARCHAR(60) NOT NULL UNIQUE,
	fecha_alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	activo BOOLEAN DEFAULT TRUE,
	fecha_nacimiento DATE,

	FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
	ON UPDATE CASCADE ON DELETE RESTRICT
);

/* Talleres */
CREATE TABLE IF NOT EXISTS Talleres(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(200) NOT NULL,
	descripcion TEXT,
	ref_portada VARCHAR(100),
	horario VARCHAR(100),
	lugar VARCHAR(100),
	activo BOOLEAN DEFAULT TRUE,	
	cupo INT NULL,
	fecha_alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	
	INDEX (nombre)
);

CREATE TABLE IF NOT EXISTS Talleres_Usuarios(
	taller_id INT NOT NULL,
	usuario_id INT NOT NULL,
	activo BOOLEAN DEFAULT FALSE,
	fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (taller_id, usuario_id),
	FOREIGN KEY (taller_id) REFERENCES Talleres(id) ON DELETE CASCADE,
	FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE

);


CREATE TABLE IF NOT EXISTS Talleres_Profesores(
	taller_id INT NOT NULL,
	usuario_id INT NOT NULL,
	PRIMARY KEY (taller_id, usuario_id),
	FOREIGN KEY (taller_id) REFERENCES Talleres(id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE
);

/* Contenidos */
CREATE TABLE IF NOT EXISTS Archivos(
	id INT AUTO_INCREMENT PRIMARY KEY,
	referencia VARCHAR(200) NOT NULL,
	titulo VARCHAR(100) NOT NULL
);
CREATE TABLE IF NOT EXISTS Publicaciones(
	id INT AUTO_INCREMENT PRIMARY KEY,
	taller_id INT NOT NULL,
	usuario_id INT NOT NULL,
	alcance ENUM('foro', 'libreta', 'recurso','privado') NOT NULL DEFAULT 'foro',
	fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	titulo TEXT NOT NULL,
	cuerpo TEXT,

	FOREIGN KEY (taller_id) REFERENCES Talleres(id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Publicaciones_Archivo( 
    archivo_id INT NOT NULL,
    publicacion_id INT NOT NULL,

    PRIMARY KEY (archivo_id, publicacion_id),
    FOREIGN KEY(archivo_id) REFERENCES Archivos(id) ON DELETE CASCADE,
    FOREIGN KEY (publicacion_id) REFERENCES Publicaciones(id) ON DELETE CASCADE
);

/*Gestion*/

CREATE TABLE IF NOT EXISTS Prestamos(
	id INT AUTO_INCREMENT PRIMARY KEY,
	socio_id INT NOT NULL,
	ejemplar_id INT NOT NULL,

	fecha_prestamo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	fecha_vencimiento DATE NOT NULL, 	
	fecha_devolucion DATE,
 
	INDEX (socio_id),
	INDEX (ejemplar_id),

	FOREIGN KEY (socio_id) REFERENCES Socios(id) ON UPDATE CASCADE,
	FOREIGN KEY (ejemplar_id) REFERENCES Ejemplares(id) ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS Pagos(
	id INT AUTO_INCREMENT PRIMARY KEY,
	socio_id INT NOT NULL,
	monto DECIMAL(10, 2) NOT NULL,
	razon VARCHAR(100),
	medio ENUM('efectivo', 'transferencia'),
	fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	FOREIGN KEY (socio_id) REFERENCES Socios(id)
);

CREATE TABLE IF NOT EXISTS Datos_Biblioteca(
	mail varchar(100),
	multa DECIMAL(10, 2),
	cuota_socio DECIMAL(10, 2),
	limite_prestamos_nuevos INT,
	limite_prestamos INT
);

CREATE TABLE IF NOT EXISTS Correos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(30),
    consulta TEXT NOT NULL
	fecha_envio DATE DEFAULT CURRENT_DATE

);

CREATE TABLE IF NOT EXISTS Multas(
	id INT AUTO_INCREMENT PRIMARY KEY,
	socio_id NOT NULL,
	monto DECIMAL(10, 2) NOT NULL,
	fecha_alta DATE DEFAULT CURRENT_DATE,
	fecha_pago DATE,

	FOREIGN KEY (socio_id) REFERENCES Socios(id)
	ON UPDATE CASCADE ON DELETE CASCADE

);

DELIMITER //

CREATE TRIGGER asignar_codigo_topografico
AFTER INSERT ON ejemplares
FOR EACH ROW
BEGIN
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
END;
//

DELIMITER ;

DELIMITER //

CREATE TRIGGER generar_multa_por_retraso
AFTER UPDATE ON prestamos
FOR EACH ROW
BEGIN
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
            INSERT INTO multas (socio_id, monto, fecha_multa, descripcion)
            VALUES (
                NEW.socio_id,
                total_multa,
                NOW()
            );
        END IF;

    END IF;
END;
//

DELIMITER ;