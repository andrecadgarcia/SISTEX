<?php

class CountryDAO {
    
    protected $conn;
    
    //constructor create a new DB connection
    public function CountryDao() {
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
        $numRows = count($result);
        if($numRows > 0) {
            for ($i = 0; $i < $numRows; $i++) {
                //Fetch each result
                $row = $result->fetch(PDO::FETCH_ASSOC);
                //Store in countryVO array
                $countryVO[$i] = new CountryVO($row["id_country"],
                                               $row["name"]);
            }
        }
        return $countryVO;
    }
    
    //Get a country by its id
    public function getById_country($id_country) {
        //Generate sql
        $sql = "SELECT * FROM country WHERE id_country=" . $id_country;
        return $this->executeQuery($sql);
    }
    
    //Get all countries
    public function getCountries() {
        //Generate sql
        $sql = "SELECT * FROM country";
        return $this->executeQuery($sql);
    }
    
    //Save or update a country
    public function save($countryVO) {
        
        //if country has id, fetch it from DB and then update
        if($countryVO->getId_country() != "") {
            $currentCountryVO = $this->getById_country($countryVO->getId_country());
            $sql = "UPDATE country SET
                        name='" . $countryVO->getName() . "' " . 
                        "WHERE id_country=" . $currentCountryVO->getId_country() . ";";
            $stmt = $conn->query($sql);
            return 'UPDATED';
        }
        
        //if not, create a new author
        else {
            $sql = "INSERT INTO country (id_country, name) VALUES(DEFAULT,'" . $countryVO->getName() . "');";
            $stmt = $conn->query($sql);
            return 'INSERTED';
        }
    }
    
    //Delete a coutry
    public function delete($countryVO) {
        
        //if author exists, delete him
        if($countryVO->getId_country() != "") {
            $currentCountryVO = $this->getById_country($countryVO->getId_country());
            $sql = "DELETE FROM country WHERE id_country=" . $currentCountryVO->getId_country() . ";";
            $stmt = $conn->query($sql);
        }
        
        return 'DELETED';
    }

}

?>
