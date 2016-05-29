<?php
$host = 'localhost';
$user = 'marvin';
$pass = 'marva112';
$db = 'mp3';

$con = mysqli_connect($host, $user, $pass, $db) or die("yhendus andmebaasiga ei õnnestunud..");
mysqli_query($con, 'SET CHARACTER SET UTF8');

if(mysqli_connect_error()) {
    echo mysqli_connect_error();
}


function user_add_model($username,$password) {

    global $con;

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO kasutajad (nimi, parool) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'ss', $username, $hash);
    mysqli_stmt_execute($stmt);

    $id = mysqli_stmt_insert_id($stmt);

    mysqli_stmt_close($stmt);
    return $id;
}

function user_get_model($username, $password) {
    global $con;

    $query = "SELECT id, parool FROM kasutajad WHERE nimi=? LIMIT 1";

    $stmt = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $id, $hash);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (password_verify($password, $hash)) {
        return $id;
    }

    return false;
}

function model_search($search) {
    global $con;

    $query = "SELECT Id, Name, Title, Artist, Album FROM muusika WHERE Name LIKE ?";
    $stmt = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    $search = "%$search%";

    mysqli_stmt_bind_param($stmt, 's', $search);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result)==0) {
        return false;
    }

    $results=array();

    while ($row = mysqli_fetch_assoc($result)) {
        if(!empty($row)) {
            $results[]=$row;
        }
    }

    $_SESSION['search']=$results;

    //print_r($results);

    mysqli_free_result($result);
    return true;
}

function model_getSearch() {
    if(!empty($_SESSION['search'])) {
        $results = $_SESSION['search'];
        $_SESSION['search'] = array();
        return $results;
    }
    return array();
}

?>