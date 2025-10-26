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
	fecha_alta DATE,
	activo BOOLEAN DEFAULT TRUE,
	descripcion TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Ejemplares(
	id INT AUTO_INCREMENT PRIMARY KEY,
	libro_id INT NOT NULL,
	codigo_topografico VARCHAR(30) NOT NULL,
	
	INDEX(libro_id),

	FOREIGN KEY(libro_id) REFERENCES Libros(id)
);

CREATE TABLE IF NOT EXISTS Libros_Autores (
	libro_id INT NOT NULL,
	autor_id INT NOT NULL,
	
	PRIMARY KEY (libro_id, autor_id),
	FOREIGN KEY (libro_id) REFERENCES Libros(id),
	FOREIGN KEY (autor_id) REFERENCES Autores(id)
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
	FOREIGN KEY (libro_id) REFERENCES Libros(id),
	FOREIGN KEY (genero_id) REFERENCES Generos(id)
);


/*Usuarios*/


CREATE TABLE IF NOT EXISTS Roles_Usuarios(
	id INT AUTO_INCREMENT PRIMARY KEY,
	tipo VARCHAR(20) NOT NULL	
);

CREATE TABLE IF NOT EXISTS Usuarios(
	id INT AUTO_INCREMENT PRIMARY KEY,
	rol_id INT,
	nombre VARCHAR(60) NOT NULL,
	apellido VARCHAR(60) NOT NULL,
	mail VARCHAR(100) NOT NULL UNIQUE,
	password CHAR(255) NOT NULL,
	img_perfil VARCHAR(100),

	FOREIGN KEY (rol_id) REFERENCES Roles_Usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Socios(
	id INT AUTO_INCREMENT PRIMARY KEY,
	usuario_id INT NOT NULL,
	telefono VARCHAR(60) NOT NULL,
	dni VARCHAR(60) NOT NULL UNIQUE,
	fecha_alta DATE NOT NULL,
	activo BOOLEAN DEFAULT TRUE,
	fecha_nacimiento DATE,

	FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT
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
	
	INDEX (nombre)
);

CREATE TABLE IF NOT EXISTS Talleres_Usuarios(
	taller_id INT NOT NULL,
	usuario_id INT NOT NULL,
	PRIMARY KEY (taller_id, usuario_id),
	FOREIGN KEY (taller_id) REFERENCES Talleres(id),
	FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)

);


CREATE TABLE IF NOT EXISTS Talleres_Profesores(
	taller_id INT NOT NULL,
	usuario_id INT NOT NULL,
	PRIMARY KEY (taller_id, usuario_id),
	FOREIGN KEY (taller_id) REFERENCES Talleres(id),
	FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
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
    	public BOOLEAN DEFAULT TRUE,
    	fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	titulo TEXT NOT NULL,
	cuerpo TEXT,

	FOREIGN KEY (taller_id) REFERENCES Talleres(id),
	FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

CREATE TABLE IF NOT EXISTS Publicaciones_Archivo( 
    archivo_id INT NOT NULL,
    publicacion_id INT NOT NULL,

    PRIMARY KEY (archivo_id, publicacion_id),
    FOREIGN KEY(archivo_id) REFERENCES Archivos(id),
    FOREIGN KEY (publicacion_id) REFERENCES Publicaciones(id)
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

	FOREIGN KEY (socio_id) REFERENCES Socios(id),
	FOREIGN KEY (ejemplar_id) REFERENCES Ejemplares(id)
);

CREATE TABLE IF NOT EXISTS Pagos(
	id INT AUTO_INCREMENT PRIMARY KEY,
	socio_id INT NOT NULL,
	monto DECIMAL(10, 2) NOT NULL,
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
