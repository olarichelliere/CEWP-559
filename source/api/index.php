<?php

require_once __DIR__.'/loader.php';


$pathParts = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));
$resource =  $pathParts[1]; 
$id = $pathParts[2];

$method = $_SERVER['REQUEST_METHOD'];
$requestBody = json_decode(file_get_contents('php://input'));



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


 try{
     switch ($resource) {

       
        
        case 'items':
            $model = new ItemModel($mysqli);
            $view = new ItemView($model);
            $controller = new ItemController($model);


            if($method == 'POST'){
                $controller->create($requestBody);
            }elseif($method == 'PUT' && !empty($id)){
                $controller->update($id,$requestBody);
            }elseif($method == 'GET' && !empty($id)){
                $controller->getOne($id);
            }elseif($method == 'GET'){
                $controller->getAll();
            }

            echo $view->output();
            break;

        case 'categories':
            $model = new CategoryModel($mysqli);
            $view = new CategoryView($model);
            $controller = new CategoryController($model);

            break;


        default:
            break;
        }
     
            
}catch(Exception $e){
     http_response_code($e->getCode());
     echo  'Caught exception',$e->getMessage();
     
  
}

