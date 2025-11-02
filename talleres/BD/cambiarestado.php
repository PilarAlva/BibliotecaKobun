<!-- Este archivo sirve para camibar el estado de los talleres, de activo a inactivo y vice versa. -->

<?php
include('conexion.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $taller_id = $_POST['taller_id'] ?? 0;
    $nuevo_estado = $_POST['nuevo_estado'] ?? 0;

    if($taller_id){
        $stmt = $conn->prepare("UPDATE talleres SET activo = ? WHERE id = ?");
        $stmt->bind_param("ii", $nuevo_estado, $taller_id);
        if($stmt->execute()){
            header("Location: ../talleres.php"); 
            exit();
        } else {
            echo "Error al actualizar el estado.";
        }
    }
}
?>