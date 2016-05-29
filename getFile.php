<?php


if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $host = 'localhost';
    $user = 'marvin';
    $pass = 'marva112';
    $db = 'mp3';

    $con = mysqli_connect($host, $user, $pass, $db) or die("yhendus andmebaasiga ei õnnestunud..");
    mysqli_query($con, 'SET CHARACTER SET UTF8');

    $query = "SELECT Name FROM muusika WHERE Id=? LIMIT 1";

    $stmt = mysqli_prepare($con, $query);

    if (mysqli_error($con)) {
        echo mysqli_error($con);
        exit;
    }

    mysqli_stmt_bind_param($stmt, 'd', $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $location);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    $root = "/sdc1/kola/mjiusik/";
    $fileLocation = $root.$location;


    if (file_exists($fileLocation)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($fileLocation).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileLocation));
        readfile($fileLocation);
        exit;
    }


}

?>