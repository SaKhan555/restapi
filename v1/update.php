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
    if(!empty( $data->id )) {
        $student->id = $data->id;
        $get_student = $student->getStudent();
        $student->name = !empty( $data->name ) ? $data->name : $get_student['name'];
        $student->email = !empty( $data->email ) ? $data->email : $get_student['email'];
        $student->mobile = !empty( $data->mobile ) ? $data->mobile : $get_student['mobile'];
        if ( $student->updateStudent() ) {
            http_response_code(200);
            echo json_encode([
                "status" => 1,
                "message" => 'Student has been updated',
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "status" => 0,
                "message" => 'Failed to update student.',
            ]);
        }
    }
    else
    {
        http_response_code(404);
        echo json_encode([
            "status" => 0,
            "message" => 'Failed to update student values are missing.',
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
