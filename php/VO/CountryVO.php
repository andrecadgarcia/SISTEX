<?php
class CountryVO {
    protected $id_country, $name;
    
    //contructor creates a new country
    public function __construct($id_country, $name) {
        $this->id_country = $id_country;
        $this->name = $name;
    }
    
    //GETTERS and SETTERS for variables
    public function setId_country($id_country) {
        $this->id_country = $id_country;
    }
    
    public function getId_country() {
        return $this->id_country;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
     
    //Store in Session author's info
    public function toSession() {
        session_start();
        $_SESSION["id_country"] = $this->id_country;
        $_SESSION["name"] = $this->name;
    }
    
    //Generate string to send info back to javascript
    public function toString() {
        $string = $this->getId_country() . "," . $this->getName();
        return $string;
    }    
    
}
?>
