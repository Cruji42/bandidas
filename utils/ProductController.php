<?php
namespace PController;
use PD\Product;
include_once 'Product.php';

class ProductController {
    public function processRequest($requestMethod, $productId, $promotion) {
        switch ($requestMethod) {
//        already working
            case 'GET':
                if ($productId != null) {
                    $response = $this->getProduct($productId);
                } else {
                    $response = $this->getAllProducts();
                }
                break;
//        already working
            case 'POST':
                if($promotion  != null) {
                    $response = $this->getAllProductsPromotions();
                } else {
                    $response = $this->createProductFromRequest();
                }
                break;
            case 'PUT':
                $response = $this->updateUserFromRequest($productId);
                break;
//        already working
            case 'DELETE':
                $response = $this->deleteProduct($productId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        echo json_encode($response);
    }

    public function getAllProducts()
    {
        $result = Product::getProducts();
//        $response['status_code_header'] = 'HTTP/1.1 200 OK';
//        $response['body'] = json_encode($result);
        $response=$result;
        return $response;
    }


    public function getAllProductsPromotions()
    {
        $result = Product::getProductsPromotions();
//        $response['status_code_header'] = 'HTTP/1.1 200 OK';
//        $response['body'] = json_encode($result);
        $response=$result;
        return $response;
    }

    public function getProduct($id)
    {
        $result = Product::getSingleProduct($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }
    public function deleteProduct($id)
    {
        $result = Product::deleteProduct($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }

    public function createProductFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateProduct($input)) {
            return $this->unprocessableEntityResponse();
        }
        Product::addProduct($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Product Created';
        $response['body'] = null;
        return $response;
    }

    private function validateProduct($input)
    {
        if (! isset($input['Name']) || ! isset($input['Description']) || ! isset($input['Image']) ||
            ! isset($input['Price'])) {
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