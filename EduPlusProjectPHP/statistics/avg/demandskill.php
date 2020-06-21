<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/demandSkill.php';


$spec = $_GET['spec'];
$year = $_GET['year'];

$database = new Database();
$db = $database->getConnection();
$demandSkill = new DemandSkill($db);

$stmt = $demandSkill->getValues($spec, $year);
$num = $stmt->rowCount();
if ($num > 0) {

    $demandSkill_arr = array();
    $demandSkill_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $demandSkill_item = array(
            "avg_value" => $avg_value
        );

        array_push($demandSkill_arr["records"], $demandSkill_item);
    }
    http_response_code(200);

    // show products data in json format
    echo json_encode($demandSkill_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


