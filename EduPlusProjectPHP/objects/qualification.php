<?php


class Qualification
{
    private $conn;
    public $avg_value;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getValues($spec, $year){
        $query = "SELECT (SELECT COUNT(*) 
                        FROM(SELECT 
                                CASE WHEN direction = '1' 
                                    THEN '15.03.04' 
                                ELSE 
                                    '15.04.04' 
                                END spec_name 
                        FROM teachers x 
                        WHERE x.year = ".$year." 
                              AND qualifications_completed IS NOT NULL 
                              AND qualifications_completed <>'') src 
                        WHERE src.spec_name = '".$spec."') 
                        / 
                        (SELECT COUNT(*) 
                                FROM (SELECT 
                                       CASE 
                                           WHEN direction = '1' 
                                              THEN '15.03.04' 
                                            ELSE '15.04.04' END spec_name 
                                        FROM teachers x WHERE x.year = ".$year.") 
                            src 
                        WHERE src.spec_name = '".$spec."') * 100 avg_value";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}