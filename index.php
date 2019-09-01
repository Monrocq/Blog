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

//Page d'accueil
require('controleur/frontend.php');

if (isset($_SESSION['connected'])) {
    $lvl = $_SESSION['lvl'];
} else {
    $lvl = 1;
}

if ($lvl > 1) {
    require('controleur/backend.php');
} else {
    require('controleur/exceptions.php');
}


if (isset($_GET['action'])) {
    $action = htmlspecialchars($_GET['action']);
    if (isset($_GET['page'])) {
        $page = htmlspecialchars($_GET['page']);
    } elseif (isset($_COOKIE['page'])) {
        $page = htmlspecialchars($_COOKIE['page']);
    } else {
        $page = 1;
    }
    if (isset($_GET['commentpage'])) {
        $commentpage = htmlspecialchars($_GET['commentpage']);
    } elseif (isset($_COOKIE['commentpage'])) {
        $commentpage = htmlspecialchars($_COOKIE['commentpage']);
    } else {
        $commentpage = 1;
    }
    //$id = l'id du Post
    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
    } else {
        $id = '0';
    }
} else {
    $action = 'accueil';
}

//Autoloader des classes
require('autoloader.php');
Autoloader::register();

try {
switch ($action) {
    case 'articles':
        liste($twig, $page);
        break;
    case 'single':
        if (isset($_GET['commentadded'])) {
            $commentadded = htmlspecialchars($_GET['commentadded']);
        } else {
            $commentadded = 'no';
        }
        single($twig, $id, $page, $commentpage, $commentadded);
        break;
    case 'addcomment':
        $content = htmlspecialchars($_POST['content']);
        addComment($id, $content);
        break;
    case 'deletecomment':
        $comment = htmlspecialchars($_GET['comment']);
        deleteComment($id, $comment);
        break;
    case 'updatecomment':
        $comment = htmlspecialchars($_GET['comment']);
        $content = htmlspecialchars($_POST['content']);
        updateComment($id, $comment, $content);
        break;
    case 'authentification':
        authentification($twig, $id);
        break;
    case 'verification':
        $nickname = htmlspecialchars($_POST['nickname']);
        $mdp = htmlspecialchars($_POST['mdp']);
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
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['surname']);
        $nickname = htmlspecialchars($_POST['nickname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['mdp']);
        $confirm = htmlspecialchars($_POST['confirm']);
        registration($twig, $firstname, $lastname, $nickname, $email, $password, $confirm, $id);
        break;
    case 'forgot':
        require('mail/forgot.php');
        $email_address = strip_tags(htmlspecialchars($_POST['email']));
        forgot($twig, $email_address);
        break;
    case 'reset':
        $key = htmlspecialchars($_GET['key']);
        $hashed = htmlspecialchars($_GET['hashed']);
        resetpwd($twig, $hashed, $key);
        break;
    case 'reseted':
        require('mail/forgot.php');
        $mdp = htmlspecialchars($_POST['mdp']);
        $confirm = htmlspecialchars($_POST['confirm']);
        $nickname = htmlspecialchars($_GET['nickname']);
        $hashed = htmlspecialchars($_GET['hashed']);
        $name = htmlspecialchars($_GET['name']);
        reseted($twig, $mdp, $confirm, $nickname, $hashed, $name);
        break;
    case 'bo':
        bo($twig);
        break;
    case 'addarticle':
        $title = htmlspecialchars($_POST['title']);
        $chapo = htmlspecialchars($_POST['chapo']);
        $content = htmlspecialchars($_POST['content']);
        $id = htmlspecialchars($_GET['id']);
        addArticle($twig, $title, $chapo, $content, $id);
        break;
    case 'deletearticle':
        $article = htmlspecialchars($_GET['article']);
        deleteArticle($twig, $article);
        break;
    case 'updatearticle':
        $title = htmlspecialchars($_POST['title']);
        $chapo = htmlspecialchars($_POST['chapo']);
        $content = htmlspecialchars($_POST['content']);
        $id = htmlspecialchars($_GET['id']);
        updateArticle($twig, $title, $chapo, $content, $id);
        break;
    case 'validate':
        $comment = htmlspecialchars($_GET['comment']);
        validate($comment);
        break;
    case 'change':
        $role = htmlspecialchars($_GET['role']);
        $user = htmlspecialchars($_GET['user']);
        change($role, $user);
        break;
    case '404':
        error404($twig);
        break;
    default:
        accueil($twig);
}
}

catch (Exception $e) // Nous allons attraper les exceptions "Exception" s'il y en a une qui est levée.
{
  echo 'Une exception a été lancée. Message d\'erreur : ', $e->getMessage();
}

//Tous les cookies utilisés sur ce site sont exemptés d'accords de l'utilisateur, il est donc contre-professionnel de charger le site inutilement avec ça
//https://www.cnil.fr/fr/cookies-comment-mettre-mon-site-web-en-conformite
