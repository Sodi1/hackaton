<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/MainReport.php';

$database = new Database();
$db = $database->getConnection();
$mainReport = new MainReport($db);

$spec = $_GET["spec"];
$year = $_GET["year"];

$stmt = $mainReport->getDate($spec, $year);

$num = $stmt->rowCount();

if ($num > 0) {

    $mainReport_arr = array();
    $mainReport_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $mainReport_item = array(
            "program_value" => $program_value,
            "work_value" => $work_value,
            "demand_skills" => $demand_skills,
            "excellent" => $excellent,
            "teachstudentrating" => $teachstudentrating,
            "hirsch" => $hirsch
        );
        array_push($mainReport_arr["records"], $mainReport_item);
    }
    http_response_code(200);
    echo json_encode($mainReport_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


