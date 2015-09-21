<?php

class CityDAO {
    
    protected $conn;
    
    //constructor creates a new DB connection
    public function CityDao() {
        //DB configuration
        $host='localhost';
        $port='5432';
        $db = 'sistex';
        $username = 'postgres';
        $password = 'root';
        $dns = '';

        $postgres = "pgsql:host=$host;port=$port;dbname=$db;user=$username;password=$password";
        try {
            $this->conn = new PDO($postgres);
        } catch (PDOException $e) {
            diedie("Could not connect to the database $db :" . $p->getMessage());
        }
    }
    
    //Execute sql query
    protected function executeQuery($sql) {
        $result = $this->conn->query($sql);
        //Fetch all results
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        $numRows = count($row);
        if($numRows > 0) {
            for ($i = 0; $i < $numRows; $i++) { 
                //Store in countryVO array
                $cityVO[$i] = new cityVO($row[$i]["id_city"],
                                           $row[$i]["id_state"],
                                           $row[$i]["name"]);
            }
        }
        return $cityVO;
    }
    
    //Get a city by its id
    public function getById_city($id_city) {
        $sql = "SELECT * FROM city WHERE id_city=" . $id_city;
        return $this->executeQuery($sql);
    }
    
    //Get all cities of a state
    public function getAllByState($id_state) {
        $sql = "SELECT * FROM city WHERE id_state=" . $id_state .";";
        return $this->executeQuery($sql);
    }
    
    //Save or update a city
    public function save($cityVO) {
       //if city has id, fetch it from DB and then update
        if($cityVO->getId_city() != "") {
            $currentCityVO = $this->getById_city($cityVO->getId_city());
            $sql = "UPDATE city SET
                        id_state=" . $cityVO->getId_state() . ", " .
                        "name='" . $cityVO->getName() . "' " . 
                        "WHERE id_city=" . $currentCityVO->getId_city() . ";";
            $stmt = $conn->query($sql);
            return 'UPDATED';
        }
        
        //if not, create a new city
        else {
            $sql = "INSERT INTO city (id_city, id_state, name) VALUES(DEFAULT," . 
                                                                                $cityVO->getId_state() . ",'" .
                                                                                $cityVO->getName() . "');";
            $stmt = $conn->query($sql);
            return 'INSERTED';
        }
    }
    
    //Delete a city
    public function delete($cityVO) {
         //if city exists, delete him
        if($cityVO->getId_city() != "") {
            $currentCityVO = $this->getById_city($cityVO->getId_city());
            $sql = "DELETE FROM city WHERE id_city=" . $currentCityVO->getId_city() . ";";
            $stmt = $conn->query($sql);
        }
        
        return 'DELETED';
    }

}

?>
