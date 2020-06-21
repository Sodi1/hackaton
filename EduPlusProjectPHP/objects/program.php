<?php

class Program
{
    private $conn;
    public $avg_program;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getValues($spec, $year){
        $query = "SELECT AVG(x.average_program) avg_program FROM students x WHERE UPPER(x.name_spec) LIKE '%".$spec."%' AND year = ".$year;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}