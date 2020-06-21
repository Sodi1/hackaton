<?php


class ApproveEducation
{
    private $conn;

    public $direction;
    public $final_year;
    public $approve_work_activity;
    public $count_approvers;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getData($direction, $year){
        $str = "";
        if(!isset($year)){
            $str = "1 = 1";
        }else{
            $str = "x.final_year=".$year;
        }

        $query = "SELECT x.direction,
                           x.final_year, 
                           x.approve_work_activity, 
                           COUNT(*) count_approvers
                    FROM questionary x 
                    WHERE UPPER(x.direction) LIKE UPPER('%".$direction."%')
                          AND ".$str."
                    GROUP BY x.direction, 
                             x.final_year, 
                             x.approve_work_activity 
                    ORDER BY x.final_year;";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;

    }


}