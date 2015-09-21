<?php
class UniversityVO {
    protected $id_university, $id_city, $name, $address, $zip_code, $initials;
    
    //contructor creates a new country
    public function __construct($id_university, $id_city, $name, $address, $zip_code, $initials) {
        $this->id_university = $id_university;
        $this->id_city = $id_city;
        $this->name = $name;
        $this->address = $address; 
        $this->zip_code = $zip_code;
        $this->initials = $initials;
    }
    
    //GETTERS and SETTERS for variables
    public function setId_university($id_university) {
        $this->id_univeristy = $id_university;
    }
    
    public function getId_university() {
        return $this->id_university;
    }
    
    public function setId_city($id_city) {
        $this->id_city = $id_city;
    }
    
    public function getId_city() {
        return $this->id_city;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setAddress($address) {
        $this->address = $address;
    }
    
    public function getAddress() {
        return $this->address;
    }
    
    public function setZip_code($zip_code) {
        $this->zip_code = $zip_code;
    }
    
    public function getZip_code() {
        return $this->zip_code;
    }
    
    public function setInitials($initials) {
        $this->initials = $initials;
    }
    
    public function getInitials() {
        return $this->initials;
    }
    
    //Store in Session city's info
    public function toSession() {
        session_start();
        $_SESSION["id_university"] = $this->id_university;
        $_SESSION["id_city"] = $this->id_city;
        $_SESSION["name"] = $this->name;
        $_SESSION["address"] = $this->address;
        $_SESSION["zip_code"] = $this->zip_code;
        $_SESSION["initials"] = $this->initials;
    }

    //Generate string to send info back to javascript
    public function toString() {
        $string = $this->getId_university() . "," . $this->getId_city() . "," . $this->getName() . "," . $this->getAddress() . "," . $this->getZip_code() . "," . $this->getInitials();
        return $string;
    }    
    
}
?>
