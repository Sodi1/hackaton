<?php


class Student
{
    private $conn;
    private $table_name = "students";

    public $id;
    public $faculty;
    public $middle_name;
    public $first_name;
    public $last_name;
    public $name_spec;
    public $stud_number;
    public $direction_study;
    public $degree;
    public $date_of_birth;
    public $email;
    public $phone_number;
    public $citizenship;
    public $registration_address;
    public $form_of_training;
    public $privileges;
    public $continuing_education;
    public $city;
    public $name_of_company;
    public $kind_of_activity;
    public $position;
    public $work_in_specialty;
    public $year;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllStudent()
    {
        $query = "SELECT id
                        ,faculty
                        ,middle_name
                        ,first_name
                        ,last_name
                        ,name_spec
                        ,stud_number
                        ,direction_study
                        ,degree
                        ,date_of_birth
                        ,email
                        ,phone_number
                        ,citizenship
                        ,registration_address
                        ,form_of_training
                        ,privileges
                        ,continuing_education
                        ,city
                        ,name_of_company
                        ,kind_of_activity
                        ,position
                        ,work_in_specialty
                        ,year 
                FROM 
                  " . $this->table_name . " s 
                  ORDER BY s.middle_name DESC";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function getStudent($id)
    {
        $query = "SELECT id
                        ,faculty
                        ,middle_name
                        ,first_name
                        ,last_name
                        ,name_spec
                        ,stud_number
                        ,direction_study
                        ,degree
                        ,date_of_birth
                        ,email
                        ,phone_number
                        ,citizenship
                        ,registration_address
                        ,form_of_training
                        ,privileges
                        ,continuing_education
                        ,city
                        ,name_of_company
                        ,kind_of_activity
                        ,position
                        ,work_in_specialty
                        ,year 
                FROM students s 
        WHERE s.id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->execute([':id'=> $id]);
        return $stmt;
    }
}