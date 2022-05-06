<?php
namespace PDT;
//This document contains the functions that can be used in the class (CRUD)
include_once ("headers.php");
use DBC\Conexion as dbc;
include_once 'conexion.php';
class Product {

    public static function addProduct($Product){
        $Name = $Product['Name'];
        $Description = $Product['Description'];
        $Image = $Product['Image'];
        $Price = $Product['Price'];
        $FlavorId = $Product['FlavorId'];
        $SizeId = $Product['SizeId'];
        $FillId = $Product['FillId'];
        $ConfigurationId = $Product['ConfigurationId'];
        $ShapeId = $Product['ShapeId'];

        $query = "CALL Agregar_Producto('$Name', '$Description', '$Image', '$Price', '$FlavorId', '$SizeId', '$FillId', '$ConfigurationId', '$ShapeId')";
        $response = dbc::Insert($query);
        return $response;
    }

    public static function getProducts(){
        $query = "SELECT * FROM products";
        $response = dbc::Query($query);
        return $response;
    }

    public static function getSingleProduct($param){
        $id = $param;
        $query = "Select * from products where id = $id";
        $response = dbc::Query($query);
        return $response;
    }
    public static function deleteUser($param){
        $id = $param;
        $query = "Delete from products where id = $id";
        $response = dbc::Query($query);
        return $response;
    }

}