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
$item->name = $_GET['name'];
$item->email = $_GET['email'];
$item->designation = $_GET['designation'];
$item->created = date('Y-m-d H:i:s');

$emp_arr = array(
    "name" => $item->name,
    "email" => $item->email,
    "designation" => $item->designation,
    "created" => $item->created
);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if ($item->updateEmployee()) {
        http_response_code(201);
        echo json_encode($emp_arr);
    } else {
        http_response_code(404);
        $message = 'Invalid ID or Something went wrong';
        $response = array (
            "message" => $message
        );
        echo json_encode($response);
    }
} else {
    http_response_code(405);
    $message = "Method Not Allowed";
    $response = array(
        "message" => $message
    );

    echo json_encode($response);
}
