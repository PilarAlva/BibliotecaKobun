<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Libro</title>
    <link rel="stylesheet" href="detalle-libro.css">
</head>
<body>

    <main class="main-content">

        <section class="detalle-libro">

            <div class="portada">
                <img src="img/portada-ejemplo.png" alt="Portada del libro">
            </div>

            <div class="info-libro">
                <h1>Título Copadísimo</h1>

                <p><strong>Autor:</strong> Se la Sabe Toda</p>
                <p><strong>ISBN:</strong> xxx00xxx00</p>
                <p><strong>Género:</strong> Emoción :)</p>
                <p><strong>Disponibilidad:</strong> <span class="disponible">Items Disponibles</span></p>

                <button class="btn-prestamo">Pedir Préstamo</button>
            </div>

        </section>

        <section class="sinopsis">
            <h2>Sinopsis</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin rhoncus mauris ut tincidunt vulputate.
                Integer sed tellus at sem dictum auctor. Duis ac cursus diam. Nunc scelerisque diam ac purus viverra,
                quis fringilla turpis vehicula. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                posuere cubilia curae; Mauris in neque a ex consequat sagittis ac vel mi.
            </p>
        </section>

        <section class="existencias">
            <h2>Existencias (x)</h2>

            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Código Topográfico</th>
                        <th>Estado</th>
                        <th>Vencimiento</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="img/icono-libro.png" alt="icono libro"></td>
                        <td>AABB22</td>
                        <td class="disponible">Disponible</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><img src="img/icono-libro.png" alt="icono libro"></td>
                        <td>AABB22</td>
                        <td class="disponible">Disponible</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><img src="img/icono-libro.png" alt="icono libro"></td>
                        <td>AABB22</td>
                        <td>No disponible</td>
                        <td>30/11/2025</td>
                    </tr>
                    <tr>
                        <td><img src="img/icono-libro.png" alt="icono libro"></td>
                        <td>AABB22</td>
                        <td>No disponible</td>
                        <td>31/10/2018</td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>

</body>
</html>