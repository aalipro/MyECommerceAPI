<?php
    // error_reporting(E_ALL & ~E_NOTICE);

    // // Set error display to off
    // ini_set('display_errors', 0);
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header("Content-Type: application/json");
    header('Access-Control-Allow-Headers: X-Requested-With');
    require_once('./CONFIG/connexion.php');
    require_once('./CONTROLLER/ControleurObjet.php');
    require_once("./MODEL/Objet.php");
    require_once("./MODEL/GestionAPI.php");
    require_once("./MODEL/Routeur.php");
    require_once("./MODEL/Client.php");
    require_once("./MODEL/GestionAPI.php");
    Connexion::connect();

    $router = new Routeur();
    $router->TestRouteur();
