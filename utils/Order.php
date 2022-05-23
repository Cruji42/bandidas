<?php
namespace ORD;
//This document contains the functions that can be used in the class (CRUD)
include_once ("headers.php");
use DBC\Conexion as dbc;
include_once 'conexion.php';

class Order {

    public static function add($Product){


        $Client_id = $Product['user_id'];
        $Items = json_encode($Product['order']);
        
        $query = 'SELECT create_order('.$Client_id.', \' '.$Items.'\')';
        $response = dbc::Insert($query);
        return $response;
    }

    public static function get(){
        $query = "SELECT * FROM tbl_order";
        $response = dbc::Query($query);
        return $response;
    }

    public static function getSingle($param){
        $id = $param;
        $query = "select * from tbl_order where id ='$id'";
        $response = dbc::Query($query);
        return $response;
    }
    public static function delete($param){
        $id = $param;
        $query = "call eliminarOrden('$id')";
        dbc::Insert($query);
        return "ok";
    }

    public static function update($Product){


        $Cliente = $Product['ClienteId'];
        $Fecha = date_format(date_create($Product['FechaEntrega']), "Y-m-d H:i:s");
        $Cantidad = $Product['ProductoCant'];
        $Importe = $Product['ProductImporte'];
        $Decoracion = $Product['ProductoDecoracion'];
        $Tamano = $Product['ProductoTamano'];
        $Sabor = $Product['ProductoSabor'];
        $Relleno = $Product['ProductoRelleno'];
        $Extra = $Product['ProductoExtra'];


        $query = "CALL Crear_Orden('$Fecha', '$Cliente', '$Cantidad', '$Importe', '$Decoracion', '$Tamano', '$Sabor', '$Relleno', '$Extra')";
        $query = "UPDATE orden set FechaEntrega = '$Fecha',  ";
        $response = dbc::Insert($query);
        return $response;
    }

}