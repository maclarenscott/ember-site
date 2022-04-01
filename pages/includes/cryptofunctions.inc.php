<?php 
include_once("dbh.inc.php");

function fetchRecentOrders($conn,$id, $limit){
    $sql = "SELECT * FROM orders WHERE sender_id = ? or rec_id = ? LIMIT ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../dashboard.php?error=Server%20Error:%20can't%20connect%20to%20database");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $id,$id,$limit);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    // $ret = mysqli_fetch_array($resultData);
    // mysqli_stmt_close($stmt);
    // return $ret;

    $orders = array();

    while($row = mysqli_fetch_assoc($resultData)) {
        array_push($orders,$row);
    }
    return array_reverse($orders);
}

function roundDecimal($strval, $precision = 2) {
    $val = $strval;
    if ($precision < 0) { $precision = 0; }
    $numPointPosition = intval(strpos($val, '.'));
    if ($numPointPosition === 0) { //$val is an integer
        return $val;
    }
    return floatval(substr($val, 0, $numPointPosition + $precision + 1));
}

function get_holdings($conn,$id){
    try {
        $sql = "SELECT * FROM portfolios WHERE id = ? LIMIT 1;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../dashboard.php?error=Server%20Error:%20can't%20connect%20to%20database");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultData);
        // $row = mysqli_fetch_assoc($resultData);
        mysqli_stmt_close($stmt);
        if ($row) {
            return $row;
        } else {
            $result = false;
            return $result;
        }

    } catch (exception $e) {
        header("location: ../register.html?error=Server%20Error:%20couldn't%20check%20if%20email%20exists");
    }
}

function time2str($ts)
{
    if(!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if($diff == 0)
        return 'now';
    elseif($diff > 0)
    {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 60) return 'just now';
            if($diff < 120) return '1 minute ago';
            if($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if($diff < 7200) return '1 hour ago';
            if($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if($day_diff == 1) return 'Yesterday';
        if($day_diff < 7) return $day_diff . ' days ago';
        if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
        if($day_diff < 60) return 'last month';
        return date('F Y', $ts);
    }
    else
    {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 120) return 'in a minute';
            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
            if($diff < 7200) return 'in an hour';
            if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
        }
        if($day_diff == 1) return 'Tomorrow';
        if($day_diff < 4) return date('l', $ts);
        if($day_diff < 7 + (7 - date('w'))) return 'next week';
        if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
        if(date('n', $ts) == date('n') + 1) return 'next month';
        return date('F Y', $ts);
    }
}

// echo get_holdings($conn,1)["eth"];

// print_r(fetchRecentOrders($conn,1,10));
// foreach(fetchRecentOrders($conn,1,10) as $order){
//     print_r($order["sender_id"]);
// }