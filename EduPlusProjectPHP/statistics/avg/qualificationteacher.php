<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/qualification.php';


$spec = $_GET['spec'];
$year = $_GET['year'];

$database = new Database();
$db = $database->getConnection();
$qualification = new Qualification($db);

$stmt = $qualification->getValues($spec, $year);
$num = $stmt->rowCount();
if ($num > 0) {

    $qualification_arr = array();
    $qualification_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $qualification_item = array(
            "avg_value" => $avg_value
        );

        array_push($qualification_arr["records"], $qualification_item);
    }
    http_response_code(200);

    // show products data in json format
    echo json_encode($qualification_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


