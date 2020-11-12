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
    $parameter = json_decode(file_get_contents('php://input'));
    if(!empty( $parameter->id)) {
        $student->id = $parameter->id;
        $student_data = $student->getStudent();
        if (!empty( $student_data)) {
            http_response_code(200);
            echo json_encode([
                "status" => 1,
                "data" => $student_data,
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "status" => 0,
                "message" => 'Student record not found.',
            ]);
        }
    }
    else
    {
        http_response_code(404);
        echo json_encode([
            "status" => 0,
            "message" => 'id is missing.',
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
