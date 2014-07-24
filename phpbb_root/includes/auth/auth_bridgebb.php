<?php

if (!defined('IN_PHPBB')) {
    exit;
}
define('LARAVEL_URL', 'http://www.example.com/');
define('BRIDGEBB_API_KEY', "yoursecretapikey");

require __DIR__ . '/bridgebb/BridgeBBDBAL.php';
require __DIR__ . '/bridgebb/BridgeBB.php';

function login_bridgebb($username, $password) {
    return Bridgebb::login($username, $password);
}

function user_row_bridgebb($username, $password) {
    return Bridgebb::createUserRow($username, $password);
}

function logout_bridgebb() {
    //TODO
}

function validate_session_bridgebb() {
    //TODO
}

function init_bridgebb() {
    //TODO: Setup this auth service
}

function autologin_bridgebb() {
    //TODO
}
