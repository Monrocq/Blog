<?php

function accueil($twig) 
{
    echo $twig->render('homeView.twig', array('titre' => 'Ballinity - Home'));
}

function liste($twig, $page) 
{
    $postMapper = new PostManager;
    $articles = $postMapper->getList($page);
    $nbarticles = $postMapper->getNbArticles();
    $numpage = 0;
    $pages = array();
    for ($i = (int)$nbarticles[0]; $i > 0; $i -= 5) {
        $numpage++;
        $pages[] = $numpage;
    }

    echo $twig->render('listPosts.twig', array('titre' => 'Ballinity - Articles', 'articles' => $articles, 'pages' => $pages, 'page' => $page));
}

function single($twig, $id, $page)
{
    $postMapper = new PostManager;
    $article = $postMapper->getArticle($id);
    $comments = $postMapper->getComments($id);
    echo $twig->render('singlePost.twig', array('article' => $article, 'page' => $page, 'comments' => $comments, 'id' => $id));
}

function addComment($id, $content) 
{
    $postMapper = new PostManager;
    $postMapper->addComment($id, $content);
    header("Location: index.php?action=single&id=$id");
}

function deleteComment($id, $comment)
{
    $postMapper = new PostManager;
    $delete = $postMapper->deleteComment($comment);
    header("Location: index.php?action=single&id=$id");
    //var_dump($delete);
}

