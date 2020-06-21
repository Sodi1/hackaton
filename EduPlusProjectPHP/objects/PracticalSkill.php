<?php


class PracticalSkill
{
    private $conn;
    public $avg_value;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getValues($spec, $year){
        $query = "SELECT (SELECT COUNT(*) FROM questionary x WHERE (UPPER(x.demand_skills) LIKE UPPER('%Да,%') 
    OR UPPER(x.demand_skills) LIKE UPPER('%Получен%') OR UPPER(x.demand_skills) LIKE UPPER('%ПРОФЕСС%'))
	AND final_year=".$year." AND UPPER(x.direction) LIKE '%".$spec."%' ) / 
	(SELECT COUNT(*) FROM questionary x WHERE x.final_year = ".$year." AND UPPER(x.direction) LIKE '%".$spec."%' ) * 100 avg_value" ;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}