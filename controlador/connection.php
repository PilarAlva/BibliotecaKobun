<?php 

$host='localhost';
$user='root';
$pass='';
$db='lojin';

$conn= new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    echo "fallo la conexión";
    die("Error de conexión: " . $conn->connect_error);
}
?>