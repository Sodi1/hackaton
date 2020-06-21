<?php


class Teacher
{
    private $conn;

    public $full_name;
    public $position;
    public $year;
    public $rating_ppc;
    public $count_quotation;
    public $hirsch_index;
    public $rating_student;
    public $student_winners;
    public $part_time;
    public $practices;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getData($scopus_id)
    {
        $query = "SELECT CONCAT(x.middle_name, ' ', x.first_name, ' ', x.last_name) full_name, 
                         CONCAT(x.position, ' ', x.degree) position, 
                         year, 
                         rating_ppc, 
                         count_quotation, 
                         hirsch_index, 
                         rating_student, 
                         student_winners, 
                         part_time, 
                         practices  
                 FROM teachers x WHERE x.scopus_id = ".$scopus_id."
                 ORDER BY year ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

}