<?php

class UniversityDAO {
    
    protected $conn;
    
    //constructor creates a new DB connection
    public function UniversityDAO() {
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
        //Fecth all results
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        $numRows = count($row);
        if($numRows > 0) {
            for ($i = 0; $i < $numRows; $i++) {
                $universityVO[$i] = new UniversityVO($row[$i]["id_university"],
                                                     $row[$i]["id_city"],
                                                     $row[$i]["name"],
                                                     $row[$i]["address"],
                                                     $row[$i]["zip_code"],
                                                     $row[$i]["initials"]);
            }
        }
        return $universityVO;
    }
    
    //Get a university by its id
    public function getById_university($id_university) {
        $sql = "SELECT * FROM university WHERE id_university=" . $id_university;
        return $this->executeQuery($sql);
    }
    
    //Get all univerisities
    public function getUniversities() {
        $sql = "SELECT * FROM university";
        return $this->executeQuery($sql);
    }
    
    //Save or update a university
    public function save($universityVO) {
        
        //if university has id, fetch it from DB and then update
        if($universityVO->getId_university() != "") {
            $currentUniversityVO = $this->getById_university($universityVO->getId_university());
            $sql = "UPDATE university SET
                        id_city=" . $universityVO->getId_city() . "," .
                        "name='" . $universityVO->getName() . "', " . 
                        "address='" . $universityVO->getAddress() . "', " .
                        "zip_code='" . $universityVO->getZip_code() . "', " .
                        "initials='" . $universityVO->getInitials() . "' " . 
                        "WHERE id_university=" . $currentUniversityVO->getId_university() . ";";
            $stmt = $conn->query($sql);
            return 'UPDATED';
        }
        
        //if not, create a new university
        else {
            $sql = "INSERT INTO university (id_university, id_city, name, address, zip_code, initials) VALUES(DEFAULT," . 
                                                                                $universityVO->getId_ciyy() . ",'" .
                                                                                $universityVO->getName() . "','" .
                                                                                $universityVO->getAddress() . "','" .
                                                                                $universityVO->getZip_code() . "','" .
                                                                                $universityVO->getInitials() . "');";
            $stmt = $conn->query($sql);
            return 'INSERTED';
        }
    }
    
    //Delete a university
    public function delete($universityVO) {
        
        //if university exists, delete him
        if($universityVO->getId_university() != "") {
            $currentUniversityVO = $this->getById_university($universityVO->getId_university());
            $sql = "DELETE FROM university WHERE id_university=" . $currentUniversityVO->getId_university() . ";";
            $stmt = $conn->query($sql);
        }
        
        return 'DELETED';
    }

}

?>
