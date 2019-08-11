<?php

//Chargement des librairies
require('vendor/autoload.php');

//Instanciation de twig et chargement des templates
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, ['cache' => false, 'debug'=>true]);
$twig->addExtension(new Twig_Extension_Debug);

//Autoloader des classes
require('autoloader.php');
Autoloader::register();

//Page d'accueil
require('controleur/frontend.php');

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = '0';
    }
} else {
    $action = 'accueil';
}

switch ($action) {
    case 'articles':
        liste($twig, $page);
        break;
    case 'single':
        single($twig, $id, $page);
        break;
    default:
        accueil($twig);
}

