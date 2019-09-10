<?php

//Homeview
function accueil($twig, $connected = "not") 
{
    echo $twig->render('homeView.twig', array('titre' => 'Ballinity - Home', 'connected' => $connected));
}

//Page d'authentification
function authentification($twig, $id)
{
    echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'standby', 'id' => $id));
}

//Création d'une nouvelle session
function verification($twig, $nickname, $mdp, $id = 0)
{
    $pwd = new Session($nickname, $mdp);
    if ($_SESSION['connected'] === true) {
        if ((int)$id > 0) {
            header("Location: index.php?action=single&id=$id");
        } else {
            header('Location: index.php?action=accueil');
        }
    } else {
        echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'fail'));
    }
}

//Déconnexion
function deconnexion()
{
    session_destroy();
    header('Location: index.php?action=accueil');
}

//Inscription
function registration($twig, $firstname, $lastname, $nickname, $email, $password, $confirm, $id)
{
    if ($password === $confirm) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userMapper = new UserManager;
        $mailexists = $userMapper->verifMail($email);
        if ($mailexists == false) {
            $nickexists = $userMapper->verifNick($nickname);
            if ($nickexists == false) {
                $datatocheck = ['firstname' => $firstname, 'lastname' => $lastname, 'nickname' => $nickname, 'email' => $email];
                $filters = ['firstname' => 'trim|escape|capitalize', 'lastname' => 'trim|escape|capitalize', 'nickname' => 'trim|escape|lowercase', 'email' => 'trim|escape|lowercase'];
                $userMapper->registration($datatocheck, $filters, $hash);
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

//Envoie d'un mail de réinitialisation de MDP
function forgot($twig, $email) 
{
    if(empty($email) 		||
            !filter_var($email,FILTER_VALIDATE_EMAIL)) {
                echo "No arguments Provided!";
                return false;
        }
    $userMapper = new UserManager;
    echo $userMapper->forgot($twig, $email);
}

//Affiche la page de réinitialisation
function resetpwd($twig, $hashed, $key) 
{
    $userMapper = new UserManager;
    echo $userMapper->resetPwd($twig, $hashed, $key);
}

//Validation du formulaire de changement de MDP
function reseted($twig, $mdp, $confirm, $nickname, $hashed, $name)
{
    if ($mdp !== $confirm) {
        echo $twig->render('reset.twig', array('hashed' => $hashed, 'name' => $name, 'state' => 'fail', 'nickname' => $nickname));
    } else {
        $userMapper = new UserManager;
        $ok = $userMapper->backupPwd($nickname);
        if ($ok[0] === $hashed) {
            $userMapper->boum($nickname, $confirm);
            sendConfirmation($nickname);
            verification($twig, $nickname, $mdp);
            } else {
            echo "Vous avez déjà réinitialisé votre mot de passe, recommencez l'opération si vous l'avez encore oublié";
        }
    }
}

//Liste les articles
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

//La page d'un article seul
function single($twig, $id, $page = 1, $commentpage = 1, $commentadded = '')
{
    setcookie('page', $page); //Pour éviter de se trimbaler $page à chaque fois qu'on CRUD un commentaire
    setcookie('commentpage', $commentpage);
    $postMapper = new PostManager;
    $article = $postMapper->getArticle($id);
    $comments = $article->getComments($commentpage);
    $nbcomments = $article->getNbComments();
    $pages = pagination($nbcomments[0]);
    echo $twig->render('singlePost.twig', array(
        'titre' => 'Ballinity - '.$article->getTitle(), 
        'article' => $article, 
        'page' => $page, 
        'comments' => $comments, 
        'id' => $id, 
        'pages' => $pages, 
        'commentpage' => $commentpage,
        'commentadded' => $commentadded
    ));
}

//Ajoute un commentaire
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
        $commentadded = 'no';
        $comment--; //Vu que la navbar est en fixe, il faut décaller
        while ($commentMapper->commentExists($comment, $id)->fetch() == false) //Afin de s'assurer de tomber sur un bon ID
        {
            $comment--; 
        }
    } else {
        $commentadded = 'yes';
    }
    return "Location: index.php?action=single&id=$id&commentadded=$commentadded#comment$comment";
}

//Supprime un commentaire
function deleteComment($id = 0, $comment)
{
    $commentMapper = new CommentManager;
    $type = 'delete';
    $delete = $commentMapper->deleteComment($comment);
    if ($id != 0) {
        $urlcomment = urlcomment($id, $comment, $type);
        header($urlcomment);
    } else {
        header('Location: index.php?action=bo');
    }
}

//MAJ un commentaire
function updateComment($id, $comment, $content)
{
    $commentMapper = new CommentManager;
    $type = 'delete';
    $commentMapper->updateComment($comment, $content);
    $urlcomment = urlcomment($id, $comment, $type='update');
    header($urlcomment);
}

//Page default d'une 404
function error404($twig)
{
    echo $twig->render('404.twig');
}
