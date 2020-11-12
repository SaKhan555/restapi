<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset = UTF-8");
header("Access-Control-Allow-Methods: POST");

require '../config/Database.php';
require '../classes/Student.php';

$db = new Database();
$connection = $db->connect();
$student = new Student($connection);
if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $data = json_decode(file_get_contents('php://input'));
    if(!empty( $data->name) && !empty($data->email) && !empty($data->mobile)) {
        $student->name = $data->name;
        $student->email = $data->email;
        $student->mobile = $data->mobile;
        if ( $student->createStudent() ) {
            http_response_code(200);
            echo json_encode([
                "status" => 1,
                "message" => 'Student ' . $student->name . ' has been created.',
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "status" => 0,
                "message" => 'Failed to create student.',
            ]);
        }
    }
    else
    {
        http_response_code(404);
        echo json_encode([
            "status" => 0,
            "message" => 'Failed to create student values are missing.',
        ]);
    }
}
else
{
    http_response_code(503);
    echo json_encode([
        "status" => 0,
        "message" => 'Access denied.',
    ]);
}
