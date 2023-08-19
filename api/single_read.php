<?php

header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Acess-Control-Allow-Method: POST");
header("Acess-Control-Max-Age: 3600");
header("Acess-Control_Allow-Headers: Content-Type, Acess-Control-Allow-Headers, Authorization, X-Request-With");

include_once '../Database.php';
include_once '../class/Employee.php';
include_once './envVariables.php';

$database = new Database($db_host, $db_username, $db_password, $db_dbName);
$db = $database->getConnection();

$employee = new Employee($db);
$employee->id = isset($_GET['id']) ? $_GET['id'] : die();

$employee->getSingleEmployee();
if ($employee->name != null) {
    $employeeArr = array(
        "id" => $employee->id,
        "name" => $employee->name,
        "email" => $employee->email,
        "age" => $employee->age,
        "designation" => $employee->designation,
        "created_at" => $employee->created_at
    );

    http_response_code(200);
    echo json_encode($employeeArr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Employee not found"));
}
