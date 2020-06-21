<?php


class ExcellentStudent
{
    private $conn;
    public $avg_value;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getValue($spec, $year){
        $query = "SELECT (SELECT COUNT(*) FROM students x WHERE UPPER(x.name_spec) = '".$spec."' 
        AND x.year = ".$year." AND average_program > 53) / (SELECT COUNT(*)
                  FROM students x WHERE UPPER(x.name_spec) = '".$spec."' AND x.year = ".$year.") * 100 avg_value";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}