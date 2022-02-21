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

    if($_POST){
        $item->user_name = $_POST['user_name'];
        $item->user_phone = $_POST['user_phone'];
        $item->user_status = $_POST['user_status'];
        $item->user_id = $_POST['user_id'];
    }else{
        $data = json_decode(file_get_contents("php://input"));
        $item->user_name = $data->user_name;
        $item->user_phone = $data->user_phone;
        $item->user_status = $data->user_status;
        $item->user_id = $data->user_id;
    }
    
    if($item->updateUsers()){
        echo json_encode("User data updated.");
    } else{
        echo json_encode("User Data could not be updated");
    }
?>