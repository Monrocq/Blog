<?php

function accueil($twig, $connected = "not") 
{
    echo $twig->render('homeView.twig', array('titre' => 'Ballinity - Home', 'connected' => $connected));
}

function authentification($twig)
{
    echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'standby'));
}

function verification($twig, $nickname, $mdp)
{
    $pwd = new Session($nickname, $mdp);
    if ($_SESSION['connected'] === true) {
        header('Location: index.php');
    } else {
        echo $twig->render('authentification.twig', array('titre' => 'Ballinity - Authentification', 'auth' => 'fail'));
    }
}

function deconnexion()
{
    session_destroy();
    header('Location: index.php');
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

function single($twig, $id, $page = 1, $commentpage)
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

