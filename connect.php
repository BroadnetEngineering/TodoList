<?php
require_once 'dbconfig.php';
 
    $dsn= "mysql:host=$host;dbname=$db";
    try{
        // create a PDO connection with the configuration data
        $con = new PDO($dsn, $username, $password);
        // display a message if connected to database successfully
        if($con){
        // successfully connected!
        }
    }catch (PDOException $e){
        // report error message
        echo $e->getMessage();
    }

?>