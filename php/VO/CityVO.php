<?php
class CityVO {
    protected $id_city, $id_state, $name;
    
    //contructor creates a new city
    public function __construct($id_city, $id_state, $name) {
        $this->id_state = $id_city;
        $this->id_country = $id_state;
        $this->name = $name;
    }
    
    //GETTERS and SETTERS for variables
    public function setId_city($id_country) {
        $this->id_country = $id_country;
    }
    
    public function getId_city() {
        return $this->id_country;
    }
    
    public function setId_state($id_state) {
        $this->id_state = $id_state;
    }
    
    public function getId_state() {
        return $this->id_state;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        $this->name;
    }
    
    //Store in Session city's info
    public function toSession() {
        session_start();
        $_SESSION["id_city"] = $this->id_city;
        $_SESSION["id_state"] = $this->id_state;
        $_SESSION["name"] = $this->name;
    }

    //Generate string to send info back to javascript
    public function toString() {
        $string = $this->id_city . "," . $this->id_state . "," . $this->name;
        return $string;
    }    
    
}
?>
