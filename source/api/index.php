<?php

require_once __DIR__.'/loader.php';

/**
 * Path Parts:
 * 
 * When user specifies the path as something like:
 *  POST http://localhost/api/items/4/image
 * the following piece of code work as below:
 * 
 * $pathparts will be an arrya of : array('items', '1', 'image')
 * where:
 * items: is the `resource`
 * 1: is the `id`
 * image: is `subresource`
 * POST: is the `method`
 * 
 */

$baseURL = strtok($_SERVER["REQUEST_URI"],'?');

$api = strtok($baseURL, '/');
$resource = strtok('/');
$id = strtok('/');
$subresource = strtok('/');

$method = $_SERVER['REQUEST_METHOD'];
$requestBody = file_get_contents('php://input');
$requestJSON = json_decode($requestBody);

//
// Database Connection
//
$mysqli = new mysqli('mysql', 'root', 'root', 'CCE_PHPMySQL2', '3306');
if ($mysqli->connect_errno) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}



// header("Content-Type: application/json");

try {
    switch ($resource) {
        case 'items':
            $model = new ItemModel($mysqli);
            $view = new ItemView($model);
            $controller = new ItemController($model);
            
            if ($method == 'POST' && !empty($id) && $subresource == 'image') {
                $controller->upload($id, $_FILES['new_item_image']);

            } elseif ($method == 'POST') {
                $controller->create($requestJSON);

            } elseif ($method == 'GET' && !empty($id)) {
                $controller->getOne($id);

            } elseif ($method == 'GET') {
                $controller->getAll();

            } elseif ($method == 'PUT' && !empty($id)) {
                $controller->update($id, $requestJSON);

            } elseif ($method == 'DELETE' && !empty($id)) {
                // $controller->delete($id);
                // TODO: Remove this after implementing it
                throw new Exception('Handler for DELETE method has NOT been implemented yet!', 501); // 501: Not Implemented!
            }
        
            echo $view->output();
            break;
    
        case 'categories':
            $model = new CategoryModel($mysqli);
            $controller = new CategoryController($model);


            if ($method == 'POST' && !empty($id) && $subresource == 'image') {
                $data=$controller->upload($id, $_FILES['new_category_image']);

            } elseif ($method == 'POST') {
               $data= $controller->create($requestJSON);
               var_dump($data);
            } elseif ($method == 'GET' && !empty($id)) {
                $data = $controller->getOne($id);

            } elseif ($method == 'GET') {
                $data= $controller->getAll();
                
            } elseif ($method == 'PUT' && !empty($id)) {
                $data=$controller->update($id, $requestJSON);

            } elseif ($method == 'DELETE' && !empty($id)) {
                // $controller->delete($id);
                // TODO: Remove this after implementing it
                throw new Exception('Handler for DELETE method has NOT been implemented yet!', 501); // 501: Not Implemented!
            }
        


/*  from origine code
            if ($method == 'GET' && empty($id)) {
                $data = $controller->getAll();
            }
  */  
            echo json_encode($data, JSON_PRETTY_PRINT);
            break;

        default:
            break;
    }

} catch (Exception $e) {

    http_response_code($e->getCode());
    echo $e->getMessage();
}