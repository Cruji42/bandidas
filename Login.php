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
    if (count($result) == 0){
        $data=['success' => 0, 'message' => "Usuario Incorrecto"];
        echo json_encode($data);
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
            $data=['success' => 0, 'message' => "Contraseña Incorrecta"];
            echo json_encode($data);
        }
    }
}else{
    $data=['success' => 0, 'message' => "LLena todos los campos"];
    echo json_encode($data);
}
