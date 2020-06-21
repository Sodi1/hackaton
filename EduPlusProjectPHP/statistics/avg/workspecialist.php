<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/workspecialist.php';


$spec = $_GET['spec'];
$year = $_GET['year'];

$database = new Database();
$db = $database->getConnection();
$work = new WorkSpecialist($db);

$stmt = $work->getValues($spec, $year);
$num = $stmt->rowCount();
if ($num > 0) {
    $work_arr = array();
    $work_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $work_item = array(
            "avg_value" => $avg_value
        );

        array_push($work_arr["records"], $work_item);
    }
    http_response_code(200);

    // show products data in json format
    echo json_encode($work_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


