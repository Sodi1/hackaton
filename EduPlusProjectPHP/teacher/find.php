<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/teacher.php';


$scopus_id = $_GET["scopusid"];

$database = new Database();
$db = $database->getConnection();

$teacher = new Teacher($db);

$stmt = $teacher->getData($scopus_id);
$num = $stmt->rowCount();

if ($num > 0) {

    $teacher_arr = array();
    $teacher_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $teacher_item = array(
            "full_name" => $full_name,
            "position" => $position,
            "year" => $year,
            "hirsch_index" => $hirsch_index,
            "count_quotation" => $count_quotation,
            "rating_ppc" => $rating_ppc,
            "rating_student" => $rating_student,
            "student_winners" => $student_winners,
            "part_time" => $part_time,
            "practices" => $practices
        );

        array_push($teacher_arr["records"], $teacher_item);
    }
    http_response_code(200);

    echo json_encode($teacher_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}