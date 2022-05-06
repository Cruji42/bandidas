<?php
namespace Controller;
use USR\User;
include_once 'User.php';

class UserController {
    public function processRequest($requestMethod, $userId) {
        switch ($requestMethod) {
//        already working
            case 'GET':
                if ($userId != null) {
                    $response = $this->getUser($userId);
//                }elseif ($userEmail != null){
//                    $response = $this->passwordRecovery($userEmail);

            } else {
                    $response = $this->getAllUsers();
                };
                break;
//        already working
            case 'POST':
                if($userId != null){
                 $response = $this->getUser($userId);
                }else{
                    $response = $this->createUserFromRequest();
                }
                break;
            case 'PUT':
                $response = $this->updateUserFromRequest($userId);
                break;
//        already working
            case 'DELETE':
                $response = $this->deleteUser($userId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        echo json_encode($response);
    }

    public function getAllUsers()
    {
        $result = User::getUsers();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        $response['body']=$result;
        return $response;
    }

    public function getUser($id)
    {
        $result = User::getSingleUser($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        $response = $result;
        return $response;
    }
    public function passwordRecovery($email)
    {
        $result = User::getPassword($email);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response = $result;
        return $response;
    }
    public function deleteUser($id)
    {
        $result = User::deleteUser($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = $result;
        return $response;
    }

    public function createUserFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validatePerson($input)) {
            return $this->unprocessableEntityResponse();
        }
        $result = User::addUser($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $result;
        return $response;
    }

    private function validatePerson($input)
    {
        if ($input['Name'] != "" && $input['LastName'] != "" && $input['Telephone'] != "" && $input['Address'] != "" &&
        $input['City'] != "" && $input['Mail'] != "" && $input['Password'] != "" ) {
            return true;
        }
        return false;
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