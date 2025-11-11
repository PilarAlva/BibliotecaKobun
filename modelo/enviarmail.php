<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include ('BD/conexion.php');


$nombre = $_POST['nombre'];
$email = $_POST['email'];        
$tel = $_POST['tel'];
$mensaje = $_POST['mensaje'];

$stmt = $conn->prepare("INSERT INTO correos (nombre, email, telefono, consulta) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $email, $tel, $mensaje);
$stmt->execute();
$stmt->close();


$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'bibliotecakobun@gmail.com'; // tu Gmail
    $mail->Password   = 'akabutqdcvrpikwo';           // App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Remitente real (Gmail)
    $mail->setFrom('bibliotecakobun@gmail.com', 'Formulario Web');

    // Destinatario
    $mail->addAddress('bibliotecakobun@gmail.com'); 

    // Para que se pueda responder al usuario
    $mail->addReplyTo($email, $nombre);

    // Contenido del correo
    $mail->Subject = 'Nuevo mensaje desde el formulario';
    $mail->Body    = "Nombre: $nombre\nEmail: $email\nTeléfono: $tel\nComentarios:\n$comentarios";

    $mail->send();
    echo 'Correo enviado correctamente.';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}