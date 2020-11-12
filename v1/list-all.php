<?php
ini_set("display_errors", 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require '../config/Database.php';
require '../classes/Student.php';

$db = new Database();
$connection = $db->connect();
$student = new Student($connection);
if($_SERVER['REQUEST_METHOD'] === "GET")
{
    $data = $student->getAllStudents();
    if ($data->num_rows > 0)
    {
        $students['record'] = array();
        while ($row = $data->fetch_assoc())
        {
            array_push($students['record'], [
                "id" => $row['id'],
                "name" => $row['name'],
                "email" => $row['email'],
                "mobile" => $row['mobile'],
                "status" => $row['status'],
                "created_at" => date("d-m-Y h:i:sa", strtotime($row['created_at'])),
            ]);
        }
        http_response_code(200);
        echo json_encode([
            "status" => 1,
            "data" => $students['record'],
        ]);
    }
    else
    {
        http_response_code(404);
        echo json_encode([
            "status" => 0,
            "data" => 'data not found.',
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
