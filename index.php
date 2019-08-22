<?php
session_start();

//Reglage de l'heure
date_default_timezone_set('Europe/Paris');

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
require('controleur/backend.php');

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
        authentification($twig, $id);
        break;
    case 'verification':
        $nickname = $_POST['nickname'];
        $mdp = $_POST['mdp'];
        verification($twig, $nickname, $mdp, $id);
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
        registration($twig, $firstname, $lastname, $nickname, $email, $password, $confirm, $id);
        break;
    case 'forgot':
        require('mail/forgot.php');
        $email_address = strip_tags(htmlspecialchars($_POST['email']));
        forgot($twig, $email_address);
        break;
    case 'reset':
        $key = $_GET['key'];
        $hashed = $_GET['hashed'];
        resetpwd($twig, $hashed, $key);
        break;
    case 'reseted':
        require('mail/forgot.php');
        $mdp = $_POST['mdp'];
        $confirm = $_POST['confirm'];
        $nickname = $_GET['nickname'];
        $hashed = $_GET['hashed'];
        $name = $_GET['name'];
        reseted($twig, $mdp, $confirm, $nickname, $hashed, $name);
        break;
    case 'bo':
        bo($twig);
        break;
    case 'addarticle':
        $title=$_POST['title'];
        $chapo=$_POST['chapo'];
        $content=$_POST['content'];
        $id=$_GET['id'];
        addArticle($twig, $title, $chapo, $content, $id);
        break;
    default:
        accueil($twig);
}

//Tous les cookies utilisés sur ce site sont exemptés d'accords de l'utilisateur, il est donc contre-professionnel de charger le site inutilement avec ça
//https://www.cnil.fr/fr/cookies-comment-mettre-mon-site-web-en-conformite
