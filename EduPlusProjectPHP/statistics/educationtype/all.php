<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/educationtype.php';

$database = new Database();
$db = $database->getConnection();

$educationtype = new EducationType($db);

$stmt = $educationtype->getValues();
$num = $stmt->rowCount();
if ($num > 0) {

    $educationtype_arr = array();
    $educationtype_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $educationtype_item = array(
            "type_education" => $type_education,
            "year" => $year,
            "count_person" => $count_person
        );

        array_push($educationtype_arr["records"], $educationtype_item);
    }
    http_response_code(200);

    // show products data in json format
    echo json_encode($educationtype_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


