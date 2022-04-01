<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try{
        $firstName = $_POST["first-name"];
        $lastName = $_POST["last-name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $checkbox = $_POST["checkbox"];



        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        if(empty($password) or empty($email) or empty($firstName)or empty($lastName)){
            header("location: ../sign-up.html?error=Empty%20input");
            exit();
        }
        if(!isset($checkbox)){
            header("location: ../sign-up.html?error=Please%20accept%20terms%20and%20conditions");
            exit();
        }
        if(invalidEmail($email) !== false){
            header("location: ../sign-up.html?error=Invalid%20email");
            exit();
        }
        if(strlen($password)<8){
            header("location: ../sign-up.html?error=Password%20is%20too%20short");
            exit();
        }
        if(uidEmailExists($conn,$email) !== false){
            header("location: ../sign-up.html?error=That%20email%20already%20exists");
            exit();
        }
        
        createUser($conn,$firstName,$lastName,$email,$password);
        mysqli_close($conn);
        header("location: ../sign-in.html");

    }
    catch (exception $e) {
        echo "Error in register.inc.php: " . $e;
    }
}
else{
    header("location: ../register.html");
}
