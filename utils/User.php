<?php
namespace USR;
//This document contains the functions that can be used in the class (CRUD)
include_once ("headers.php");
use DBC\Conexion as dbc;
include_once 'conexion.php';

/*require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include_once ('../vendor/autoload.php');*/


class User {

    public static function addUser($User){
        $Name = $User['Name'];
        $LastName = $User['LastName'];
        $Telephone = $User['Telephone'];
        $Address = $User['Address'];
        $City = $User['City'];
        $Mail = $User['Mail'];
        $PasswordEn = password_hash($User['Password'], PASSWORD_DEFAULT, ['cost' => 5]);
        $query = "
        INSERT INTO public.tbl_user(name, last_name, phone, address, city, mail, password)
        	VALUES ('$Name', '$LastName', $Telephone, '$Address', '$City', '$Mail', '$PasswordEn')";
        $response = dbc::Insert($query);
        return $response;
    }

    public static function getUsers(){
        $query = "SELECT * FROM public.tbl_user";
        $response = dbc::Query($query);
        return $response;
    }

    public static function getSingleUser($param){
        $id = $param;
        $query = "Select * from public.tbl_user where Id = $id";
        $response = dbc::Query($query);
        return $response;
    }

   /* public static function getPassword($param){
        $mailer = new PHPMailer(true);
        $email = $param;
        $query = "Select * from usuario where correo = $email";
        $response = dbc::Query($query);
        if($response){
            $password=rand();
            $passwordEncrypted = password_hash($password,PASSWORD_DEFAULT, ['cost'=> 10]);
            $query = "UPDATE usuario SET contrasena = '$passwordEncrypted' WHERE correo='$email'";
            dbc::Query($query);

            try{
                //Server settings
                #$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mailer->isSMTP();                                            // Send using SMTP
                $mailer->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mailer->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mailer->Username   = 'pasterlerialainne@gmail.com';                     // SMTP username
                $mailer->Password   = 'Mr.cruji42';                               // SMTP password
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mailer->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                $mailer->SMTPAutoTLS = true;

                //Recipients
                $mailer->setFrom('from@example.com', 'Pasteleria LAINNE');
                $mailer->addAddress($email, '');     // Add a recipient
                #$mail->addAddress('ellen@example.com');               // Name is optional
                #$mail->addReplyTo('info@example.com', 'Information');
                #$mail->addCC('cc@example.com');
                #$mail->addBCC('bcc@example.com');

                // Attachments
                #$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                #$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mailer->isHTML(true);                                  // Set email format to HTML
                $mailer->CharSet = 'UTF-8';
                $mailer->Subject = 'Recuperación de Contraseña';
                $mailer->Body    = 'Cambio de contraseña para la cuenta viculada con el correo: <b>'.$email.'</b><br>Password: '.$password.'
    <br>'.$query;
                #$mail->AltBody = ;

                $mailer->send();
                $response=['success'=>1];
                #echo 'Message has been sent';
            }catch (Exception $e){

            }
        }

        return $response;
    }*/

    public static function deleteUser($param){
        $id = $param;
        $query = "Delete from public.tbl_user where Id = $id";
        $response = dbc::Query($query);
        return $response;
    }

}