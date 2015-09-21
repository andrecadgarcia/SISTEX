<?php
class DepartmentVO {
    protected $id_department, $id_university, $name, $initials;
    
    //contructor creates a new department
    public function __contruct($id_department, $id_university, $name, $initials;) {
        $this->id_department = $id_department;
        $this->id_university = $id_university; 
        $this->name = $name; 
        $this->initials = $initials;
    }
    
    //GETTERS and SETTTERS for variables
    public function setId_department($id_department) {
        $this->id_department = $id_department;
    }
    
    public function getId_department() {
        return $this->id_department;
    }
    
    public function setId_university($id_university) {
        $this->university = $id_university;   
    }
    
    public function getId_university() {
        return $this->university;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setInitials($initials) {
        $this->initials = $initials;
    }
    
    public function getInitials() {
        return $this->initials;   
    }
    
    //Store in Sessios university's info
    public function toSession() {
        session_start();
        $_SESSION["id_department"] = $this->id_department;
        $_SESSION["id_univeristy"] = $this->id_university;
        $_SESSION["name"] = $this->name;
        $_SESSION["initials"] = $this->initials;
    }

    //Generate string to send info back to javascript
    public function toString() {
        $string = $this->getId_department() . "," . $this->getId_university() . "," . $this->getName() . "," .$this->getId_initials();
        return $string;
    }    
    
}
?>
