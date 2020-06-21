<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/questionary.php';

$database = new Database();
$db = $database->getConnection();
$q = new Questionary($db);

$spec = $_GET["spec"];
$year = $_GET["year"];

$stmt = $q->getData($spec, $year);

$num = $stmt->rowCount();

if ($num > 0) {

    $questionary_arr = array();
    $questionary_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);
        $questionary_item = array(
            "id" => $id
            , "event_time" => $event_time
            , "grade" => $grade
            , "pre_education" => $pre_education
            , "form" => $form
            , "final_year" => $final_year
            , "current_edu_form" => $current_edu_form
            , "going_contin" => $going_contin
            , "direction" => $direction_value
            , "have_work_flag" => $have_work_flag
            , "understand_task" => $understand_task
            , "competencies" => $competencies
            , "ready_text" => $ready_text
            , "matching_skills" => $matching_skills
            , "theoretical_training" => $theoretical_training
            , "soft_skills" => $soft_skills
            , "approve_contact" => $approve_contact
            , "approve_work_activity" => $approve_work_activity
            , "approve_salary" => $approve_salary
            , "approve_average_salary" => $approve_average_salary
            , "demand_skills" => $demand_skills
            , "sex" => $sex
            , "region" => $region);
        array_push($questionary_arr["records"], $questionary_item);
    }
    http_response_code(200);
    echo json_encode($questionary_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


