<?php


class ApproveProgram
{

    private $conn;
    public $avg_value;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getValues($spec, $year){
        $query = "SELECT (SELECT COUNT(*) FROM questionary x WHERE UPPER(x.direction) LIKE '%".$spec."%' 
        AND final_year = ".$year." 
    AND x.competencies IN ('Полностью соответствуют', 'В основном соответствуют')) / (SELECT COUNT(*) FROM questionary x 
    WHERE UPPER(x.direction) LIKE '%".$spec."%' AND x.competencies NOT IN ('Полностью соответствуют', 'В основном соответствуют') 
    AND  UPPER(x.direction) LIKE '%".$spec."%' AND final_year = ".$year.") * 100 avg_value";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}