<?php
    
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    
    //Get table to be accessed in DB and possible parent related
    @$option = $request->option;
    @$parentId = $request->parentId;

    switch($option) {
        //Country case
        case "Country":
            //Load Country VO and DAO files
            include '/VO/CountryVO.php';
            include '/DAO/CountryDAO.php';
            $countryDAO = new CountryDAO();
            //Get all countries
            $optionVO = $countryDAO->getCountries(); //getData
            break;
        //State case
        case "State":
            //Load State VO and DAO files
            include '/VO/StateVO.php';
            include '/DAO/StateDAO.php';
            $stateDAO = new stateDAO();
            //Get all states of a country
            $optionVO = $stateDAO->getAllByCountry($parentId); //getData
            break;
        //City case
        case "City":
            //Load City VO and DAO files
            include '/VO/CityVO.php';
            include '/DAO/CityDAO.php';
            $cityDAO = new CityDAO();
            //Get all cities of a state
            $optionVO = $cityDAO->getAllByState($parentId); //getData
            break;
        //University case
        case "University":
            //Load Univeristy VO and DAO files
            include '/VO/UniversityVO.php';
            include '/DAO/UniversityDAO.php';
            $universityDAO = new universityDAO();
            //Get all universities
            $optionVO = $universityDAO->getUniversities(); //getData
            break;
        //Department case
        case "Department":
            //Load Department VO and DAO files
            include '/VO/DepartmentVO.php';
            include '/DAO/DepartmentDAO.php';
            $departmentDAO = new DepartmentDAO();
            //Get all departments of a university
            $optionVO = $departmentDAO->getAllByUniversity($parentId); //getData
            break;
    }
    $result = "";
    //Send all <select> info separated by ';'
    for($i = 0; $i < count($optionVO); $i++) {
        $result = $result . $optionVO[$i]->toString() . ';';
    }
    echo $result;
 ?>
