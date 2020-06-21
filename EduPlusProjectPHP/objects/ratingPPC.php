<?php


class RatingPPC
{
    private $conn;
    public $avg_value;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getValues($spec, $year)
    {
        $query = "SELECT (SELECT 
                        COUNT(*) FROM 
                        (SELECT 
                        CASE WHEN direction = '1' THEN '15.03.04' 
                        ELSE '15.04.04' END spec_name, x.* 
                        FROM teachers x WHERE x.year = ".$year."
                        AND rating_ppc >= 60) src  
                 WHERE src.spec_name = '".$spec."')
                 / 
                 (SELECT COUNT(*) 
                    FROM (SELECT CASE WHEN direction = '1' 
                        THEN '15.03.04' 
                        ELSE '15.04.04' 
                    END spec_name, x.* 
                    FROM teachers x WHERE x.year = ".$year.") src  
                 WHERE src.spec_name = '".$spec."') * 100 avg_value;";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}