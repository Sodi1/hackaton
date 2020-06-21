<?php


class MainReport
{
    private $conn;

    public $program_value;
    public $work_value;
    public $demand_skills;
    public $excellent;
    public $teachstudentrating;
    public $hirsch;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getDate($spec, $year){
        $query = "SELECT (SELECT CASE
                            WHEN src_program.avg_program = 0 THEN
                               0 
                            WHEN src_program.avg_program < 30 THEN 
                                2 
                            WHEN src_program.avg_program >= 31 AND 
                                 src_program.avg_program < 49 THEN 
                                5
                            WHEN src_program.avg_program >= 50 AND 
                                 src_program.avg_program < 80 THEN 
                             8
                            WHEN src_program.avg_program >= 80 AND
                                 src_program.avg_program < 89 THEN 
                                9
                             WHEN src_program.avg_program >= 90 THEN
                                10
                             ELSE 
                                0
                             END 
                       FROM (SELECT AVG(x.average_program)  avg_program 
                        FROM students x WHERE
                        UPPER(x.name_spec) LIKE '%".$spec."%' 
                            AND year = ".$year.") src_program) AS program_value
                    ,(SELECT CASE 
                                WHEN src.avg_value <= 20 THEN 
                                    3
                                WHEN src.avg_value >= 21 AND src.avg_value < 51 THEN 
                                    6
                                WHEN src.avg_value >= 51 AND src.avg_value < 80 THEN 
                                    8
                                WHEN src.avg_value >= 80 AND src.avg_value < 95 THEN
                                    9
                                WHEN src.avg_value >= 95 THEN 
                                    10
                                ELSE 
                                    0 
                                END
                            FROM 
                                (SELECT (SELECT COUNT(*) FROM students x 
                                    WHERE x.work_in_specialty IN ('да', 'да') 
                                        AND UPPER(x.name_spec) LIKE '%".$spec."%' 
                            AND year = ".$year.") / 
                                (SELECT COUNT(*) 
                                    FROM students x 
                                    WHERE x.work_in_specialty NOT IN ('да', 'да') 
                                    AND UPPER(x.name_spec) LIKE '%".$spec."%' 
                            AND year = ".$year.") * 100 AS avg_value ) src) AS work_value
                    ,(SELECT CASE 
                            WHEN src.avg_value < 50 THEN
                                 3
                            WHEN src.avg_value >= 50 AND src.avg_value < 71 THEN
                                5
                            WHEN src.avg_value >= 71 AND src.avg_value < 80 THEN 
                              8
                            WHEN src.avg_value >= 80 AND src.avg_value < 93 THEN
                              9
                            WHEN src.avg_value >= 93 THEN 
                                10
                             ELSE
                               0
                             END
                        FROM (SELECT (SELECT COUNT(*) 
                                FROM questionary x
                            WHERE (UPPER(x.demand_skills) LIKE UPPER('%Да,%') 
                                    OR UPPER(x.demand_skills) LIKE UPPER('%Получен%')
                                    OR UPPER(x.demand_skills) LIKE UPPER('%ПРОФЕСС%'))
                                    AND final_year= ".$year."
                                    AND UPPER(x.direction) LIKE '%".$spec."%' ) 
                                    / 
                                (SELECT COUNT(*) 
                                        FROM questionary x 
                                WHERE x.final_year = ".$year." 
                                    AND UPPER(x.direction) LIKE '%".$spec."%'  ) * 100
                                    AS avg_value) src) AS demand_skills
                                    
                    ,(SELECT CASE 
                              WHEN src.avg_value < 30 THEN 
                                 2 
                              WHEN src.avg_value >= 30 AND src.avg_value < 60 THEN
                                 5
                              WHEN src.avg_value >= 60 AND src.avg_value < 70 THEN 
                                 8
                              WHEN src.avg_value >= 70 AND src.avg_value < 81 THEN 
                                 9
                               WHEN src.avg_value >= 81 THEN 
                                10
                              ELSE 
                                0
                              END 
                       FROM (SELECT (SELECT 
                                COUNT(*) 
                            FROM students x 
                            WHERE UPPER(x.name_spec) = '".$spec."'
                                  AND x.year = ".$year."
                                  AND average_program > 53) 
                            / (SELECT 
                                    COUNT(*)
                             FROM students x 
                             WHERE UPPER(x.name_spec) = '".$spec."' 
                             AND x.year = 2019) * 100 AS avg_value) src) AS excellent 
                                    
                    ,(SELECT CASE 
                            WHEN src.avg_value < 20.0 THEN 
                                2
                            WHEN TRUNCATE(src.avg_value,0) >= 20 AND TRUNCATE(src.avg_value,0) < 49 THEN 
                             4
                            WHEN TRUNCATE(src.avg_value,0) >= 50.0 AND TRUNCATE(src.avg_value,0) < 70 THEN 
                             8
                             WHEN src.avg_value >= 71.0 AND src.avg_value < 86.0 THEN 
                             9
                             WHEN src.avg_value >= 86.0 THEN 
                             10
                             ELSE 
                              0
                             END 
                     FROM (SELECT (SELECT 
                               COUNT(*) 
                          FROM (SELECT 
                               CASE 
                                   WHEN direction = '1' 
                                       THEN '15.03.04' 
                                   ELSE 
                                       '15.04.04' 
                                   END spec_name, x.* 
                                   FROM teachers x 
                           WHERE x.year = ".$year."
                                 AND rating_student >= 6) src 
                           WHERE src.spec_name = '".$spec."') 
                           / 
                           (SELECT 
                               COUNT(*) 
                           FROM (SELECT
                                   CASE 
                                       WHEN direction = '1' THEN 
                                           '15.03.04' 
                                           ELSE '15.04.04' 
                                       END spec_name, x.* 
                                   FROM teachers x 
                                   WHERE x.year = ".$year.") src  
                           WHERE src.spec_name = '".$spec."') * 100 AS avg_value ) src) 
                           AS teachstudentrating
                           ,(SELECT CASE 
                                WHEN src.avg_value < 20 THEN 
                                    2
                                WHEN src.avg_value >= 20 AND src.avg_value < 49 THEN 
                                   4
                                WHEN src.avg_value >= 50 AND src.avg_value < 70 THEN 
                                   8
                                WHEN src.avg_value >= 71 AND src.avg_value < 86 THEN 
                                   9
                                WHEN src.avg_value >= 87 THEN 
                                  10
                                END 
                        FROM 
                          (SELECT 
                              (SELECT COUNT(*) FROM 
                                  (
                                     SELECT 
                                         CASE WHEN direction = '1' THEN 
                                              '15.03.04' 
                                         ELSE 
                                             '15.04.04'
                                         END spec_name, 
                                     x.* FROM teachers x 
                                     WHERE x.year = ".$year." AND hirsch_index >= 2) src 
                                     WHERE src.spec_name = '".$spec."') / 
                                     (SELECT COUNT(*) FROM 
                                         (SELECT CASE 
                                              WHEN direction = '1' 
                                                  THEN '15.03.04' 
                                              ELSE 
                                                 '15.04.04' 
                                               END spec_name, 
                                               x.* 
                                          FROM teachers x 
                                       WHERE x.year = ".$year.") 
                                       src WHERE src.spec_name =  '".$spec."') * 100 avg_value) src ) AS hirsch";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;

    }

}