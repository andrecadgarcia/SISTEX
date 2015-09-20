<?php
    //Include DAO and VO for author
    include '/VO/AuthorVO.php';
    include '/DAO/AuthorDAO.php';
    
    //Get all data from http
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    
    //Separate data in diferent variables
    @$name = $request->name;
    @$email = $request->email;
    @$pass = $request->password;
    @$address = $request->address;
    @$id = $request->id;
    @$id_city = $request->id_city;
    @$id_department = $request->id_department;
    @$photo = $request->photo;
    
    //Create an author with all info from http
    $authorVO = new AuthorVO('', $name, $email, $pass, $address, $id, $id_city, $id_department, $photo);
    $authorDAO = new AuthorDAO();
    
    //Save author in DB and echo its return
    echo $authorDAO->save($authorVO);
?>
