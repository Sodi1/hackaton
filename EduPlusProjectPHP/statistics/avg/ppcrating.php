<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/ratingPPC.php';


$spec = $_GET['spec'];
$year = $_GET['year'];

$database = new Database();
$db = $database->getConnection();
$ratingPPC = new RatingPPC($db);

$stmt = $ratingPPC->getValues($spec, $year);

$num = $stmt->rowCount();
if ($num > 0) {

    $ratingPPC_arr = array();
    $ratingPPC_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $ratingPPC_item = array(
            "avg_value" => $avg_value
        );

        array_push($ratingPPC_arr["records"], $ratingPPC_item);
    }
    http_response_code(200);

    // show products data in json format
    echo json_encode($ratingPPC_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


