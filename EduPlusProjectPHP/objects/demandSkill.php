<?php


class DemandSkill
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
        AND  (UPPER(x.demand_skills) LIKE UPPER('%Да,%') 
                OR UPPER(x.demand_skills) LIKE UPPER('%Затрудняюсь%') 
                OR UPPER(x.demand_skills) LIKE UPPER('%Получен%') OR UPPER(x.demand_skills) LIKE UPPER('%ПРОФЕСС%'))) /
                 (SELECT COUNT(*) FROM questionary x WHERE UPPER(x.direction) LIKE '%".$spec."%' AND final_year = ".$year."
                  AND (UPPER(x.demand_skills) NOT LIKE UPPER('%Да,%') 
                 OR UPPER(x.demand_skills) NOT LIKE UPPER('%Затрудняюсь%') OR UPPER(x.demand_skills) NOT LIKE UPPER('%Получен%') 
                 OR UPPER(x.demand_skills) NOT LIKE UPPER('%ПРОФЕСС%'))) * 100 avg_value;";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}