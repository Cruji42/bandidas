<?php
namespace PController;
use PDT\Product;
include_once 'Product.php';

class ProductController {
    public function processRequest($requestMethod, $productId) {
        switch ($requestMethod) {
//        already working
            case 'GET':
                if ($productId != null) {
                    $response = $this->getProduct($productId);
                } else {
                    $response = $this->getAllProducts();
                };
                break;
//        already working
            case 'POST':
                $response = $this->createProductFromRequest();
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
        $result = Product::deleteUser($id);
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
        $response['status_code_header'] = 'HTTP/1.1 201 Deleted';
        $response['body'] = null;
        return $response;
    }

    private function validateProduct($input)
    {
        if (! isset($input['Name']) || ! isset($input['Description']) || ! isset($input['Image']) ||
            ! isset($input['Price']) || ! isset($input['FlavorId']) || ! isset($input['SizeId']) || ! isset($input['FillId'])
            || ! isset($input['ConfigurationId']) || ! isset($input['ShapeId']) ) {
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