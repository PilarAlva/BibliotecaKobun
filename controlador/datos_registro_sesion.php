<?php 
session_start();
include("../bd/conexion.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $action = $_POST['action'];
    $msg = 1; /* $msg = "Ha ocurrido un error."; */


    if ($action == 'login') {
        $mail = trim($_POST['mail']);
        $contraseña = trim($_POST['contraseña']);

        if (empty($mail) || empty($contraseña)) {
            $msg = 2; /* $msg = "Todos los campos son obligatorios."; */
        } else {
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                if (password_verify($contraseña, $row['clave'])) {
                    $_SESSION['usuarios'] = $mail;
                    $_SESSION['nombre'] = $row['nombre'];
                    $_SESSION['apellido'] = $row['apellido'];
                    $_SESSION['img_perfil'] = $row['img_perfil'];
                    $_SESSION['usuario_id'] = $row['id'];
                    header("Location: ../index.php");
                    $error = false;
                    exit;
                } else {
                    $msg = 1; /* $msg = "Ha ocurrido un error (2)."; */
                } 
            } else {
                $msg = 3; /* $msg = "El usuario no existe. Por favor regístrate."; */
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


        if ($check->num_rows > 0) {
            $msg = 4; /* $msg = "El usuario ya existe. Por favor inicie sesión."; */
        } else {
            $insertar = $conn->prepare("INSERT INTO usuarios (nombre, apellido, clave, mail) VALUES (?, ?, ?, ?)");
            $insertar->bind_param("ssss",$nombre,$apellido,$contraseña,$mail);
            if ($insertar->execute()) {
                $msg = 5; /* $msg = "Registro exitoso. Ahora puede iniciar sesión."; */
            } else {
                $msg = 1; /* $msg = "Ha ocurrido un error (3)."; */
            }
        }
    }
}

$_SESSION['msg'] = $msg;
header("Location: ../sesion.php");
exit;
?>