<?php


class Direction
{
    private $conn;
    public $name;
    public $code;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getValues(){
        $query = "SELECT src.name, src.name_spec code FROM (SELECT DISTINCT CONCAT(x.direction_study, ' (', x.degree, ')')
 name, x.name_spec FROM students x WHERE x.direction_study <>'') src  ORDER BY src.name DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

}