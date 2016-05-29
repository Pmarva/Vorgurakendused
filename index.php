<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(20));
}

require "model.php";
require "controller.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $result = false;

    if (!empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
        $action = $_POST['action'];

        switch ($action) {
            case 'search':
                $result = controller_search($_POST['searchBox']);
                break;
            case 'registration':
                $username = $_POST['username'];
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                $result = controller_register($username, $password, $password2);

                if(!$result) {
                    header('Location: '.$_SERVER['PHP_SELF']."?view=registration");
                    exit;
                }

                break;
            case 'login':
                $username = $_POST['username'];
                $password = $_POST['password'];
                $result = controller_login($username, $password);
                break;
        }
    } else {
        message_add('Vigane päring, CSRF token ei vasta oodatule','error');
    }
    header('Location: '.$_SERVER['PHP_SELF']);
    // POST päringu puhul me sisu ei näita
    exit;
}


if (!empty($_GET['view']) && !controller_user()) {
    switch ($_GET['view']) {
        case 'login':
                require 'views/login.php';
            break;
        case 'registration':
                require 'views/register.php';
            break;
        case 'logout':
            $result = controller_logout();
            header('Location: '.$_SERVER['PHP_SELF']);
            break;
        default:
            header('Content-type: text/plain; charset=utf-8');
            echo 'Tundmatu valik!';
            exit;
    }
} elseif (!empty($_GET['view']) && controller_user()) {
    switch ($_GET['view']) {
        case 'logout':
            $result = controller_logout();
            header('Location: '.$_SERVER['PHP_SELF']);
            break;
        default:
            header('Location: '.$_SERVER['PHP_SELF']);
            message_add("Tundmatu päring","error");
            exit;
    }
} else {
    if (!controller_user()) {
        header('Location: '.$_SERVER['PHP_SELF'].'?view=login');
        exit;
    }
    require 'views/view.php';
}

mysqli_close($con);

?>