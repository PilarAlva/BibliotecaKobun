<?php 
session_start();
include("conexion.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $msg = "salio todo mal";


    if ($action == 'login') {
        $mail = trim($_POST['mail']);
        $contraseña = trim($_POST['clave']);

        if (empty($mail) || empty($contraseña)) {
            $msg = "Todos los campos son obligatorios.";
        } else {
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if (password_verify($contraseña, $row['clave'])) {
                    $_SESSION['usuarios'] = $mail;
                    $_SESSION['msg'] = "Login exitoso";
                    header("Location: ../index.php");
                    exit;
                } else {
                    $msg = "nada";
                }
            } else {
                $msg = "El usuario no existe.";
            }
        }
    }

    if ($action == 'registro') {
        $nombre= trim($_POST['nombre']);
        $apellido=trim($_POST['apellido']);
        $contraseña= password_hash(trim($_POST['contraseña']), PASSWORD_DEFAULT);
        $mail=trim($_POST['mail']);

        $check = $conn->prepare("SELECT id FROM usuarios WHERE mail = ?");
        $check->bind_param("s", $mail);
        $check->execute();
        $check->store_result();


        if($check->num_rows >0){
            $msg = "El usuario ya existe.";
        }else{
            $insertar = $conn->prepare("INSERT INTO usuarios (nombre, apellido, clave, mail) VALUES (?, ?, ?, ?)");
            $insertar->bind_param("ssss",$nombre,$apellido,$contraseña,$mail);
            if ($insertar->execute()) {
                $msg = "Registro exitoso. Ahora puedes iniciar sesión.";
            } else {
                $msg = "Error al registrar.";
            }
        }
    }
}

$_SESSION['msg'] = $msg;
header("Location: ../sesion.php");
exit;
?>