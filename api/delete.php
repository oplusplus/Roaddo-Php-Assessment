<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../db_connection.php';
    include_once '../class/user.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Users($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    if($_POST){
        $item->user_id = $_POST['user_id'];
    }else{
        $item->user_id = $data->user_id; 
    }
    
    if($item->deleteUser()){
        echo json_encode("Users deleted.");
    } else{
        echo json_encode("Data could not be deleted");
    }
?>