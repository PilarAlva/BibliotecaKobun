
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Talleres disponibles</h1>

<?php include('BD/mostrartaller.php'); ?>


        <form id="subir" action="BD/subirtaller.php" method="post">
            <h2>Ingrese los datos del taller</h2>
            <input type="text" name="nombretaller" placeholder="Nombre del taller" required><br>
            <input type="text" name="descripcion" placeholder="Descripción del taller" required><br>
            <select name="lugar" required>
                <option value="">--Seleccione un lugar--</option>
                <option value="sala roja">Sala Roja</option><br>
                <option value="sala azul">Sala Azul</option><br>
                <option value="sala violeta">Sala Violeta</option><br>

            </select><br>

            <select name="profesor" required>
                <option value="">--Seleccione un profesor--</option>

                    <?php
                        include('BD/conexion.php'); 

                        $result = $conn->query("SELECT id, nombre FROM usuarios WHERE rol_id = 2 ORDER BY nombre");
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="'.$row['id'].'">'.$row['id'].' - '.$row['nombre'].'</option>';
                            }

                        $conn->close();
                    ?>
                    
            </select><br>
            
            <label for="horario">Horario de inicio:</label><br>"></label>
            <input type="time" name="hora_inicio" placeholder="HH-MM" required><br>

            <label for="horario">Horario de finalización</label><br>"></label>
            <input type="time" name="hora_fin" placeholder="HH-MM" required><br>
            

            <button type="submit">Crear</button>
        </form>

        

</body>
</html>