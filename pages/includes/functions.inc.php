<?php
// Verification functions, return true if invalid



function refreshDashboard($conn){
    $account = proxyAccount($conn, $_SESSION['email']);

    $status = $account["active"];
    $proxies = $account["plans"];
    $startTime = date_create();
    $endTime = new DateTime($account["endTime"]);//end time

    $remainingTime = $startTime->diff($endTime);

    if($status === '1'){
        $status = 'Active';
    }
    else{
        $status = 'Inactive';
    }
    $proxiesNumber;
    $concurrentConnections;
    if($proxies === 'premium' ){
        $concurrentConnections = '500/500';
        $proxiesNumber = '50000+';
    }
    else if($proxies === 'advanced'){
        $concurrentConnections = '500/500';
        $proxiesNumber = '20000';
    }
    else{
        $concurrentConnections = '100/500';
        $proxiesNumber = '1000';
    }
    $preIps = $account["premiumIPs"];
    $advIps = $account["advancedIPs"];
    $trialIps = $account["trialIPs"];
    $ips;

    if(strlen($trialIps) > 1){
        $ips = $trialIps;
    }
    else if(strlen($advIps) > 1){
        $ips = $advIps;
    }
    else{
        $ips = $preIps;
    }

    $map = [
        "account" => $account,
        "status" => $status,
        "proxies" => $proxies,
        "remainingTime" => $remainingTime,
        "proxiesNumber" => $proxiesNumber,
        "concurrentConnections" => $concurrentConnections,
        "ips"=>$ips,
    ];
    return $map;
}

function emptyInputLogin($username, $password)
{
    $result = true;
    if (empty($username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function emptyInputSignup($email, $password)
{
    $result;
    if (empty($email) || empty($username) || empty($password) || empty($passwordRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


function invalidEmail($email)
{
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordMatch($password, $passwordRepeat)
{
    return $password !== $passwordRepeat;
}


// checks if username or email already exists
function uidEmailExists($conn, $email)
{
    try {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../sign-up.html?error=Server%20Error:%20can't%20connect%20to%20database");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);
        if ($row) {
            return $row;
        } else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    } catch (exception $e) {
        header("location: ../register.html?error=Server%20Error:%20couldn't%20check%20if%20email%20exists");
    }
}
function proxyAccount($conn, $email)
{
    try {
        $sql = "SELECT * FROM proxyusers WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../register.html?error=Server Error: can't connect to database");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);
        if ($row) {
            return $row;
        } else {
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
    } catch (exception $e) {
        header("location: ../register.html?error=Server Error: couldn't check if email exists");
    }
}
function createUser($conn,$firstName,$lastName, $email, $password)
{
    try {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (first_name,last_name,email, password) VALUES (?,?,?,?);");
        $stmt->bind_param("ssss", $firstName, $lastName,$email, $hashedPassword);
        $stmt->execute();

        $uidEmailExists = uidEmailExists($conn, $email);

        //Creates portfolio
        $stmt = $conn->prepare("INSERT INTO portfolios (id,btc,eth, doge) VALUES (?,0,0,0);");
        $stmt->bind_param("s", $uidEmailExists["id"]);
        $stmt->execute();


        //Returns user profile
        

        header("location: ../sign-in.html");
    } catch (\Error $e) {
        echo "Server error: couldn't create user.";
    }
}
function loginUser($conn, $email, $password)
{
    $uidEmailExists = uidEmailExists($conn, $email);

    if ($uidEmailExists === false) {
        header("location: ../sign-in.html?error=Unable%20to%20find%20a%20matching%20account");
    }

    $hashedPassword = $uidEmailExists["password"];
    $checkPassword = password_verify($password, $hashedPassword);

    if ($checkPassword === false) {
        header("location: ../sign-in.html?error=Incorrect%20username%20or%20password");
    } else if ($checkPassword === true) {
        session_start();
        $_SESSION["email"] = $uidEmailExists["email"];
        $_SESSION["id"] = $uidEmailExists["id"];
        $_SESSION["first_name"] = $uidEmailExists["first_name"];
        $_SESSION["last_name"] = $uidEmailExists["last_name"];
        // header("location: ../home.html?name=" . $uidEmailExists["email"]);
        header("location: ../dashboard.php?name=" . $_SESSION["email"]);
    }
}

