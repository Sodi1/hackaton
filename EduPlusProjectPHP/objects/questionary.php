<?php


class Questionary
{
    private $conn;

    public $id;
    public $event_time;
    public $grade;
    public $pre_education;
    public $form;
    public $final_year;
    public $current_edu_form;
    public $going_contin;
    public $direction_value;
    public $have_work_flag;
    public $understand_task;
    public $competencies;
    public $ready_text;
    public $matching_skills;
    public $theoretical_training;
    public $soft_skills;
    public $approve_contact;
    public $approve_work_activity;
    public $approve_salary;
    public $approve_average_salary;
    public $demand_skills;
    public $sex;
    public $region;

    public function __construct($db)
    {
        $this->$conn = $db;
    }

    public function getAllAnswers()
    {
        $query = "SELECT id
                        ,event_time
                        ,grade
                        ,pre_education
                        ,form
                        ,final_year
                        ,current_edu_form
                        ,going_contin
                        ,direction
                        ,have_work_flag
                        ,understand_task
                        ,competencies
                        ,ready_text
                        ,matching_skills
                        ,theoretical_training
                        ,soft_skills
                        ,approve_contact
                        ,approve_work_activity
                        ,approve_salary
                        ,approve_average_salary
                        ,demand_skills
                        ,sex
                        ,region 
                    FROM questionary";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function getData($spec, $year){
        $query = "SELECT id
                        ,event_time
                        ,grade
                        ,pre_education
                        ,form
                        ,final_year
                        ,current_edu_form
                        ,going_contin
                        ,direction
                        ,have_work_flag
                        ,understand_task
                        ,competencies
                        ,ready_text
                        ,matching_skills
                        ,theoretical_training
                        ,soft_skills
                        ,approve_contact
                        ,approve_work_activity
                        ,approve_salary
                        ,approve_average_salary
                        ,demand_skills
                        ,sex
                        ,region 
                    FROM questionary x WHERE x.direction LIKE '%".$spec."%' 
                    AND x.final_year = ".$year;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

}
