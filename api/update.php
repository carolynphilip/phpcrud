<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
    include_once '../configs/database.php';
    include_once '../classes/employees.php';
     
    $database = new Database();
    $db = $database->getConnection();
     
    $item = new Employee($db);
     
    $data = json_decode(file_get_contents("php://input"));
 
    $item->id = $data->id;
     
    // employee values
    $item->name = $data->name;
    $item->email = $data->email;
    $item->age = $data->age;
    $item->designation = $data->designation;
    $item->created = date('Y-m-d H:i:s');
     
    if($item->updateEmployee()){
        echo json_encode("Employee data is updated.");
    } else{
        echo json_encode("Employee data could not be updated");
    }
?>
