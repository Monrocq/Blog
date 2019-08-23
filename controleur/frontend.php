<?php

function accueil($twig, $connected = "not") 
{
    echo $twig->render('homeView.twig', array('titre' => 'Ballinity - Home', 'connected' => $connected));
}

function authentification($twig, $id)
{
    echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'standby', 'id' => $id));
}

function verification($twig, $nickname, $mdp, $id = 0)
{
    $pwd = new Session($nickname, $mdp);
    if ($_SESSION['connected'] === true) {
        if ((int)$id > 0) {
            header("Location: index.php?action=single&id=$id");
        } else {
            header('Location: index.php');
        }
    } else {
        echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'fail'));
    }
}

function deconnexion()
{
    session_destroy();
    header('Location: index.php');
}

function registration($twig, $firstname, $lastname, $nickname, $email, $password, $confirm, $id)
{
    if ($password === $confirm) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $db = new db;
        $mailexists = $db->req("SELECT * FROM users WHERE email='$email'")->fetch();
        if ($mailexists == false) {
            $nickexists = $db->req("SELECT * FROM users WHERE nickname='$nickname'")->fetch();
            if ($nickexists == false) {
                $db->req("INSERT INTO users(name, firstname, nickname, email, password, lvl) VALUES ('$lastname', '$firstname', '$nickname', '$email', '$hash', '1')");
                verification($twig, $nickname, $confirm, $id);
            } else {
                echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'failed', 'failed' => 'nick'));
            }
        } else {
            echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'failed', 'failed' => 'email'));
        }
    } else {
        echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'failed', 'failed' => 'mdp'));
    }
}

function forgot($twig, $email) 
{
    if(empty($email) 		||
            !filter_var($email,FILTER_VALIDATE_EMAIL)) {
                echo "No arguments Provided!";
                return false;
        }
    $db = new db;
    $exists = $db->req("SELECT * FROM users WHERE email = '$email'")->fetch();
    if ($exists == false) {
        echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'unknown'));
    } else {
    $datetime = new DateTime;
    $datetime->setTimezone(new DateTimeZone('Europe/Paris'));
    $datetime->add(new DateInterval('PT02H03M27S'));
    $expiration = $datetime->format('Y-m-d H:i:s');
    $db->req("UPDATE users SET reset='$expiration' WHERE email='$email'");
    sendforgot($email, $expiration);
    echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'known'));
    
    }
}

function resetpwd($twig, $hashed, $key) 
{
    $db = new db;
    $name = $db->req("SELECT firstname, nickname FROM users WHERE password = '$hashed'")->fetch();
    $expiration = $db->req("SELECT reset FROM users WHERE nickname='{$name[1]}'")->fetch();
    if ((hash('sha256', $expiration[0]) == $key) && ($expiration[0] > date("Y-m-d H:i:s"))) {
        echo $twig->render('reset.twig', array('hashed' => $hashed, 'name' => $name[0], 'state' => 'standby', 'nickname' => $name[1]));
    } else {
        echo "Oups, ce lien n'est plus valide";
    }
}

function reseted($twig, $mdp, $confirm, $nickname, $hashed, $name)
{
    if ($mdp !== $confirm) {
        echo $twig->render('reset.twig', array('hashed' => $hashed, 'name' => $name, 'state' => 'fail', 'nickname' => $nickname));
    } else {
        $db = new db;
        $ok = $db->req("SELECT password FROM users WHERE nickname = '$nickname'")->fetch();
        if ($ok[0] === $hashed) {
            $newhashed = password_hash($confirm, PASSWORD_DEFAULT);
            $replace = $db->req("UPDATE users SET password='$newhashed' WHERE nickname='$nickname'");
            sendConfirmation($nickname);
            verification($twig, $nickname, $mdp);
            } else {
            echo "Vous avez déjà réinitialisé votre mot de passe, recommencez l'opération si vous l'avez encore oublié";

        }
    }
}

function liste($twig, $page = 1) 
{
    $postMapper = new PostManager;
    $articles = $postMapper->getList($page);
    $nbarticles = $postMapper->getNbArticles();
    $pages = pagination($nbarticles[0]);
    echo $twig->render('listPosts.twig', array('titre' => 'Ballinity - Articles', 'articles' => $articles, 'pages' => $pages, 'page' => $page));
}

//OUI à la factorisation!
function pagination($nb) {
    $numpage = 0;
    $pages = array();
    for ($i = (int)$nb; $i > 0; $i -= 5) {
        $numpage++;
        $pages[] = $numpage;
    }
    if (empty($pages)) {
        $pages[] = 1;
    }
    return $pages;
}

function single($twig, $id, $page = 1, $commentpage = 1)
{
    setcookie('page', $page); //Pour éviter de se trimbaler $page à chaque fois qu'on CRUD un commentaire
    setcookie('commentpage', $commentpage);
    $postMapper = new PostManager;
    $article = $postMapper->getArticle($id);
    $comments = $article->getComments($commentpage);
    $nbcomments = $article->getNbComments();
    $pages = pagination($nbcomments[0]);
    echo $twig->render('singlePost.twig', array('titre' => 'Ballinity - '.$article->getTitle(), 'article' => $article, 'page' => $page, 'comments' => $comments, 'id' => $id, 'pages' => $pages, 'commentpage' => $commentpage));
}

function addComment($id, $content) 
{
    $commentMapper = new CommentManager;
    $type = 'add';
    $commentMapper->addComment($id, $content);
    $hashtag = $commentMapper->lastComment($id);
    $urlcomment = urlcomment($id, $hashtag[0], $type);
    setcookie('commentpage', 1);
    header($urlcomment);
}

//URL de redirection après modif' ou suppression
function urlcomment($id, $comment, $type) {
    $commentMapper = new CommentManager;
    if ($type !== 'add') {
        $comment++; //Vu que la navbar est en fixe, il faut décaller
        while ($commentMapper->commentExists($comment, $id)->fetch() == false) //Afin de s'assurer de tomber sur un bon ID
        {
            $comment++; 
        }
    }
    return "Location: index.php?action=single&id=$id#comment$comment";
}

function deleteComment($id, $comment)
{
    $commentMapper = new CommentManager;
    $type = 'delete';
    $delete = $commentMapper->deleteComment($comment);
    $urlcomment = urlcomment($id, $comment, $type);
    header($urlcomment);
    //var_dump($delete);
}

function updateComment($id, $comment, $content)
{
    $commentMapper = new CommentManager;
    $type = 'delete';
    $commentMapper->updateComment($comment, $content);
    $urlcomment = urlcomment($id, $comment, $type='update');
    header($urlcomment);
}

