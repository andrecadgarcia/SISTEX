<?php

class AuthorVO {
    protected $id_author, $name, $email, $password, $address, $id, $id_city, $id_department, $photo;
    
    //contructor creates a new author
    public function __construct($id_author, $name, $email, $password, $address, $id, $id_city, $id_department, $photo) {
        if($id_author != "") $this->id_author = $id_author; //if id_author is not empty, a author is being selected 
        else $id_author = ""; //if id_author is empty, a new author is being registered
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->address = $address;
        $this->id = $id;
        $this->id_city = $id_city;
        $this->id_department = $id_department; 
        $this->photo = $photo;
    }
    
    //GETTERS and SETTERS for variables
    public function setId_author($id_author) {
        $this->id_author = $id_author;
    }
    
    public function getId_author() {
        return $this->id_author;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setAddress($address) {
        $this->address = $address;
    }
    
    public function getAddress() {
        return $this->address;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setId_city($id_city) {
        $this->id_city = $id_city;
    }
    
    public function getId_city() {
        return $this->id_city;
    }
    
    public function setId_department($id_department) {
        $this->id_department = $id_department;
    }
    
    public function getId_department() {
        return $this->id_department;
    }
    
    public function setPhoto($photo) {
        $this->photo = $photo;
    }
    
    public function getPhoto() {
        return $this->photo;
    }
    
    //Store in Session author's info
    public function toSession() {
        session_start();
        $_SESSION["id_author"] = $this->id_author;
        $_SESSION["name"] = $this->name;
        $_SESSION["email"] = $this->email;
        $_SESSION["password"] = $this->password;
        $_SESSION["address"] = $this->address;
        $_SESSION["id"] = $this->id;
        $_SESSION["id_city"] = $this->id_city;
        $_SESSION["id_department"] = $this->id_department; 
        $_SESSION["photo"] = $this->photo;
    }

    //Generate string to send info back to javascript
    public function toString() {
        $string =  $this->getId_author() . "," . $this->getName() . "," . $this->getEmail() . "," . $this->getPassword() . "," . $this->getAddress() . "," . $this->getId() . "," . $this->getId_city() . "," . $this->getId_department() . "," . $this->getPhoto();
        return $string;
    }    
    
}
?>
