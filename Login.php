<?php
require "vendor/autoload.php";
include_once "utils/headers.php";
use DBC\Conexion as dbc;
use AUTH\Auth as token;

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

@$Email = $request-> Mail;
@$Password = $request-> Password;

if($Email != '' && $Password != ''){
    $query = " select * from public.tbl_user where mail= '$Email'";
    $result = dbc::Query($query);
    echo json_encode($result);
    if ($result[0] == 'empty'){
        echo json_encode('Usuario incorrecto');
    }else{
        if(password_verify($Password, $result[0]['password'])) {
            $tokenData = [
                'id' => $result[0]['id'],
                'name' => $result[0]['name'],
            ];
            $token = Token::TokenGenerate($tokenData);
            $data=['success' => 1, 'token' => $token, 'id' => $result[0]['id']];
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode('Error de contraseña');
        }
    }
}else{
    echo json_encode('Llena todos los campos');
}
