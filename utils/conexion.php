<?php

namespace DBC;
class Conexion
{
    public static function DB_Conect(){
     $servername = 'localhost';
     $username = 'root';
     $password = '';
     $dbName = 'cars';
     return mysqli_connect($servername, $username, $password, $dbName);
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
            mysqli_set_charset($conexion,"utf8");
            if (! $result = mysqli_query($conexion, $query)) die(json_encode('DB query Error'));
            return 'success';
        }else{
            die('DB connection error');
        }
    }

    //Usefull with Login
    public static function Query($query){
        $conexion = self::DB_Conect();
        if ($conexion){
            $arreglo[] = "empty";
            mysqli_set_charset($conexion,"utf8");
            if (! $result = mysqli_query($conexion, $query)) die();
            while($data = mysqli_fetch_assoc($result)){
                $arreglo[] = $data;
//                $arreglo[0] = $data;
            }
            return $arreglo;

        }else{
            die(error);
        }
    }

}