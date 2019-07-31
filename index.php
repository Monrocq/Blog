<?php

//Chargement des librairies
require('vendor/autoload.php');

//Instanciation de twig et chargement des templates
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, ['cache' => false, 'debug'=>true]);
$twig->addExtension(new Twig_Extension_Debug);

//Autoloader des classes
require('vendor/autoloader.php');
Autoloader::register();

//Page d'accueil
require('controleur/frontend.php');

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'accueil';
}

switch ($page) {
    case 'articles':
        liste($twig);
        break;
    default:
        accueil($twig);
}

