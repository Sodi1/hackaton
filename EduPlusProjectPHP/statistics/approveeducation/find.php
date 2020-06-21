<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../objects/approveeducation.php';


$dir = $_GET["direction"];
$year = $_GET["year"];

$database = new Database();
$db = $database->getConnection();

$approveEducation = new ApproveEducation($db);

$stmt = $approveEducation->getData($dir, $year);
$num = $stmt->rowCount();

if ($num > 0) {

    $approveEducation_arr = array();
    $approveEducation_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $approveEducation_item = array(
            "direction" => $direction,
            "final_year" => $final_year,
            "approve_work_activity" => $approve_work_activity,
            "count_approvers" => $count_approvers
        );

        array_push($approveEducation_arr["records"], $approveEducation_item);
    }
    http_response_code(200);

    echo json_encode($approveEducation_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}