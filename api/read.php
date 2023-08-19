<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once('../Database.php');
include_once('../vendor/autoload.php');
include_once '../class/Employee.php';

$dotEnv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotEnv->safeLoad();
$db_host = $_ENV['DB_HOST'];
$db_username = $_ENV['DB_USER'];
$db_password = $_ENV['DB_PASSWORD'];
$db_dbName = $_ENV['DB_NAME'];

$database = new Database($db_host, $db_username, $db_password, $db_dbName);
$db = $database->getConnection();
$employee = new Employee($db);
$employees = $employee->getAllEmployees();
$employeesCount = $employees->rowCount();

echo json_encode($employeesCount);
if ($employeesCount > 0) {
    $employeeArr = array();
    $employeeArr['body'] = array();
    $employeeArr['employeesCount'] = $employeesCount;

    while ($row = $employees->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "age" => $age,
            "designation" => $designation,
            "created_at" => $created_at
        );
        array_push($employeeArr['body'], $e);
    }
    echo json_encode($employeeArr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "No record found"));
}
