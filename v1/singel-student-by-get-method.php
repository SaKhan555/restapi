<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require '../config/Database.php';
require '../classes/Student.php';

$db = new Database();
$connection = $db->connect();
$student = new Student($connection);
if($_SERVER['REQUEST_METHOD'] === "GET")
{
    $student_id = isset($_GET['id']) ? intval($_GET['id']) : '';
    if(!empty($student_id)) {
        $student->id = $student_id;
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
