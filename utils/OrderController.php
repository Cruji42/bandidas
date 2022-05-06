<?php
namespace ORDController;
use ORD\Order;
include_once 'Order.php';

class OrderController {
    public function processRequest($requestMethod, $Id, $id_order) {
        switch ($requestMethod) {
//        already working
            case 'GET':
                if ($Id != null) {
                    $response = $this->getOrders($Id);
                } else {
                    $response = $this->getAllOrders();
                };
                break;
//        already working
            case 'POST':
                if($Id != null){
                    $response = $this->getOrders($Id);
                } elseif($Id == null && $id_order ){
                    $response = $this->deleteOrders($id_order);
                }else{
                    $response = $this->createOrdersFromRequest();
                }
                break;
            case 'PUT':
                $response = $this->updateOrdersFromRequest($Id);
                break;
//        already working
            case 'DELETE':
                $response = $this->deleteOrders($Id);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        echo json_encode($response);
    }

    public function getAllOrders()
    {
        $result = Order::get();
//        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        $response['body']=$result;
        return $response;
    }

    public function getOrders($id)
    {
        $result = Order::getSingle($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
//        $response['status_code_header'] = 'HTTP/1.1 200 OK';
//        $response['body'] = $result;
        $response = $result;
        return $response;
    }
    public function deleteOrders($id)
    {
        $result = Order::delete($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 Deleted';
        $response['body'] = $result;
        return $response;
    }

    public function createOrdersFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateOrder($input)) {
            return $this->unprocessableEntityResponse();
        }
        $query = Order::add($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $query;
        return $response;
    }
    public function updateOrdersFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateOrder($input)) {
            return $this->unprocessableEntityResponse();
        }
        $query = Order::add($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Updated';
        $response['body'] = $query;
        return $response;
    }

    private function validateOrder($input)
    {
        if (! isset($input['FechaEntrega']) || ! isset($input['ClienteId']) ||
            ! isset($input['ProductoCant']) || ! isset($input['ProductImporte'])
            || ! isset($input['ProductoDecoracion']) || ! isset($input['ProductoTamano'])
            || ! isset($input['ProductoSabor']) || ! isset($input['ProductoRelleno'])
            || ! isset($input['ProductoExtra'])
        ) {
            return false;
        }
        return true;
    }


    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}