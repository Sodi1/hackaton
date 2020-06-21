<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/student.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$stmt = $student->getAllStudent();
$num = $stmt->rowCount();
echo $num;
if ($num > 0) {

    $students_arr = array();
    $students_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $student_item = array(
            "id" => $id,
            "faculty" => $faculty,
            "middle_name" => $middle_name,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "name_spec" => $name_spec,
            "stud_number" => $stud_number,
            "direction_study" => $direction_study,
            "degree" => $degree,
            "date_of_birth" => $date_of_birth,
            "email" => $email,
            "phone_number" => $phone_number,
            "citizenship" => $citizenship,
            "registration_address" => $registration_addr,
            "form_of_training" => $form_of_training,
            "privileges" => $privileges,
            "continuing_education" => $continuing_education,
            "city" => $city,
            "name_of_company" => $name_of_company,
            "kind_of_activity" => $kind_of_activity,
            "position" => $position,
            "work_in_specialty" => $work_in_specialty,
            "year" => $year
        );

        array_push($students_arr["records"], $student_item);
    }
    http_response_code(200);

    // show products data in json format
    echo json_encode($students_arr, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(404);
}


