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
$dir = 'uploads\.';

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["image"]["name"]);
$extension = end($temp);
$filelocation = "";

if ((($_FILES["image"]["type"] == "image/gif")
    || ($_FILES["image"]["type"] == "image/jpeg")
    || ($_FILES["image"]["type"] == "image/jpg")
    || ($_FILES["image"]["type"] == "image/pjpeg")
    || ($_FILES["image"]["type"] == "image/x-png")
    || ($_FILES["image"]["type"] == "image/png"))
  && in_array($extension, $allowedExts)
) {

  if ($_FILES["image"]["error"] > 0) {
    echo "Error: " . $_FILES["image"]["error"] . "<br>";
  } else {

    //Move the file to the uploads folder
    move_uploaded_file($_FILES["image"]["tmp_name"], $dir . $_FILES["image"]["name"]);

    //Get the File Location
    $filelocation = 'http://yourdomain.com/uploads/' . $_FILES["image"]["name"];

    //Get the File Size
    $size = ($_FILES["image"]["size"] / 1024) . ' kB';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // The request is using the POST method
      $upload_arr = array(
        "image_path" => $filelocation,
        "image_size" => $size
      );
      //Save to your Database
      $sqlQuery = "INSERT INTO images SET path = '" . $filelocation . "', size = '" . $size . "'";

      $db->query($sqlQuery);

      if ($db->affected_rows > 0) {
        http_response_code(201);
        echo json_encode($upload_arr);
        return $upload_arr;
      } else {
        http_response_code(404);
        $message = 'Employee could not be created';
        $response = array(
          "message" => $message
        );
        echo json_encode($response);
        return false;
      }
    } else {
      http_response_code(405);
      $message = "Method Not Allowed";
      $response = array(
        "message" => $message
      );

      echo json_encode($response);
    }
  }
} else {
  //File type was invalid, so throw up a red flag!
  echo "Invalid File Type";
}
