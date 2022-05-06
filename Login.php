<?php
require "vendor/autoload.php";
include_once "utils/headers.php";
use DBC\Conexion as dbc;
use AUTH\Auth as token;

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

@$Correo = $request-> email;
@$Contrasena = $request-> password;

if($Correo != '' && $Contrasena != ''){
    $query = " select * from usuario where correo= '".$Correo."'";
    $result = dbc::Query($query);
//   echo json_encode($result);
    if ($result[0] == 'empty'){
        echo json_encode('Usuario incorrecto');
    }else{
        if(password_verify($Contrasena, $result[0]['Contrasena'])) {
            $tokenData = [
                'id' => $result[0]['Id'],
                'name' => $result[0]['Nombre'],
            ];
            $token = Token::TokenGenerate($tokenData);
            $data=['success' => 1, 'token' => $token, 'id' => $result[0]['Id']];
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode('Error de contraseña');
        }
    }
}else{
    echo json_encode('Llena todos los campos');
}
