<?php
require 'bd/database.php';
$db = new Database();
$con = $db->conectar();


$registrosPorPagina = 20; 
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($paginaActual < 1) $paginaActual = 1;
$offset = ($paginaActual - 1) * $registrosPorPagina;


$buscar = isset($_GET['q']) ? $_GET['q'] : '';
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'titulo';


$sqlCountStr = "
    SELECT COUNT(DISTINCT m.id) AS total
    FROM material m
    LEFT JOIN material_autor ma ON m.id = ma.id_material
    LEFT JOIN autor a ON ma.id_autor = a.id
    LEFT JOIN material_genero mg ON m.id = mg.id_material
    LEFT JOIN genero g ON mg.id_genero = g.id
    WHERE m.activo = 1
";

if ($buscar != '') {
    switch ($filtro) {
        case 'autor':
            $sqlCountStr .= " AND EXISTS (
                                SELECT 1 
                                FROM material_autor ma2 
                                INNER JOIN autor a2 ON ma2.id_autor = a2.id 
                                WHERE ma2.id_material = m.id 
                                  AND a2.nombre LIKE :buscar
                              )";
            break;
        case 'genero':
            $sqlCountStr .= " AND EXISTS (
                                SELECT 1 
                                FROM material_genero mg2 
                                INNER JOIN genero g2 ON mg2.id_genero = g2.id 
                                WHERE mg2.id_material = m.id 
                                  AND g2.nombre LIKE :buscar
                              )";
            break;
        case 'contenido':
            $sqlCountStr .= " AND m.contenido LIKE :buscar";
            break;
        case 'titulo':
        default:
            $sqlCountStr .= " AND m.nombre LIKE :buscar";
            break;
    }
}

$sqlCount = $con->prepare($sqlCountStr);
if ($buscar != '') {
    $sqlCount->bindValue(':buscar', "%$buscar%");
}
$sqlCount->execute();
$totalRegistros = $sqlCount->fetchColumn();
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);


$sqlStr = "
    SELECT 
        m.id,
        m.nombre,
        m.contenido,
        GROUP_CONCAT(DISTINCT a.nombre SEPARATOR ', ') AS autores,
        GROUP_CONCAT(DISTINCT g.nombre SEPARATOR ', ') AS generos
    FROM material m
    LEFT JOIN material_autor ma ON m.id = ma.id_material
    LEFT JOIN autor a ON ma.id_autor = a.id
    LEFT JOIN material_genero mg ON m.id = mg.id_material
    LEFT JOIN genero g ON mg.id_genero = g.id
    WHERE m.activo = 1
";

if ($buscar != '') {
    switch ($filtro) {
        case 'autor':
            $sqlStr .= " AND EXISTS (
                            SELECT 1 
                            FROM material_autor ma2 
                            INNER JOIN autor a2 ON ma2.id_autor = a2.id 
                            WHERE ma2.id_material = m.id 
                              AND a2.nombre LIKE :buscar
                          )";
            break;
        case 'genero':
            $sqlStr .= " AND EXISTS (
                            SELECT 1 
                            FROM material_genero mg2 
                            INNER JOIN genero g2 ON mg2.id_genero = g2.id 
                            WHERE mg2.id_material = m.id 
                              AND g2.nombre LIKE :buscar
                          )";
            break;
        case 'contenido':
            $sqlStr .= " AND m.contenido LIKE :buscar";
            break;
        case 'titulo':
        default:
            $sqlStr .= " AND m.nombre LIKE :buscar";
            break;
    }
}

$sqlStr .= " GROUP BY m.id ORDER BY m.id ASC LIMIT :limite OFFSET :offset";
$sql = $con->prepare($sqlStr);

if ($buscar != '') {
    $sql->bindValue(':buscar', "%$buscar%", PDO::PARAM_STR);
}
$sql->bindValue(':limite', $registrosPorPagina, PDO::PARAM_INT);
$sql->bindValue(':offset', $offset, PDO::PARAM_INT);

$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiales</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
</head>
<body>
    <header>
        <div>
            <a href="index.php">
                <img src="img/logo.svg" alt="logo" width="150">
            </a>      
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#">Catálogo</a></li>
                <li><a href="#">Talleres</a></li>
                <li><a href="#">Contacto</a></li>
                <li class="no-underline"><a href="#" class="btn-acceso">Acceso</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <div class="row justify-content-center my-5">
            <div class="col">
                <form action="#" method="get" class="d-flex">
                    <select name="filtro" class="form-select w-25 me-2 selector">
                        <option value="titulo" <?php if($filtro=='titulo') echo 'selected'; ?>>Título</option>
                        <option value="autor" <?php if($filtro=='autor') echo 'selected'; ?>>Autor</option>
                        <option value="genero" <?php if($filtro=='genero') echo 'selected'; ?>>Género</option>
                        <option value="contenido" <?php if($filtro=='contenido') echo 'selected'; ?>>Contenido</option>
                    </select>
                    <input type="text" name="q" class="form-control me-2 search-input" placeholder="Buscar..." value="<?php echo htmlspecialchars($buscar); ?>">
                    <button type="submit" class="btn btn-primary rounded-circle boton-busqueda"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
       
        <div class="my-5">
            <h3>Resultados de búsqueda</h3>
            <p>Cantidad de Resultados <?php echo $totalRegistros ?></p>
        </div>

        <div class="row">
            <table class="table table-striped">
    <tbody>
        <?php foreach ($resultado as $indice => $row) { ?>
            <tr>
              
                <td></td>

                <td><?php echo $offset + $indice + 1;?>.</td>

                
                <td style="width: 0">
                    <img src="img/no.png" alt="no" height="200">
                </td>

                
                <td>
                    <div class="libro">
                        <div>
                            <h5><a href=""><?php echo htmlspecialchars($row['nombre']); ?></a></h5>
                            <p style="margin: 0; padding: 0;">Por <?php echo htmlspecialchars($row['autores']); ?></p>
                            <p><?php echo htmlspecialchars($row['contenido']); ?></p>

                            <div class="my-2">
                                <small>Disponibilidad: </small>
                                <small style="color: green">Items Disponibles</small>
                            </div>
                        </div>
                        

                        <div>
                        <?php 
                        if (!empty($row['generos'])) {
                        $generosArray = explode(',', $row['generos']);
                        foreach ($generosArray as $genero) {
                            $genero = trim($genero);
                            if ($genero === '') continue;
                            $safeText = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
                            $safeUrl  = rawurlencode($genero);
                            echo '<a class="btn btn-sm btn-outline-secondary rounded-pill me-2" href="index.php?filtro=genero&q=' . $safeUrl . '#">' . $safeText . '</a>';
                            }
                        }
                        ?>
                        </div>
                    </div>
                    
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<nav aria-label="Paginación">
    <ul class="pagination justify-content-center">
        <!-- Página anterior -->
        <li class="page-item <?php if($paginaActual <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?filtro=<?php echo $filtro; ?>&q=<?php echo urlencode($buscar); ?>&pagina=<?php echo $paginaActual-1; ?>">Anterior</a>
        </li>

        <!-- Números de página -->
        <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
            <li class="page-item <?php if($i == $paginaActual) echo 'active'; ?>">
                <a class="page-link" href="?filtro=<?php echo $filtro; ?>&q=<?php echo urlencode($buscar); ?>&pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <!-- Página siguiente -->
        <li class="page-item <?php if($paginaActual >= $totalPaginas) echo 'disabled'; ?>">
            <a class="page-link" href="?filtro=<?php echo $filtro; ?>&q=<?php echo urlencode($buscar); ?>&pagina=<?php echo $paginaActual+1; ?>">Siguiente</a>
        </li>
    </ul>
</nav>
        </div>

       
    </main>

    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
        crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/fe0bc071f5.js" crossorigin="anonymous"></script>
</body>
</html>