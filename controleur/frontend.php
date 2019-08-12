<?php

function accueil($twig) 
{
    echo $twig->render('homeView.twig', array('titre' => 'Ballinity - Home'));
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
    $postMapper = new PostManager;
    $article = $postMapper->getArticle($id);
    $comments = $postMapper->getComments($id, $commentpage);
    $nbcomments = $postMapper->getNbComments($id);
    $pages = pagination($nbcomments[0]);
    echo $twig->render('singlePost.twig', array('article' => $article, 'page' => $page, 'comments' => $comments, 'id' => $id, 'pages' => $pages, 'commentpage' => $commentpage));
}

function addComment($id, $content) 
{
    $postMapper = new PostManager;
    $postMapper->addComment($id, $content);
    $hashtag = $postMapper->lastComment($id);
    header("Location: index.php?action=single&id=$id#comment$hashtag[0]");
}

//URL de redirection après modif' ou suppression
function urlcomment($id, $comment) {
    $postMapper = new PostManager;
    $comment--;
    while ($postMapper->commentExists($comment)->fetch() == false) //Vu que l'autoincrémentation ne remplace pas les supprimés
    {
        $comment--; //Vu que la navbar est en fixe, il faut décaller
    }
    return "Location: index.php?action=single&id=$id#comment$comment";
}

function deleteComment($id, $comment)
{
    $postMapper = new PostManager;
    $delete = $postMapper->deleteComment($comment);
    $urlcomment = urlcomment($id, $comment);
    header($urlcomment);
    //var_dump($delete);
}

function updateComment($id, $comment, $content)
{
    $postMapper = new PostManager;
    $postMapper->updateComment($comment, $content);
    $urlcomment = urlcomment($id, $comment);
    header($urlcomment);
}

