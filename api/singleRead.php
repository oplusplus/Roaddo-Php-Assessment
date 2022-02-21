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
    $item->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();
  
    $item->getSingleUser();
    if($item){

        $user_arr = array(
            "user_id" =>  $item->user_id,
            "user_name" => $item->user_name,
            "user_phone" => $item->user_phone,
            "user_status" => $item->user_status,
        );
      
        http_response_code(200);
        echo json_encode($user_arr);
    }else{
        http_response_code(404);
        echo json_encode("User not found.");
    }
?>