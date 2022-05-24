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
        $query = "SELECT t2.name, t3.code, t3.status, t1.amount, (t1.amount * t2.price) as subtotal, t1.comment
         FROM order_products as t1 join tbl_product as t2 on t1.product_id = t2.id join tbl_order as t3 on t1.order_id = 
         t3.id ORDER by t3.code";
        $response = dbc::Query($query);
        return $response;
    }

    public static function getSingle($param){
        $id = $param;
        $query = "SELECT t2.name, t3.code, t3.status, t1.amount, (t1.amount * t2.price) as subtotal, t1.comment
         FROM order_products as t1 join tbl_product as t2 on t1.product_id = t2.id join tbl_order as t3 on t1.order_id 
         = t3.id where t3.id ='$id' ";
        $response = dbc::Query($query);
        return $response;
    }
    public static function delete($param){
        $id = $param;
        $query = "DELETE FROM order_products CASCADE where order_id='$id'";
        dbc::Insert($query);
        $query = "DELETE FROM tbl_order where id='$id'";
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