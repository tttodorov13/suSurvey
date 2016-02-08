<?php

date_default_timezone_set('Europe/Sofia');

// include the classes
require_once ROOT_DIR . 'functions/functions.php';
require_once ROOT_DIR . 'class/Error.php';
require_once ROOT_DIR . 'class/Info.php';
require_once ROOT_DIR . 'class/BaseObject.php';
require_once ROOT_DIR . 'class/Answer.php';
require_once ROOT_DIR . 'class/Group.php';
require_once ROOT_DIR . 'class/Survey.php';
require_once ROOT_DIR . 'class/SurveyFunctions.php';
require_once ROOT_DIR . 'class/User.php';
require_once ROOT_DIR . 'class/Vote.php';
require_once ROOT_DIR . 'class/Message.php';
require_once ROOT_DIR . 'class/Question.php';

// connect to data_base
try {
    $db = new PDO('mysql:host=localhost;dbname=survey', 'survey', 'survey');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES utf8");
} catch (Exception $e) {
    error($e->getMessage());
}

// get current IP and set connection according to it
$ldapRdn = "";
$ldapPass = "";
try {

    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    $ldapRdn .= 'uid=ldapUser,ou=ldapGroup,dc=ldapCompany,dc=bg';
    $ldapPass .= 'ldapPass';
} catch (Exception $ex) {
    error($ex->getMessage());
}

// include functions file
require_once ROOT_DIR . 'functions/functions.php';

if (isset($_SESSION['user'])) {
    $user = new User();
    $user = unserialize($_SESSION['user']);
} else {
    $user = null;
}
