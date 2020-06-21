<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/excellentStudent.php';


$spec = $_GET['spec'];
$year = $_GET['year'];

$database = new Database();
$db = $database->getConnection();
$excellentStudent = new ExcellentStudent($db);

$stmt = $excellentStudent->getValue($spec, $year);

$num = $stmt->rowCount();
if ($num > 0) {

    $excellentStudent_arr = array();
    $excellentStudent_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $excellentStudent_item = array(
            "avg_value" => $avg_value
        );

        array_push($excellentStudent_arr["records"], $excellentStudent_item);
    }
    http_response_code(200);

    // show products data in json format
    echo json_encode($excellentStudent_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


