<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
    include_once '../configs/database.php';
    include_once '../classes/employees.php';
     
    $database = new Database();
    $db = $database->getConnection();
     
    $item = new Employee($db);
 
    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
     echo "Employee ID = ". $item->id ;
    if($item->deleteEmployee()){
        echo json_encode("Employee deleted deleteui.");
    } else{
        echo json_encode("Data could not be deleted");
    }
?>
