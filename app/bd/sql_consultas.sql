/*Usuario por socios*/
 
SELECT * FROM Usuarios u
LEFT JOIN Socios s
ON u.id = s.usuario_id;

/*Generos de libros*/
SELECT l.titulo titulo, group_concat(g.nombre) generos  FROM libros l
LEFT JOIN libros_generos lg 
ON l.id = lg.libro_id
LEFT JOIN generos g 
ON lg.genero_id = g.id
GROUP BY l.titulo;

/*Toda la info*/
SELECT  
	l.titulo as titulo,
    l.sinopsis as sinopsis,
    l.ref_portada as portada,
    l.descripcion as descripcion,
	group_concat(distinct g.nombre separator ', ') as generos,
    group_concat(distinct concat(a.nombre, ' ', a.apellido ) separator ', ') as autores,
    group_concat(distinct e.nombre separator ', ') as editorial
    
FROM libros l

LEFT JOIN libros_generos lg ON l.id = lg.libro_id
LEFT JOIN generos g ON lg.genero_id = g.id
LEFT JOIN libros_autores la ON l.id = la.libro_id
LEFT JOIN autores a ON la.autor_id = a.id
LEFT JOIN libros_editoriales le ON l.id = le.libro_id
LEFT JOIN editoriales e ON le.editorial_id = e.id

GROUP BY  l.id
LIMIT 0, 1000;

/*Cantidad resutlados*/

SELECT  
	count(distinct l.id)
FROM libros l

LEFT JOIN libros_generos lg ON l.id = lg.libro_id
LEFT JOIN generos g ON lg.genero_id = g.id
LEFT JOIN libros_autores la ON l.id = la.libro_id
LEFT JOIN autores a ON la.autor_id = a.id
LEFT JOIN libros_editoriales le ON l.id = le.libro_id
LEFT JOIN editoriales e ON le.editorial_id = e.id;

/*Búsqueda*/

SELECT  
	l.titulo as titulo,
    l.sinopsis as sinopsis,
    l.ref_portada as portada,
    l.descripcion as descripcion,
	group_concat(distinct g.nombre separator ', ') as generos,
    group_concat(distinct concat(a.nombre, ' ', a.apellido ) separator ', ') as autores,
    group_concat(distinct e.nombre separator ', ') as editorial
    
FROM libros l

LEFT JOIN libros_generos lg ON l.id = lg.libro_id
LEFT JOIN generos g ON lg.genero_id = g.id
LEFT JOIN libros_autores la ON l.id = la.libro_id
LEFT JOIN autores a ON la.autor_id = a.id
LEFT JOIN libros_editoriales le ON l.id = le.libro_id
LEFT JOIN editoriales e ON le.editorial_id = e.id
WHERE l.activo = 1
AND EXISTS (
	SELECT 1 
	FROM libros_autores la2 
	INNER JOIN autores a2 ON la2.autor_id = a2.id 
	WHERE la2.libro_id = l.id 
		AND a2.nombre LIKE "%gabriel%" OR
		a2.apellido   LIKE "%gabriel%")

GROUP BY  l.id
LIMIT 0, 100;


/*Cantidad de ejemplares por libro*/

SELECT l.id, count(e.id) as cantidad FROM libros l
LEFT JOIN ejemplares e ON e.libro_id = l.id
GROUP BY l.id;

/*Ejemplares disponibles*/

SELECT l.titulo titulo, count(e.id) disponibles FROM libros l
LEFT JOIN ejemplares e ON e.libro_id = l.id
LEFT JOIN prestamos p ON p.ejemplar_id = e.id
WHERE fecha_devolucion IS NOT NULL
GROUP BY l.id;

/*Cantidad de préstamos por ejemplar*/

SELECT l.id libro_id, e.id ejemplar_id,
	(select count(p.id) from prestamos p  WHERE e.id = p.ejemplar_id  ) cantidad_préstamos
 FROM libros l
LEFT JOIN ejemplares e ON e.libro_id = l.id
ORDER BY l.id;

/*Cantidad de ejemplares disponibles por libro*/

SELECT 
	l.titulo titulo,
	count(e.id) - count(a.ejemplar_id) as disponibles
FROM ejemplares e
LEFT JOIN (
	SELECT 
		ejemplar_id 
	FROM prestamos WHERE fecha_devolucion IS NULL
    )AS a 
ON e.id = a.ejemplar_id
LEFT JOIN libros l ON l.id = e.libro_id
GROUP BY e.libro_id;

/*Cantidad de ejemplares disponibles por id*/

SELECT 
	count(e.id) - count(a.ejemplar_id) as disponibles
FROM ejemplares e
LEFT JOIN (
	SELECT 
		ejemplar_id 
	FROM prestamos WHERE fecha_devolucion IS NULL
    )AS a 
ON e.id = a.ejemplar_id
WHERE e.libro_id = 1;

/*Lista de ejemplares disponibles segun id de libro*/

SELECT e.id from ejemplares e 
WHERE e.id
NOT IN (
	SELECT 
		p.ejemplar_id 
	FROM prestamos p WHERE p.fecha_devolucion IS NULL
) AND e.libro_id = 1;


/*--------------------Prestamos--------------------------*/

