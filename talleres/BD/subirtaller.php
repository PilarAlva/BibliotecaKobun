<!-- este se encarga de la lógica para subir los talleres a la base de datos. recibe los datos del form de talleres.php y los envia a las tablas correspondientes. -->

<?php
session_start();
include ('conexion.php');

if($_SERVER['REQUEST_METHOD']=='POST'){

$nombretaller= $_POST['nombretaller'];
$descripcion= $_POST['descripcion'];
$profesorid= $_POST['profesor'];
$lugar= $_POST['lugar'];


$hora_inicio= $_POST['hora_inicio'];
$hora_fin= $_POST['hora_fin'];

if (!$hora_inicio || !$hora_fin) {
    echo "Debes completar ambas horas";
    exit();
}


$horario = $hora_inicio . ' - ' . $hora_fin;


$stmt = $conn->prepare("INSERT INTO talleres(nombre,descripcion,lugar,horario) VALUES(?,?,?,?)");
$stmt->bind_param("ssss", $nombretaller,$descripcion,$lugar,$horario);
if($stmt->execute()){
    echo "salio bien";
}else{
    echo "salio mal";
}


$checkid = $conn->query("SELECT MAX(id) FROM talleres");

if($checkid->num_rows == 0){
    echo "no hay talleres";
    exit();
}

$row = $checkid->fetch_assoc();
$ultima_id = $row['MAX(id)'];

$stmt = $conn->prepare("INSERT INTO talleres_profesores(taller_id,usuario_id) VALUES(?,?)");
$stmt->bind_param("ii",$ultima_id,$profesorid);
$stmt->execute();


}

?>