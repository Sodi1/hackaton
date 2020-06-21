<?php


class EducationType
{
    private $conn;

    public $type_education;
    public $year;
    public $count_person;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getValues(){
        $query = "SELECT CASE WHEN full_part_time = '1' THEN 'очное' WHEN full_part_time = '0' THEN 'заочное' ELSE 'очно/заочное'
            END type_education, 
            year, 
            COUNT(*) count_person FROM students GROUP BY full_part_time, year";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

}