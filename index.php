<?php

//Chargement des librairies
require('vendor/autoload.php');

//Instanciation de twig et chargement des templates
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, ['cache' => false, 'debug'=>true]);
$twig->addExtension(new Twig_Extension_Debug);



//Page d'accueil
require('controleur/frontend.php');

