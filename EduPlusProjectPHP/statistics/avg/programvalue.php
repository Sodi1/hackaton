<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once '../../config/database.php';
include_once '../../objects/program.php';


$spec = $_GET['spec'];
$year = $_GET['year'];

$database = new Database();
$db = $database->getConnection();
$program = new Program($db);

$stmt = $program->getValues($spec, $year);
$num = $stmt->rowCount();
if ($num > 0) {

    $program_arr = array();
    $program_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $program_item = array(
            "avg_program" => $avg_program
        );

        array_push($program_arr["records"], $program_item);
    }
    http_response_code(200);

    // show products data in json format
    echo json_encode($program_arr, JSON_UNESCAPED_UNICODE);
} else {
   http_response_code(404);
}


