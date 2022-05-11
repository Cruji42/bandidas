<?php

namespace DBC;
class Conexion
{
    public static function DB_Conect(){
    
    //Local Enviroment
     $servername = 'localhost';
     $port = '5433';
     $username = 'postgres';
     $password = 'Mr.cruji42';
     $dbName = 'db_bandidas';
    

    /*
    //Production 
    $servername = 'ec2-18-214-134-226.compute-1.amazonaws.com';
    $port = '5432';
    $username = 'hhgxtnvfxdzgps';
    $password = '87a7ce60332c880facc0cbd773cf4fa4bec48e6e21b9dbc39d5fe83f941d1a9f';
    $dbName = 'd4qdb84j4sgs6o';
    */

     $conn = pg_connect("host=$servername port=$port dbname=$dbName user=$username password=$password");
     return $conn;
    }

/*    public static function Query2($query){
        $resultado = mysqli_query(self::DB_Conect(), $query);
//        $data = mysqli_fetch_object($resultado);
          $data = mysqli_fetch_assoc($resultado);
        return $data;
    }*/

    public static function Insert($query){
        $conexion = self::DB_Conect();
        if ($conexion){
            //mysqli_set_charset($conexion,"utf8");
            if (! $result = pg_query($conexion, $query)) die(json_encode('DB query Error'));
            return 'success';
        }else{
            die('DB connection error');
        }
    }

    //Usefull with Login
    public static function Query($query){
        $conexion = self::DB_Conect();
        if ($conexion){
            //mysqli_set_charset($conexion,"utf8");
            if (! $result = pg_query($conexion, $query)) die();
            while($data = pg_fetch_assoc($result)){
                $arreglo[] = $data;
//                $arreglo[0] = $data;
            }
            return $arreglo;

        }else{
            die(error);
        }
    }

}