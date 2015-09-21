<?php
    //Include DAO and VO for author
    include '/VO/CountryVO.php';
    include '/DAO/CountryDAO.php';
    
    
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    
    @$tag = $request->tag;

    $countryDAO = new CountryDAO();

    switch($tag) {
        case "insert":
            //Create a country with all info from http
            @$name = $request->name;
            $countryVO = new CountryVO('', $name);
            return $countryDAO->save($countryVO);
            break;
        case "select":
            //Get all countries
            $countryVO = $countryDAO->getCountries();
            break;
        case "update":
            //Delete a country
            @$id = $request->id;
            $countryVO = $countryDAO->getById_country($id_country);
            return $countryDAO->delete($countryVO);
            break;
                    
    }
 
    $country = "";
    //Send all countries separated by ';'
    for($i = 0; $i < count($countryVO); $i++) {
        $country = $country . $countryVO[$i]->toString() . ';';
    }
    echo $country;
?>




