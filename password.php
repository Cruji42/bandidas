<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
require "vendor/autoload.php";
include_once "utils/headers.php";
use DBC\Conexion as dbc;

include_once ("utils/headers.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

$postdata = file_get_contents("php://input");
$post = json_decode($postdata);
@$usuario = $post->email;
$password = generateRandomString();

if($usuario != ''){
    $query = " select * from usuario where correo= '".$usuario."'";
    $result = dbc::Query($query);
//   echo json_encode($result);
    if ($result[0] == 'empty'){
        echo json_encode('Usuario no existe');
    }else{
        $encrypt = password_hash($password, PASSWORD_DEFAULT, ['cost' => 5]);
        dbc::insert("UPDATE usuario SET Contrasena = '$encrypt' where correo = '$usuario'");
        }
}else{
    echo json_encode('Llena todos los campos');
}

try {
    //Server settings
    #$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'pasterlerialainne@gmail.com';                     // SMTP username
    $mail->Password   = 'Mr.cruji42';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->SMTPAutoTLS = true;

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress($usuario, '');     // Add a recipient
    #$mail->addAddress('ellen@example.com');               // Name is optional
    #$mail->addReplyTo('info@example.com', 'Information');
    #$mail->addCC('cc@example.com');
    #$mail->addBCC('bcc@example.com');

    // Attachments
    #$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    #$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Recuperación de Contraseña';
    $mail->Body    = 'Hola se ha solicitado un cambio de contraseña de <b>'.$usuario.'</b><br>Password: '.$password.'
    <br>';
    #$mail->AltBody = ;

    $mail->send();
    $dataProvaider=['success'=>1];
    echo json_encode($dataProvaider, JSON_UNESCAPED_UNICODE);
    #echo 'Message has been sent';
} catch (Exception $e) {
    #$dataProvaider=['success'=>1];
    #echo json_encode($dataProvaider, JSON_UNESCAPED_UNICODE);
    #echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
