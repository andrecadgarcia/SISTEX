<?php
class StateVO {
    protected $id_state, $id_country, $initials, $name;
    
    //contructor creates a new state
    public function __construct($id_state, $id_country, $initials, $name) {
        $this->id_state = $id_state;
        $this->id_country = $id_country;
        $this->initials = $initials;
        $this->name = $name;
    }
    
    //GETTERS and SETTERS for variables
    public function setId_state($id_state) {
        $this->id_state = $id_state;
    }
    
    public function getId_state() {
        return $this->id_state;
    }
    
    public function setId_country($id_country) {
        $this->id_country = $id_country;
    }
    
    public function getId_country() {
        return $this->id_country;
    }
    
    public function setInitials($initials) {
        $this->initials = $initials;
    }
    
    public function getInitials() {
        return $this->initials;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    //Store in Sessios state's info
    public function toSession() {
        session_start();
        $_SESSION["id_state"] = $this->id_state;
        $_SESSION["id_country"] = $this->id_country;
        $_SESSION["initials"] = $this->initials;
        $_SESSION["name"] = $this->name;
    }
    
    //Generate string to send info back to javascript
    public function toString() {
        $string = $this->getId_state() . "," . $this->getId_country() . "," . $this->getInitials() . "," . $this->getName();
        return $string;
    }    
    
}
?>
