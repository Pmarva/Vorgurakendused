<?php
function controller_register($username, $password, $password2) {
    if ($username == '' || $password == '' || $password2 == '' || $password!=$password2) {
        message_add('Vigased sisendandmed','error');
        return false;
    }
    if (user_add_model($username, $password)) {
        message_add('Konto on registreeritud','success');
        return true;
    }
    message_add('Konto registreerimine ebaõnnestus, kasutajanimi võib olla juba võetud','error');
    return false;
}


function controller_login($username, $password) {
    if ($username == '' || $password == '') {
        message_add('Vigased sisendandmed','error');
        return false;
    }
    $id = user_get_model($username, $password);
    if (!$id) {
        message_add('Vigane kasutajanimi või parool','error');
        return false;
    }
    session_regenerate_id();
    $_SESSION['login'] = $id;
    message_add('Oled nüüd sisse logitud','success');
    return $id;
}

function controller_logout() {
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    $_SESSION = array();

    session_destroy();
    message_add('Oled nüüd välja logitud','success');
    return true;
}

function controller_user() {
    if (empty($_SESSION['login'])) {
        return false;
    }
    return $_SESSION['login'];
}

function message_add($message, $status) {
    if (empty($_SESSION['messages'])) {
        $_SESSION['messages'] = array();
    }

    if($status=='success') {
        $message = "<div class=\"alert alert-success fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>$message</div>";
    } elseif ($status=='error') {
        $message = "<div class=\"alert alert-danger fade in\"><a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a><strong>Viga!</strong>$message</div>";
    }

    $_SESSION['messages'][] = $message;
}

function message_list() {
    if (empty($_SESSION['messages'])) {
        return array();
    }
    $messages = $_SESSION['messages'];
    $_SESSION['messages'] = array();
    return $messages;
}


function controller_search($search) {

    if(strlen($search)<4) {
        message_add('Otsing peab olema pikem kui 3 tähte','error');
        return false;
    } else {
        $result =  model_search($search);

        if(!$result) {
            message_add('Sellise otsinguga lugusid ei leitud','error');
        }
        return $result;
    }
}

?>