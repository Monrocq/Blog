<?php
session_start();

//Chargement des librairies
require('vendor/autoload.php');

//Instanciation de twig et chargement des templates
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, ['cache' => false, 'debug'=>true]);
$twig->addExtension(new Twig_Extension_Debug);
$twig->addGlobal('session', $_SESSION);

//Autoloader des classes
require('autoloader.php');
Autoloader::register();

//Page d'accueil
require('controleur/frontend.php');

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } elseif (isset($_COOKIE['page'])) {
        $page = $_COOKIE['page'];
    } else {
        $page = 1;
    }
    if (isset($_GET['commentpage'])) {
        $commentpage = $_GET['commentpage'];
    } elseif (isset($_COOKIE['commentpage'])) {
        $commentpage = $_COOKIE['commentpage'];
    } else {
        $commentpage = 1;
    }
    //$id = l'id du Post
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
        single($twig, $id, $page, $commentpage);
        break;
    case 'addcomment':
        $content = $_POST['content'];
        addComment($id, $content);
        break;
    case 'deletecomment':
        $comment = $_GET['comment'];
        deleteComment($id, $comment);
        break;
    case 'updatecomment':
        $comment = $_GET['comment'];
        $content = $_POST['content'];
        updateComment($id, $comment, $content);
        break;
    case 'authentification':
        authentification($twig);
        break;
    case 'verification':
        $nickname = $_POST['nickname'];
        $mdp = $_POST['mdp'];
        verification($twig, $nickname, $mdp);
        break;
    case 'deconnexion':
        deconnexion();
        break;
    case 'connected':
        $connected = "connected";
        accueil($twig, $connected);
        break;
    case 'register':
        $firstname = $_POST['firstname'];
        $lastname = $_POST['surname'];
        $nickname = $_POST['nickname'];
        $email = $_POST['email'];
        $password = $_POST['mdp'];
        $confirm = $_POST['confirm'];
        registration($twig, $firstname, $lastname, $nickname, $email, $password, $confirm);
        break;
    default:
        accueil($twig);
}

