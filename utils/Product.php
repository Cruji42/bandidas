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

        $query = "INSERT INTO public.tbl_product( name, description,image, price) VALUES ($Name, $Description, $Image, $Price)";
        $response = dbc::Insert($query);
        return $response;
    }

    public static function getProducts(){
        $query = "SELECT * FROM public.tbl_product";
        $response = dbc::Query($query);
        return $response;
    }

    public static function getSingleProduct($param){
        $id = $param;
        $query = "Select * from public.tbl_product where id = $id";
        $response = dbc::Query($query);
        return $response;
    }
    public static function deleteUser($param){
        $id = $param;
        $query = "Delete from public.tbl_product where id = $id";
        $response = dbc::Query($query);
        return $response;
    }

}