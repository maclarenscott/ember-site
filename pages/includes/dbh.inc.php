<?php
try{
    if(isset($conn)){
        mysqli_close($conn);
    }
    
    
    $serverName = "67.207.84.174:3306";
    $dBUserName = "conn";
    $dBPassword = "hubHBHFU2839?!";
    $dBName = "accounts";

    // // Create connection
    // $conn = new mysqli($serverName, $dBUserName, $dBPassword);

    // // Check connection
    // if ($conn->connect_error) {
    // die("Connection failed: " . $conn->connect_error);
    // }
    // echo "Connected successfully";

    $conn = mysqli_connect($serverName,$dBUserName,$dBPassword,$dBName);
    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
}
catch (exception $e) {
    echo $e;
}