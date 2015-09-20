<?php
    //Include DAO and VO for author
    include '/VO/AuthorVO.php';
    include '/DAO/AuthorDAO.php';

    //Get all data from http
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    
    //Separate data in diferent variables
    @$email = $request->email;
    @$passwd = $request->passwd;

    //Create an empty author
    $authorDAO = new AuthorDAO();
    //Fetch an author by his email
    $authorVO = $authorDAO->getByEmail($email);
    
    //Store author info in Session variable
    $authorVO[0]->toSession();
    
    //If login is valid, send 'VALID'
    if($authorVO[0]->getPassword() ==  $passwd) {
       echo 'VALID';
    }
    //if not, send 'INVALID'
    else {
        echo 'INVALID';   
    }
?>
