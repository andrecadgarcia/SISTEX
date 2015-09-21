<?php

class StateDAO {

    protected $conn;
    
    //constructor creates a new DB connection
    public function StateDao() {
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
                //Store in stateVO array
                $stateVO[$i] = new StateVO($row[$i]["id_state"],
                                           $row[$i]["id_country"],
                                           $row[$i]["initials"],
                                           $row[$i]["name"]);
            }
        }
        return $stateVO;
    }
    
    //Get a state by its id
    public function getById_state($id_state) {
        //Generate sql
        $sql = "SELECT * FROM state WHERE id_state=" . $id_state;
        return $this->executeQuery($sql);
    }
    
    //Get all states of a country
    public function getAllByCountry($id_country) {
        //Generate sql
        $sql = "SELECT * FROM state where id_country=" . $id_country . ";";
        return $this->executeQuery($sql);
    }
    
    //Save or update a state
    public function save($stateVO) {
        
        //if state has id, fetch it from DB and then update
        if($stateVO->getId_state() != "") {
            $currentStateVO = $this->getById_state($stateVO->getId_state());
            $sql = "UPDATE state SET
                        id_country=" . $stateVO->getId_country() . ", " .
                        "initials='" . $stateVO->getInitials() . "', " .
                        "name='" . $stateVO->getName() . "' " . 
                        "WHERE id_state=" . $currentStateVO->getId_state() . ";";
            $stmt = $conn->query($sql);
            return 'UPDATED';
        }
        
        //if not, create a new state
        else {
            $sql = "INSERT INTO state (id_state, id_country, initials, name) VALUES(DEFAULT," . 
                                                                                $stateVO->getId_country() . ",'" .
                                                                                $stateVO->getInitials() . "','" .
                                                                                $stateVO->getName() . "');";
            $stmt = $conn->query($sql);
            return 'INSERTED';
        }
    }
    
    //Delete a state
    public function delete($stateVO) {
        
        //if state exists, delete him
        if($stateVO->getId_state() != "") {
            $currentStateVO = $this->getById_state($stateVO->getId_state());
            $sql = "DELETE FROM state WHERE id_state=" . $currentStateVO->getId_state() . ";";
            $stmt = $conn->query($sql);
        }
        
        return 'DELETED';
    }

}

?>
