<?php


class WorkSpecialist
{
    private $conn;
    public $avg_value;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getValues($spec, $year){
        $query = "SELECT (SELECT COUNT(*) FROM students x 
                WHERE x.work_in_specialty IN ('да', 'да') AND UPPER(x.name_spec) LIKE '%".$spec."%' AND year = ".$year.") / (SELECT COUNT(*) 
                FROM students x WHERE x.work_in_specialty NOT IN ('да', 'да') AND UPPER(x.name_spec) LIKE '%".$spec."%' 
                AND year = ".$year.") * 100 avg_value";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

}