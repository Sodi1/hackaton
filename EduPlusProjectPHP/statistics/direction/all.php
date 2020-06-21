<?php

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/direction.php';

$database = new Database();
$db = $database->getConnection();

$direction = new Direction($db);

$stmt = $direction->getValues();
$num = $stmt->rowCount();
if ($num > 0) {

    $direction_arr = array();
    $direction_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $direction_item = array(
            "name" => $name,
            "code" => $code
        );

        array_push($direction_arr["records"], $direction_item);
    }
    http_response_code(200);

    // show products data in json format
    echo json_encode($direction_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


