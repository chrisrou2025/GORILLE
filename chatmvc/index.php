<?php

use MyApp\Controllers\LoginController;

require_once 'vendor/autoload.php';

// Démarre une Session
session_start();

// Stocke la racine du site (ex: C:/wamp64/www/GORILLE/chatmvc/)
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

// Stocke la racine du site (ex: http://localhost/GORILLE/chatmvc)
define('URL', 'http://localhost/GORILLE/chatmvc');

// ROUTEUR
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $params = explode('/', htmlspecialchars($_GET['action']));
    $controller = ucfirst(htmlspecialchars($params[0])) . "Controller";
    $controller = 'MyApp\Controllers\\' . $controller;
    $oController = new $controller();

    if (isset($params[1])) {
        $method = htmlspecialchars($params[1]);
        if (method_exists($oController, $method)) {
            if (isset($params[2])) {
                $oController->$method((int)$params[2]);
            } else {
                $oController->$method();
            }
        } else {
            http_response_code(404);
            echo "La page recherchée n'existe pas";
        }
    } else {
        if (method_exists($oController, 'index')) {
            $oController->index();
        } else {
            http_response_code(404);
            echo "La page recherchée n'existe pas";
        }
    }
} else {
    $oController = new LoginController();
    $oController->loginIndex();
}