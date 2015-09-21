<?php

class DepartmentDAO {
    
    protected var $conn;
    
    //constructor creates a new DB connection
    public function DepartmentDao() {
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
                $departmentVO[$i] = new DepartmentVO($row[$i]["id_department"],
                                                     $row[$i]["id_city"],
                                                     $row[$i]["name"],
                                                     $row[$i]["initials"]);
            }
        }
        return $departmentVO;
    }
    
    //Get a department by its id
    public function getById_department($id_department) {
        //Generate sql
        $sql = "SELECT * FROM department WHERE id_department=" . $id_department;
        return $this->executeQuery($sql);
    }
    
    //Get a department by its id
    public function getAllByUniversity($id_university) {
        //Generate sql
        $sql = "SELECT * FROM department WHERE id_university=" . $id_university . ";";
        return $this->executeQuery($sql);
    }
    
    //Save or update a department
    public function save($departmentVO) {
        //if department has id, fetch it from DB and then update
        if($departmentVO->getId_department() != "") {
            $currentDepartmentVO = $this->getById_department($departmentVO->getId_department());
            $sql = "UPDATE department SET
                        id_city=" . $departmentVO->getId_city() . ", " .
                        "name='" . $departmentVO->getName() . "' " . 
                        "initials='" . $deparmentVO->getInitials() . "', " .
                        "WHERE id_department=" . $currentDepartmentVO->getId_department() . ";";
            $stmt = $conn->query($sql);
            return 'UPDATED';
        }
        
        //if not, create a new department
        else {
            $sql = "INSERT INTO department (id_department, id_city, name, initials) VALUES(DEFAULT," . 
                                                                                $departmentVO->getId_country() . ",'" .
                                                                                $departmentVO->getName() . "','" .
                                                                                $departmentVO->getInitials() . "';";
            $stmt = $conn->query($sql);
            return 'INSERTED';
        }
    }
    
    //Delete a state
    public function delete($departmentVO) {
        //if department exists, delete him
        if($departmentVO->getId_department() != "") {
            $currentDepartmentVO = $this->getById_department($departmentVO->getId_department());
            $sql = "DELETE FROM department WHERE id_department=" . $currentDepartmentVO->getId_department() . ";";
            $stmt = $conn->query($sql);
        }
        
        return 'DELETED';
    }

}

?>
