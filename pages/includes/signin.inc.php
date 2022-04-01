<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $email = $_POST["email"];
        $password = $_POST["password"];

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';

        if (empty($password) or empty($email)) {
            header("location: ../sign-in.html?error=Empty%20input");
            exit();
        }


        // log in user

        loginUser($conn, $email, $password);
        mysqli_close($conn);
    } catch (exception $e) {
        echo "Error in login.inc.php: " . $e;
        mysqli_close($conn);
    }
} else {
    header("location: ../login.html");
    exit();
}
