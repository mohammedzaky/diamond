<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../database.php';
include_once '../employees.php';
$database = new Database();
$db = $database->getConnection();
$item = new Employee($db);

$item->id = isset($_GET['id']) ? $_GET['id'] : die();

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
if ($item->deleteEmployee()) {
    http_response_code(201);
    $message = "Employee deleted";
    $response = array (
        "message" => $message
    );
    echo json_encode($response);
} else {
    http_response_code(404);
    $message = "Data could not be deleted";
    $response = array (
        "message" => $message
    );
    echo json_encode($response);
}
}else{
    http_response_code(405);
    $message = "Method Not Allowed";
    $response = array (
        "message" => $message
    );
    
    echo json_encode($response);
}
